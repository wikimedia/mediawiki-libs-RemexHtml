<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\HTMLData;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\Tokenizer\TokenHandler;

class Dispatcher implements TokenHandler {
	const INITIAL = 1;
	const BEFORE_HTML = 2;
	const BEFORE_HEAD = 3;
	const IN_HEAD = 4;
	const IN_HEAD_NOSCRIPT = 5;
	const AFTER_HEAD = 6;
	const IN_BODY = 7;
	const TEXT = 8;
	const IN_TABLE = 9;
	const IN_TABLE_TEXT = 10;
	const IN_CAPTION = 11;
	const IN_COLUMN_GROUP = 12;
	const IN_TABLE_BODY = 13;
	const IN_ROW = 14;
	const IN_CELL = 15;
	const IN_SELECT = 16;
	const IN_SELECT_IN_TABLE = 17;
	const IN_TEMPLATE = 18;
	const AFTER_BODY = 19;
	const IN_FRAMESET = 20;
	const AFTER_FRAMESET = 21;
	const AFTER_AFTER_BODY = 22;
	const AFTER_AFTER_FRAMESET = 23;
	const IN_FOREIGN_CONTENT = 24;
	const IN_PRE = 25;
	const IN_TEXTAREA = 26;

	protected static $handlerClasses = [
		self::INITIAL => Initial::class,
		self::BEFORE_HTML => BeforeHtml::class,
		self::BEFORE_HEAD => BeforeHead::class,
		self::IN_HEAD => InHead::class,
		self::IN_HEAD_NOSCRIPT => InHeadNoscript::class,
		self::AFTER_HEAD => AfterHead::class,
		self::IN_BODY => InBody::class,
		self::TEXT => Text::class,
		self::IN_TABLE => InTable::class,
		self::IN_TABLE_TEXT => InTableText::class,
		self::IN_CAPTION => InCaption::class,
		self::IN_COLUMN_GROUP => InColumnGroup::class,
		self::IN_TABLE_BODY => InTableBody::class,
		self::IN_ROW => InRow::class,
		self::IN_CELL => InCell::class,
		self::IN_SELECT => InSelect::class,
		self::IN_SELECT_IN_TABLE => InSelectInTable::class,
		self::IN_TEMPLATE => InTemplate::class,
		self::AFTER_BODY => AfterBody::class,
		self::IN_FRAMESET => InFrameset::class,
		self::AFTER_FRAMESET => AfterFrameset::class,
		self::AFTER_AFTER_BODY => AfterAfterBody::class,
		self::AFTER_AFTER_FRAMESET => AfterAfterFrameset::class,
		self::IN_FOREIGN_CONTENT => InForeignContent::class,
		self::IN_PRE => InPre::class,
		self::IN_TEXTAREA => InTextarea::class,
	];

	// Public shortcuts for "using the rules for" actions
	public $inHead;
	public $inBody;
	public $inTable;
	public $inSelect;
	public $inTemplate;
	public $inForeign;

	protected $builder;
	protected $handler;
	protected $dispatchTable;
	protected $mode;
	protected $originalMode;

	public $ack;
	public $templateModeStack;

	public function __construct( TreeBuilder $builder ) {
		$this->builder = $builder;
		$this->templateModeStack = new TemplateModeStack;

		$this->dispatchTable = [];
		foreach ( self::$handlerClasses as $mode => $class ) {
			$this->dispatchTable[$mode] = new $class( $builder, $this );
		}

		$this->inHead = $this->dispatchTable[self::IN_HEAD];
		$this->inBody = $this->dispatchTable[self::IN_BODY];
		$this->inTable = $this->dispatchTable[self::IN_TABLE];
		$this->inSelect = $this->dispatchTable[self::IN_SELECT];
		$this->inTemplate = $this->dispatchTable[self::IN_TEMPLATE];
		$this->inForeign = $this->dispatchTable[self::IN_FOREIGN_CONTENT];

		$this->switchMode( self::INITIAL );
	}

	public function switchMode( $mode ) {
		$this->mode = $mode;
		return $this->handler = $this->dispatchTable[$mode];
	}

	public function switchAndSave( $mode ) {
		$this->originalMode = $this->mode;
		$this->mode = $mode;
		return $this->handler = $this->dispatchTable[$mode];
	}

	public function restoreMode() {
		if ( $this->originalMode === null ) {
			throw new TreeBuilderError( "original insertion mode is not set" );
		}
		$mode = $this->mode = $this->originalMode;
		$this->originalMode = null;
		return $this->handler = $this->dispatchTable[$mode];
	}

	/**
	 * Get the handler for the current insertion mode in HTML content.
	 * This is used by the "in foreign" handler to execute the HTML insertion
	 * mode. It does not necessarily correspond to the handler currently being
	 * executed.
	 *
	 * @return InsertionMode
	 */
	public function getHandler() {
		return $this->handler;
	}

