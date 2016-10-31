<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class Stack {
	const SCOPE_DEFAULT = 0;
	const SCOPE_LIST = 1;
	const SCOPE_BUTTON = 2;
	const SCOPE_TABLE = 3;
	const SCOPE_SELECT = 4;

	static private $tableScopes = [ self::SCOPE_DEFAULT, self::SCOPE_LIST, self::SCOPE_BUTTON,
		self::SCOPE_TABLE, self::SCOPE_SELECT ];
	static private $regularScopes = [ self::SCOPE_DEFAULT, self::SCOPE_LIST, self::SCOPE_BUTTON,
		self::SCOPE_SELECT ];
	static private $listScopes = [ self::SCOPE_LIST, self::SCOPE_SELECT ];
	static private $buttonScopes = [ self::SCOPE_BUTTON, self::SCOPE_SELECT ];
	static private $selectOnly = [ self::SCOPE_SELECT ];

	private $elements = [];
	private $scopes = [
		self::SCOPE_DEFAULT => [],
		self::SCOPE_LIST => [],
		self::SCOPE_BUTTON => [],
		self::SCOPE_TABLE => [],
		self::SCOPE_SELECT => []
	];
	private $scopeStacks = [
		self::SCOPE_DEFAULT => [],
		self::SCOPE_LIST => [],
		self::SCOPE_BUTTON => [],
		self::SCOPE_TABLE => [],
		self::SCOPE_SELECT => []
	];

	public $current;


	static private $mathBreakers = [
		'mi' => true,
		'mo' => true,
		'mn' => true,
		'ms' => true,
		'mtext' => true,
		'annotation-xml' => true
	];

	static private $svgBreakers = [
		'foreignObject',
		'desc',
		'title'
	];

	/**
	 * If you compile every predicate of the form "an X element in Y scope" in
	 * the HTML 5 spec, you discover that every element name X corresponds to
	 * at most one such scope Y. This is useful because it means when we see
	 * a new element, we need to add it to at most one scope cache.
	 *
	 * This is a list of such statements in the spec, and the scope they relate
	 * to. All formatting elements are included as SCOPE_DEFAULT since the AAA
	 * involves pulling an item out of the AFE list and checking if it is in
	 * scope.
	 */
	static private $predicateMap = [
		'a' => self::SCOPE_DEFAULT,
		'address' => self::SCOPE_DEFAULT,
		'applet' => self::SCOPE_DEFAULT,
		'article' => self::SCOPE_DEFAULT,
		'aside' => self::SCOPE_DEFAULT,
		'b' => self::SCOPE_DEFAULT,
		'big' => self::SCOPE_DEFAULT,
		'blockquote' => self::SCOPE_DEFAULT,
		'body' => self::SCOPE_DEFAULT,
		'button' => self::SCOPE_DEFAULT,
		'caption' => self::SCOPE_TABLE,
		'center' => self::SCOPE_DEFAULT,
		'code' => self::SCOPE_DEFAULT,
		'dd' => self::SCOPE_DEFAULT,
		'details' => self::SCOPE_DEFAULT,
		'dialog' => self::SCOPE_DEFAULT,
		'dir' => self::SCOPE_DEFAULT,
		'div' => self::SCOPE_DEFAULT,
		'dl' => self::SCOPE_DEFAULT,
		'dt' => self::SCOPE_DEFAULT,
		'em' => self::SCOPE_DEFAULT,
		'fieldset' => self::SCOPE_DEFAULT,
		'figcaption' => self::SCOPE_DEFAULT,
		'figure' => self::SCOPE_DEFAULT,
		'font' => self::SCOPE_DEFAULT,
		'footer' => self::SCOPE_DEFAULT,
		'form' => self::SCOPE_DEFAULT,
		'h1' => self::SCOPE_DEFAULT,
		'h2' => self::SCOPE_DEFAULT,
		'h3' => self::SCOPE_DEFAULT,
		'h4' => self::SCOPE_DEFAULT,
		'h5' => self::SCOPE_DEFAULT,
		'h6' => self::SCOPE_DEFAULT,
		'header' => self::SCOPE_DEFAULT,
		'hgroup' => self::SCOPE_DEFAULT,
		'i' => self::SCOPE_DEFAULT,
		'li' => self::SCOPE_LIST,
		'listing' => self::SCOPE_DEFAULT,
		'main' => self::SCOPE_DEFAULT,
		'marquee' => self::SCOPE_DEFAULT,
		'nav' => self::SCOPE_DEFAULT,
		'nobr' => self::SCOPE_DEFAULT,
		'object' => self::SCOPE_DEFAULT,
		'ol' => self::SCOPE_DEFAULT,
		'p' => self::SCOPE_BUTTON,
		'pre' => self::SCOPE_DEFAULT,
		'ruby' => self::SCOPE_DEFAULT,
		's' => self::SCOPE_DEFAULT,
		'section' => self::SCOPE_DEFAULT,
		'select' => self::SCOPE_SELECT,
		'small' => self::SCOPE_DEFAULT,
		'strike' => self::SCOPE_DEFAULT,
		'strong' => self::SCOPE_DEFAULT,
		'summary' => self::SCOPE_DEFAULT,
		'table' => self::SCOPE_TABLE,
		'tbody' => self::SCOPE_TABLE,
		'td' => self::SCOPE_TABLE,
		'tfoot' => self::SCOPE_TABLE,
		'th' => self::SCOPE_TABLE,
		'thead' => self::SCOPE_TABLE,
		'tr' => self::SCOPE_TABLE,
		'tt' => self::SCOPE_DEFAULT,
		'u' => self::SCOPE_DEFAULT,
		'ul' => self::SCOPE_DEFAULT,
	];

	/**
	 * Get the list of scopes that are broken for a given namespace and
	 * element name.
	 */
	private function getBrokenScopes( $ns, $name ) {
		if ( $ns === HTMLData::NS_HTML ) {
			switch ( $name ) {
			case 'html':
			case 'table':
			case 'template':
				return self::$tableScopes;
			case 'applet':
			case 'caption':
			case 'td':
			case 'th':
			case 'marquee':
			case 'object':
				return self::$regularScopes;
			case 'ol':
			case 'ul':
				return self::$listScopes;
			case 'button':
				return self::$buttonScopes;
			case 'option':
			case 'optgroup':
				return [];
			default:
				return self::$selectOnly;
			}
		} elseif ( $ns === HTMLData::NS_MATHML ) {
			if ( isset( self::$mathBreakers[$name] ) ) {
				return self::$regularScopes;
			} else {
				return self::$selectOnly;
			}
		} elseif ( $ns === HTMLData::NS_SVG ) {
			if ( isset( self::$svgBreakers[$name] ) ) {
				return self::$regularScopes;
			} else {
				return self::$selectOnly;
			}
		} else {
			return self::$selectOnly;
		}
	}

	public function push( Element $elt ) {
		// Update the stack store
		$n = count( $this->elements );
		$this->elements[$n] = $elt;
		// Update the current node and index cache
		$this->current = $elt;
		$elt->stackIndex = $n;
		// Update the scope cache
		foreach ( $this->getBrokenScopes( $elt->namespace, $elt->name ) as $scope ) {
			$this->scopeStacks[$scope][] = $this->scopes[$scope];
			$this->scopes[$scope] = null;
		}
		if ( $ns === HTMLData::NS_HTML && isset( self::$predicateMap[$name] ) ) {
			$elt->nextScope = $this->scopes[self::$predicateMap[$name]][$name];
			$this->scopes[self::$predicateMap[$name]][$name] = $elt;
		}
	}

	public function pop() {
		// Update the stack store, index cache and current node
		$elt = array_pop( $this->elements );
		$elt->stackIndex = null;
		$name = $elt->name;
		$n = count( $this->elements );
		$this->current = $n ? $this->elements[$n - 1] : null;
		// Update the scope cache
		if ( $elt->namespace === HTMLData::NS_HTML && isset( self::$predicateMap[$name] ) ) {
			$scope = self::$predicateMap[$name];
			if ( isset( $this->scopes[$scope][$name] ) ) {
				$this->scopes[$scope][$name]->nextScope = null;
			}
			$this->scopes[$scope][$name] = $elt->nextScope;
		}
		foreach ( $this->getBrokenScopes( $elt->namespace, $elt->name ) as $scope ) {
			$this->scopes[$scope] = array_pop( $this->scopeStacks[$scope] );
		}
		return $elt;
	}

	public function replaceAt( $idx, Element $elt ) {
		$oldElt = $this->elements[$idx];
		// AAA calls this function only for elements with the same name, which
		// simplifies the scope cache update
		if ( $oldElt->name !== $elt->name ) {
			throw new \Exception( __METHOD__.' can only be called for elements of the same name' );
		}
		// Find the old element in its scope list
		
	}

	public function isInScope( $name ) {
		if ( self::$predicateMap[$name] !== self::SCOPE_DEFAULT ) {
			throw new \Exception( "Unexpected predicate: \"$name is in scope\"" );
		}
		return !empty( $this->scopes[self::SCOPE_DEFAULT][$name] );
	}

	public function isElementInScope( Element $elt ) {
		$name = $elt->name;
		if ( self::$predicateMap[$name] !== self::SCOPE_DEFAULT ) {
			throw new \Exception( "Unexpected predicate: \"$name is in scope\"" );
		}
		if ( !empty( $this->scopes[self::SCOPE_DEFAULT][$name] ) ) {
			$scopeMember = $this->scopes[self::SCOPE_DEFAULT][$name];
			while ( $scopeMember ) {
				if ( $scopeMember === $elt ) {
					return true;
				}
				$scopeMember = $scopeMember->nextScope;
			}
		}
		return false;
	}

	public function isInListScope( $name ) {
		if ( self::$predicateMap[$name] !== self::SCOPE_LIST ) {
			throw new \Exception( "Unexpected predicate: \"$name is in list scope\"" );
		}
		return !empty( $this->scopes[self::SCOPE_LIST][$name] );
	}

	public function isInButtonScope( $name ) {
		if ( self::$predicateMap[$name] !== self::SCOPE_BUTTON ) {
			throw new \Exception( "Unexpected predicate: \"$name is in button scope\"" );
		}
		return !empty( $this->scopes[self::SCOPE_BUTTON][$name] );
	}

	public function isInTableScope( $name ) {
		if ( self::$predicateMap[$name] !== self::SCOPE_TABLE ) {
			throw new \Exception( "Unexpected predicate: \"$name is in table scope\"" );
		}
		return !empty( $this->scopes[self::SCOPE_TABLE][$name] );
	}

	public function isInSelectScope( $name ) {
		if ( self::$predicateMap[$name] !== self::SCOPE_SELECT ) {
			throw new \Exception( "Unexpected predicate: \"$name is in select scope\"" );
		}
		return !empty( $this->scopes[self::SCOPE_SELECT][$name] );
	}

	public function item( $idx ) {
		return $this->elements[$idx];
	}
}
