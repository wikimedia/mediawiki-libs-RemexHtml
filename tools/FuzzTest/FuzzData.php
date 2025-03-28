<?php

namespace Wikimedia\RemexHtml\Tools\FuzzTest;

class FuzzData {
	/**
	 * All tag names listed in w3schools.com as of 2016-12-14
	 */
	public const W3SCHOOLS_TAG_NAMES = [
		'a',
		'abbr',
		'acronym',
		'address',
		'applet',
		'area',
		'article',
		'aside',
		'audio',
		'b',
		'base',
		'basefont',
		'bdi',
		'bdo',
		'big',
		'blockquote',
		'body',
		'br',
		'button',
		'canvas',
		'caption',
		'center',
		'cite',
		'code',
		'col',
		'colgroup',
		'datalist',
		'dd',
		'del',
		'details',
		'dfn',
		'dialog',
		'dir',
		'div',
		'dl',
		'dt',
		'em',
		'embed',
		'fieldset',
		'figcaption',
		'figure',
		'font',
		'footer',
		'form',
		'frame',
		'frameset',
		'h1',
		'head',
		'header',
		'hr',
		'html',
		'i',
		'iframe',
		'img',
		'input',
		'ins',
		'kbd',
		'keygen',
		'label',
		'legend',
		'li',
		'link',
		'main',
		'map',
		'mark',
		'menu',
		'menuitem',
		'meta',
		'meter',
		'nav',
		'noframes',
		'noscript',
		'object',
		'ol',
		'optgroup',
		'option',
		'output',
		'p',
		'param',
		'pre',
		'progress',
		'q',
		'rp',
		'rt',
		'ruby',
		's',
		'samp',
		'script',
		'section',
		'select',
		'small',
		'source',
		'span',
		'strike',
		'strong',
		'style',
		'sub',
		'summary',
		'sup',
		'table',
		'tbody',
		'td',
		'textarea',
		'tfoot',
		'th',
		'thead',
		'time',
		'title',
		'tr',
		'track',
		'tt',
		'u',
		'ul',
		'var',
		'video',
		'wbr',
	];

	/**
	 * Some interesting attribute names
	 */
	public const ATTRIBUTE_NAMES = [
		// SVG camel case
		'definitionurl',
		'attributename',
		'attributetype',
		'basefrequency',
		'baseprofile',
		'calcmode',
		'clippathunits',
		'contentscripttype',
		'contentstyletype',
		'diffuseconstant',
		'edgemode',
		'externalresourcesrequired',
		'filterres',
		'filterunits',
		'glyphref',
		'gradienttransform',
		'gradientunits',
		'kernelmatrix',
		'kernelunitlength',
		'keypoints',
		'keysplines',
		'keytimes',
		'lengthadjust',
		'limitingconeangle',
		'markerheight',
		'markerunits',
		'markerwidth',
		'maskcontentunits',
		'maskunits',
		'numoctaves',
		'pathlength',
		'patterncontentunits',
		'patterntransform',
		'patternunits',
		'pointsatx',
		'pointsaty',
		'pointsatz',
		'preservealpha',
		'preserveaspectratio',
		'primitiveunits',
		'refx',
		'refy',
		'repeatcount',
		'repeatdur',
		'requiredextensions',
		'requiredfeatures',
		'specularconstant',
		'specularexponent',
		'spreadmethod',
		'startoffset',
		'stddeviation',
		'stitchtiles',
		'surfacescale',
		'systemlanguage',
		'tablevalues',
		'targetx',
		'targety',
		'textlength',
		'viewbox',
		'viewtarget',
		'xchannelselector',
		'ychannelselector',
		'zoomandpan',

		// Namespaces
		'xlink:actuate',
		'xlink:arcrole',
		'xlink:href',
		'xlink:role',
		'xlink:show',
		'xlink:title',
		'xlink:type',
		'xml:base',
		'xml:lang',
		'xml:space',
		'xmlns:xlink',

		// Other attribute names referred to in the standard
		'type',
		'encoding',
	];

	/**
	 * Special attribute values which are referred to in the standard.
	 */
	public const ATTRIBUTE_VALUES = [
		'hidden',
		'text/html',
		'application/xhtml+xml',
		'HIDDEN',
		'TEXT/HTML',
		'APPLICATION/XHTML+XML',
	];
}
