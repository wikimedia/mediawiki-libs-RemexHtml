<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
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

	protected static $handlerClasses = [
		self::INITIAL => 'Initial',
		self::BEFORE_HTML => 'BeforeHtml',
		self::BEFORE_HEAD => 'BeforeHead',
		self::IN_HEAD => 'InHead',
		self::IN_HEAD_NOSCRIPT => 'InHeadNoScript',
		self::AFTER_HEAD => 'AfterHead',
		self::IN_BODY => 'InBody',
		self::TEXT => 'Text',
		self::IN_TABLE => 'InTable',
		self::IN_TABLE_TEXT => 'InTableText',
		self::IN_CAPTION => 'InCaption',
		self::IN_COLUMN_GROUP => 'InColumnGroup',
		self::IN_TABLE_BODY => 'InTableBody',
		self::IN_ROW => 'InRow',
		self::IN_CELL => 'InCell',
		self::IN_SELECT => 'InSelect',
		self::IN_SELECT_IN_TABLE => 'InSelectInTable',
		self::IN_TEMPLATE => 'InTemplate',
		self::AFTER_BODY => 'AfterBody',
		self::IN_FRAMESET => 'InFrameset',
		self::AFTER_FRAMESET => 'AfterFrameset',
		self::AFTER_AFTER_BODY => 'AfterAfterBody',
		self::AFTER_AFTER_FRAMESET => 'AfterAfterFrameset',
		self::IN_FOREIGN_CONTENT = 'InForeignContent';
	];

	// Public shortcuts for "using the rules for" actions
	public $inHead;
	public $inBody;
	public $inTable;
	public $inSelect;

	protected $mode;
	protected $originalMode;

	public function __construct( TreeBuilder $builder ) {
		$this->builder = $builder;

		$this->dispatchTable = [];
		foreach ( self::$handlerClasses as $mode => $class ) {
			$this->dispatchTable[$mode] = new $class( $builder, $this );
		}

		$this->inHead = $this->dispatchTable[self::IN_HEAD];
		$this->inBody = $this->dispatchTable[self::IN_BODY];
		$this->inTable = $this->dispatchTable[self::IN_TABLE];
		$this->inSelect = $this->dispatchTable[self::IN_SELECT];
	}

	public function switchMode( $mode, $save = false ) {
		if ( $save ) {
			$this->originalMode = $this->mode;
		}
		$this->mode = $mode;
		return $this->handler = $this->dispatchTable[$mode];
	}

	public function restoreMode() {
		if ( $this->originalMode === null ) {
			throw new BalancerError( "original insertion mode is not set" );
		}
		$mode = $this->originalMode;
		$this->originalMode = null;
		return $this->handler = $this->dispatchTable[$mode];
	}

	public function enterForeignContent() {
		$this->handler = $this->dispatchTable[self::IN_FOREIGN_CONTENT];
	}

	public function leaveForeignContent() {
		$this->handler = $this->dispatchTable[$mode];
	}

	/**
	 * True if we are in a table mode, for the purposes of switching to
	 * IN_SELECT_IN_TABLE as opposed to IN_SELECT.
	 */
	public function isInTableMode() {
		static $tableModes = [
			Dispatcher::IN_TABLE => true,
			Dispatcher::IN_CAPTION => true,
			Dispatcher::IN_TABLE_BODY => true,
			Dispatcher::IN_ROW => true,
			Dispatcher::IN_CELL => true ];
		return isset( $tableModes[$this->mode] );
	}

	function startDocument() {
		$this->builder->startDocument();
	}

	function endDocument() {
		$this->handler->endDocument();
	}

	function error( $text, $pos ) {
		$this->builder->error( $text, $pos );
	}

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$this->handler->characters( $text, $start, $length, $sourceStart, $sourceLength );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$this->handler->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		$this->handler->endTag( $name, $sourceStart, $sourceLength );
	}

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->handler->doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength );
	}

	function comment( $text, $sourceStart, $sourceLength ) {
		$this->handler->comment( $text, $sourceStart, $sourceLength );
	}
}