	/**
	 * True if we are in a table mode, for the purposes of switching to
	 * IN_SELECT_IN_TABLE as opposed to IN_SELECT.
	 */
	public function isInTableMode() {
		static $tableModes = [
			self::IN_TABLE => true,
			self::IN_CAPTION => true,
			self::IN_TABLE_BODY => true,
			self::IN_ROW => true,
			self::IN_CELL => true ];
		return isset( $tableModes[$this->mode] );
	}

	/**
	 * Reset the insertion mode appropriately
	 */
	public function reset() {
		return $this->switchMode( $this->getAppropriateMode() );
	}

	private function getAppropriateMode() {
		$builder = $this->builder;
		$stack = $builder->stack;
		$last = false;
		$node = $stack->current;
		for ( $idx = $stack->length() - 1; $idx >= 0; $idx-- ) {
			$node = $stack->item( $idx );
			if ( $idx === 0 ) {
				$last = true;
				if ( $builder->isFragment ) {
					$node = $builder->fragmentContext;
				}
			}

			switch ( $node->htmlName ) {
			case 'select':
				if ( $last ) {
					return self::IN_SELECT;
				}
				for ( $ancestorIdx = $idx - 1; $ancestorIdx >= 1; $ancestorIdx-- ) {
					$ancestor = $stack->item( $ancestorIdx );
					if ( $ancestor->htmlName === 'template' ) {
						return self::IN_SELECT;
					} elseif ( $ancestor->htmlName === 'table' ) {
						return self::IN_SELECT_IN_TABLE;
					}
				}
				return self::IN_SELECT;

			case 'td':
			case 'th':
				if ( !$last ) {
					return self::IN_CELL;
				}
				break;

			case 'tr':
				return self::IN_ROW;

			case 'tbody':
			case 'thead':
			case 'tfoot':
				return self::IN_TABLE_BODY;

			case 'caption':
				return self::IN_CAPTION;

			case 'colgroup':
				return self::IN_COLUMN_GROUP;

			case 'table':
				return self::IN_TABLE;

			case 'template':
				return $this->templateModeStack->current;

			case 'head':
				if ( $last ) {
					return self::IN_BODY;
				} else {
					return self::IN_HEAD;
				}

			case 'body':
				return self::IN_BODY;

			case 'frameset':
				return self::IN_FRAMESET;

			case 'html':
				if ( $builder->headElement === null ) {
					return self::BEFORE_HEAD;
				} else {
					return self::AFTER_HEAD;
				}
			}
		}

		return self::IN_BODY;
	}

	public function startDocument( $namespace, $name ) {
		$this->builder->startDocument( $namespace, $name );
		if ( $namespace !== null ) {
			if ( $namespace === HTMLData::NS_HTML && $name === 'template' ) {
				$this->templateModeStack->push( self::IN_TEMPLATE );
			}
			$this->reset();
		}
	}

	public function endDocument( $pos ) {
		$this->handler->endDocument( $pos );
	}

	public function error( $text, $pos ) {
		$this->builder->error( $text, $pos );
	}

	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$current = $this->builder->adjustedCurrentNode();
		if ( !$current
			|| $current->namespace === HTMLData::NS_HTML
			|| $current->isMathmlTextIntegration()
			|| $current->isHtmlIntegration()
		) {
			$this->handler->characters( $text, $start, $length, $sourceStart, $sourceLength );
		} else {
			$this->inForeign->characters(
				$text, $start, $length, $sourceStart, $sourceLength );
		}
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$this->ack = false;
		$current = $this->builder->adjustedCurrentNode();
		if ( !$current
			|| $current->namespace === HTMLData::NS_HTML
			|| ( $current->isMathmlTextIntegration()
				&& $name !== 'mglyph'
				&& $name !== 'malignmark'
			)
			|| ( $name === 'svg'
				&& $current->namespace === HTMLData::NS_MATHML
				&& $current->name === 'annotation-xml'
			)
			|| $current->isHtmlIntegration()
		) {
			$this->handler->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
		} else {
			$this->inForeign->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
		}
		if ( $selfClose && !$this->ack ) {
			$this->builder->error( "unacknowledged self-closing tag", $sourceStart );
		}
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		$current = $this->builder->adjustedCurrentNode();
		if ( !$current || $current->namespace === HTMLData::NS_HTML ) {
			$this->handler->endTag( $name, $sourceStart, $sourceLength );
		} else {
			$this->inForeign->endTag( $name, $sourceStart, $sourceLength );
		}
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$current = $this->builder->adjustedCurrentNode();
		if ( !$current || $current->namespace === HTMLData::NS_HTML ) {
			$this->handler->doctype( $name, $public, $system, $quirks,
				$sourceStart, $sourceLength );
		} else {
			$this->inForeign->doctype( $name, $public, $system, $quirks,
				$sourceStart, $sourceLength );
		}
	}

	public function comment( $text, $sourceStart, $sourceLength ) {
		$current = $this->builder->adjustedCurrentNode();
		if ( !$current || $current->namespace === HTMLData::NS_HTML ) {
			$this->handler->comment( $text, $sourceStart, $sourceLength );
		} else {
			$this->inForeign->comment( $text, $sourceStart, $sourceLength );
		}
	}
}
