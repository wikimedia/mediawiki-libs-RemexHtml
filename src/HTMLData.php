<?php
declare( strict_types = 1 );

/**
 * This data file is machine generated, see tools/GenerateDataFiles.php
 */

namespace Wikimedia\RemexHtml;

class HTMLData {
	public const NS_HTML = 'http://www.w3.org/1999/xhtml';
	public const NS_MATHML = 'http://www.w3.org/1998/Math/MathML';
	public const NS_SVG = 'http://www.w3.org/2000/svg';
	public const NS_XLINK = 'http://www.w3.org/1999/xlink';
	public const NS_XML = 'http://www.w3.org/XML/1998/namespace';
	public const NS_XMLNS = 'http://www.w3.org/2000/xmlns/';

	public const SPECIAL = [
		'http://www.w3.org/1999/xhtml' => [
			'address' => true,
			'applet' => true,
			'area' => true,
			'article' => true,
			'aside' => true,
			'base' => true,
			'basefont' => true,
			'bgsound' => true,
			'blockquote' => true,
			'body' => true,
			'br' => true,
			'button' => true,
			'caption' => true,
			'center' => true,
			'col' => true,
			'colgroup' => true,
			'dd' => true,
			'details' => true,
			'dir' => true,
			'div' => true,
			'dl' => true,
			'dt' => true,
			'embed' => true,
			'fieldset' => true,
			'figcaption' => true,
			'figure' => true,
			'footer' => true,
			'form' => true,
			'frame' => true,
			'frameset' => true,
			'h1' => true,
			'h2' => true,
			'h3' => true,
			'h4' => true,
			'h5' => true,
			'h6' => true,
			'head' => true,
			'header' => true,
			'hr' => true,
			'html' => true,
			'iframe' => true,
			'img' => true,
			'input' => true,
			'li' => true,
			'link' => true,
			'listing' => true,
			'main' => true,
			'marquee' => true,
			'menu' => true,
			'menuitem' => true,
			'meta' => true,
			'nav' => true,
			'noembed' => true,
			'noframes' => true,
			'noscript' => true,
			'object' => true,
			'ol' => true,
			'p' => true,
			'param' => true,
			'plaintext' => true,
			'pre' => true,
			'script' => true,
			'section' => true,
			'select' => true,
			'source' => true,
			'style' => true,
			'summary' => true,
			'table' => true,
			'tbody' => true,
			'td' => true,
			'template' => true,
			'textarea' => true,
			'tfoot' => true,
			'th' => true,
			'thead' => true,
			'title' => true,
			'tr' => true,
			'track' => true,
			'ul' => true,
			'wbr' => true,
			'xmp' => true,
		],
		'http://www.w3.org/1998/Math/MathML' => [
			'mi' => true,
			'mo' => true,
			'mn' => true,
			'ms' => true,
			'mtext' => true,
			'annotation-xml' => true,
		],
		'http://www.w3.org/2000/svg' => [
			'foreignObject' => true,
			'desc' => true,
			'title' => true,
		],
	];

	/**
	 * Properties of HTML tags.  Note that these sets are a union of
	 * the W3C and WHATWG definitions, which differ slightly.
	 */
	public const TAGS = [
		'void' => [
			'area' => true,
			'base' => true,
			'basefont' => true,
			'bgsound' => true,
			'br' => true,
			'col' => true,
			'embed' => true,
			'frame' => true,
			'hr' => true,
			'img' => true,
			'input' => true,
			'keygen' => true,
			'link' => true,
			'menuitem' => true,
			'meta' => true,
			'param' => true,
			'source' => true,
			'spacer' => true,
			'track' => true,
			'wbr' => true,
		],
		'prefixLF' => [
			'pre' => true,
			'textarea' => true,
			'listing' => true,
		],
		'rawText' => [
			'style' => true,
			'script' => true,
			'xmp' => true,
			'iframe' => true,
			'noembed' => true,
			'noframes' => true,
			'plaintext' => true,
		],
	];

	public const NAMED_ENTITY_REGEX = '
		CounterClockwiseContourIntegral;|
		ClockwiseContourIntegral;|
		DoubleLongLeftRightArrow;|
		NotNestedGreaterGreater;|
		DiacriticalDoubleAcute;|
		NotSquareSupersetEqual;|
		CloseCurlyDoubleQuote;|
		DoubleContourIntegral;|
		FilledVerySmallSquare;|
		NegativeVeryThinSpace;|
		NotPrecedesSlantEqual;|
		NotRightTriangleEqual;|
		NotSucceedsSlantEqual;|
		CapitalDifferentialD;|
		DoubleLeftRightArrow;|
		DoubleLongRightArrow;|
		EmptyVerySmallSquare;|
		NestedGreaterGreater;|
		NotDoubleVerticalBar;|
		NotGreaterSlantEqual;|
		NotLeftTriangleEqual;|
		NotSquareSubsetEqual;|
		OpenCurlyDoubleQuote;|
		ReverseUpEquilibrium;|
		DoubleLongLeftArrow;|
		DownLeftRightVector;|
		LeftArrowRightArrow;|
		NegativeMediumSpace;|
		NotGreaterFullEqual;|
		NotRightTriangleBar;|
		RightArrowLeftArrow;|
		SquareSupersetEqual;|
		leftrightsquigarrow;|
		DownRightTeeVector;|
		DownRightVectorBar;|
		LongLeftRightArrow;|
		Longleftrightarrow;|
		NegativeThickSpace;|
		NotLeftTriangleBar;|
		PrecedesSlantEqual;|
		ReverseEquilibrium;|
		RightDoubleBracket;|
		RightDownTeeVector;|
		RightDownVectorBar;|
		RightTriangleEqual;|
		SquareIntersection;|
		SucceedsSlantEqual;|
		blacktriangleright;|
		longleftrightarrow;|
		DoubleUpDownArrow;|
		DoubleVerticalBar;|
		DownLeftTeeVector;|
		DownLeftVectorBar;|
		FilledSmallSquare;|
		GreaterSlantEqual;|
		LeftDoubleBracket;|
		LeftDownTeeVector;|
		LeftDownVectorBar;|
		LeftTriangleEqual;|
		NegativeThinSpace;|
		NotGreaterGreater;|
		NotLessSlantEqual;|
		NotNestedLessLess;|
		NotReverseElement;|
		NotSquareSuperset;|
		NotTildeFullEqual;|
		RightAngleBracket;|
		RightUpDownVector;|
		SquareSubsetEqual;|
		VerticalSeparator;|
		blacktriangledown;|
		blacktriangleleft;|
		leftrightharpoons;|
		rightleftharpoons;|
		twoheadrightarrow;|
		DiacriticalAcute;|
		DiacriticalGrave;|
		DiacriticalTilde;|
		DoubleRightArrow;|
		DownArrowUpArrow;|
		EmptySmallSquare;|
		GreaterEqualLess;|
		GreaterFullEqual;|
		LeftAngleBracket;|
		LeftUpDownVector;|
		LessEqualGreater;|
		NonBreakingSpace;|
		NotPrecedesEqual;|
		NotRightTriangle;|
		NotSucceedsEqual;|
		NotSucceedsTilde;|
		NotSupersetEqual;|
		RightTriangleBar;|
		RightUpTeeVector;|
		RightUpVectorBar;|
		UnderParenthesis;|
		UpArrowDownArrow;|
		circlearrowright;|
		downharpoonright;|
		ntrianglerighteq;|
		rightharpoondown;|
		rightrightarrows;|
		twoheadleftarrow;|
		vartriangleright;|
		CloseCurlyQuote;|
		ContourIntegral;|
		DoubleDownArrow;|
		DoubleLeftArrow;|
		DownRightVector;|
		LeftRightVector;|
		LeftTriangleBar;|
		LeftUpTeeVector;|
		LeftUpVectorBar;|
		LowerRightArrow;|
		NotGreaterEqual;|
		NotGreaterTilde;|
		NotHumpDownHump;|
		NotLeftTriangle;|
		NotSquareSubset;|
		OverParenthesis;|
		RightDownVector;|
		ShortRightArrow;|
		UpperRightArrow;|
		bigtriangledown;|
		circlearrowleft;|
		curvearrowright;|
		downharpoonleft;|
		leftharpoondown;|
		leftrightarrows;|
		nLeftrightarrow;|
		nleftrightarrow;|
		ntrianglelefteq;|
		rightleftarrows;|
		rightsquigarrow;|
		rightthreetimes;|
		straightepsilon;|
		trianglerighteq;|
		vartriangleleft;|
		DiacriticalDot;|
		DoubleRightTee;|
		DownLeftVector;|
		GreaterGreater;|
		HorizontalLine;|
		InvisibleComma;|
		InvisibleTimes;|
		LeftDownVector;|
		LeftRightArrow;|
		Leftrightarrow;|
		LessSlantEqual;|
		LongRightArrow;|
		Longrightarrow;|
		LowerLeftArrow;|
		NestedLessLess;|
		NotGreaterLess;|
		NotLessGreater;|
		NotSubsetEqual;|
		NotVerticalBar;|
		OpenCurlyQuote;|
		ReverseElement;|
		RightTeeVector;|
		RightVectorBar;|
		ShortDownArrow;|
		ShortLeftArrow;|
		SquareSuperset;|
		TildeFullEqual;|
		UpperLeftArrow;|
		ZeroWidthSpace;|
		curvearrowleft;|
		doublebarwedge;|
		downdownarrows;|
		hookrightarrow;|
		leftleftarrows;|
		leftrightarrow;|
		leftthreetimes;|
		longrightarrow;|
		looparrowright;|
		nshortparallel;|
		ntriangleright;|
		rightarrowtail;|
		rightharpoonup;|
		trianglelefteq;|
		upharpoonright;|
		ApplyFunction;|
		DifferentialD;|
		DoubleLeftTee;|
		DoubleUpArrow;|
		LeftTeeVector;|
		LeftVectorBar;|
		LessFullEqual;|
		LongLeftArrow;|
		Longleftarrow;|
		NotEqualTilde;|
		NotTildeEqual;|
		NotTildeTilde;|
		Poincareplane;|
		PrecedesEqual;|
		PrecedesTilde;|
		RightArrowBar;|
		RightTeeArrow;|
		RightTriangle;|
		RightUpVector;|
		SucceedsEqual;|
		SucceedsTilde;|
		SupersetEqual;|
		UpEquilibrium;|
		VerticalTilde;|
		VeryThinSpace;|
		bigtriangleup;|
		blacktriangle;|
		divideontimes;|
		fallingdotseq;|
		hookleftarrow;|
		leftarrowtail;|
		leftharpoonup;|
		longleftarrow;|
		looparrowleft;|
		measuredangle;|
		ntriangleleft;|
		shortparallel;|
		smallsetminus;|
		triangleright;|
		upharpoonleft;|
		varsubsetneqq;|
		varsupsetneqq;|
		DownArrowBar;|
		DownTeeArrow;|
		ExponentialE;|
		GreaterEqual;|
		GreaterTilde;|
		HilbertSpace;|
		HumpDownHump;|
		Intersection;|
		LeftArrowBar;|
		LeftTeeArrow;|
		LeftTriangle;|
		LeftUpVector;|
		NotCongruent;|
		NotHumpEqual;|
		NotLessEqual;|
		NotLessTilde;|
		Proportional;|
		RightCeiling;|
		RoundImplies;|
		ShortUpArrow;|
		SquareSubset;|
		UnderBracket;|
		VerticalLine;|
		blacklozenge;|
		exponentiale;|
		risingdotseq;|
		triangledown;|
		triangleleft;|
		varsubsetneq;|
		varsupsetneq;|
		CircleMinus;|
		CircleTimes;|
		Equilibrium;|
		GreaterLess;|
		LeftCeiling;|
		LessGreater;|
		MediumSpace;|
		NotLessLess;|
		NotPrecedes;|
		NotSucceeds;|
		NotSuperset;|
		OverBracket;|
		RightVector;|
		Rrightarrow;|
		RuleDelayed;|
		SmallCircle;|
		SquareUnion;|
		SubsetEqual;|
		UpDownArrow;|
		Updownarrow;|
		VerticalBar;|
		backepsilon;|
		blacksquare;|
		circledcirc;|
		circleddash;|
		curlyeqprec;|
		curlyeqsucc;|
		diamondsuit;|
		eqslantless;|
		expectation;|
		nRightarrow;|
		nrightarrow;|
		preccurlyeq;|
		precnapprox;|
		quaternions;|
		straightphi;|
		succcurlyeq;|
		succnapprox;|
		thickapprox;|
		updownarrow;|
		Bernoullis;|
		CirclePlus;|
		EqualTilde;|
		Fouriertrf;|
		ImaginaryI;|
		Laplacetrf;|
		LeftVector;|
		Lleftarrow;|
		NotElement;|
		NotGreater;|
		Proportion;|
		RightArrow;|
		RightFloor;|
		Rightarrow;|
		ThickSpace;|
		TildeEqual;|
		TildeTilde;|
		UnderBrace;|
		UpArrowBar;|
		UpTeeArrow;|
		circledast;|
		complement;|
		curlywedge;|
		eqslantgtr;|
		gtreqqless;|
		lessapprox;|
		lesseqqgtr;|
		lmoustache;|
		longmapsto;|
		mapstodown;|
		mapstoleft;|
		nLeftarrow;|
		nleftarrow;|
		nsubseteqq;|
		nsupseteqq;|
		precapprox;|
		rightarrow;|
		rmoustache;|
		sqsubseteq;|
		sqsupseteq;|
		subsetneqq;|
		succapprox;|
		supsetneqq;|
		upuparrows;|
		varepsilon;|
		varnothing;|
		Backslash;|
		CenterDot;|
		CircleDot;|
		Congruent;|
		Coproduct;|
		DoubleDot;|
		DownArrow;|
		DownBreve;|
		Downarrow;|
		HumpEqual;|
		LeftArrow;|
		LeftFloor;|
		Leftarrow;|
		LessTilde;|
		Mellintrf;|
		MinusPlus;|
		NotCupCap;|
		NotExists;|
		NotSubset;|
		OverBrace;|
		PlusMinus;|
		Therefore;|
		ThinSpace;|
		TripleDot;|
		UnionPlus;|
		backprime;|
		backsimeq;|
		bigotimes;|
		centerdot;|
		checkmark;|
		complexes;|
		dotsquare;|
		downarrow;|
		gtrapprox;|
		gtreqless;|
		gvertneqq;|
		heartsuit;|
		leftarrow;|
		lesseqgtr;|
		lvertneqq;|
		ngeqslant;|
		nleqslant;|
		nparallel;|
		nshortmid;|
		nsubseteq;|
		nsupseteq;|
		pitchfork;|
		rationals;|
		spadesuit;|
		subseteqq;|
		subsetneq;|
		supseteqq;|
		supsetneq;|
		therefore;|
		triangleq;|
		varpropto;|
		DDotrahd;|
		DotEqual;|
		Integral;|
		LessLess;|
		NotEqual;|
		NotTilde;|
		PartialD;|
		Precedes;|
		RightTee;|
		Succeeds;|
		SuchThat;|
		Superset;|
		Uarrocir;|
		UnderBar;|
		andslope;|
		angmsdaa;|
		angmsdab;|
		angmsdac;|
		angmsdad;|
		angmsdae;|
		angmsdaf;|
		angmsdag;|
		angmsdah;|
		angrtvbd;|
		approxeq;|
		awconint;|
		backcong;|
		barwedge;|
		bbrktbrk;|
		bigoplus;|
		bigsqcup;|
		biguplus;|
		bigwedge;|
		boxminus;|
		boxtimes;|
		bsolhsub;|
		capbrcup;|
		circledR;|
		circledS;|
		cirfnint;|
		clubsuit;|
		cupbrcap;|
		curlyvee;|
		cwconint;|
		doteqdot;|
		dotminus;|
		drbkarow;|
		dzigrarr;|
		elinters;|
		emptyset;|
		eqvparsl;|
		fpartint;|
		geqslant;|
		gesdotol;|
		gnapprox;|
		hksearow;|
		hkswarow;|
		imagline;|
		imagpart;|
		infintie;|
		integers;|
		intercal;|
		intlarhk;|
		laemptyv;|
		ldrushar;|
		leqslant;|
		lesdotor;|
		llcorner;|
		lnapprox;|
		lrcorner;|
		lurdshar;|
		mapstoup;|
		multimap;|
		naturals;|
		ncongdot;|
		notindot;|
		otimesas;|
		parallel;|
		plusacir;|
		pointint;|
		precneqq;|
		precnsim;|
		profalar;|
		profline;|
		profsurf;|
		raemptyv;|
		realpart;|
		rppolint;|
		rtriltri;|
		scpolint;|
		setminus;|
		shortmid;|
		smeparsl;|
		sqsubset;|
		sqsupset;|
		subseteq;|
		succneqq;|
		succnsim;|
		supseteq;|
		thetasym;|
		thicksim;|
		timesbar;|
		triangle;|
		triminus;|
		trpezium;|
		ulcorner;|
		urcorner;|
		varkappa;|
		varsigma;|
		vartheta;|
		Because;|
		Cayleys;|
		Cconint;|
		Cedilla;|
		Diamond;|
		DownTee;|
		Element;|
		Epsilon;|
		Implies;|
		LeftTee;|
		NewLine;|
		NoBreak;|
		NotLess;|
		Omicron;|
		OverBar;|
		Product;|
		UpArrow;|
		Uparrow;|
		Upsilon;|
		alefsym;|
		angrtvb;|
		angzarr;|
		asympeq;|
		backsim;|
		because;|
		bemptyv;|
		between;|
		bigcirc;|
		bigodot;|
		bigstar;|
		bnequiv;|
		boxplus;|
		ccupssm;|
		cemptyv;|
		cirscir;|
		coloneq;|
		congdot;|
		cudarrl;|
		cudarrr;|
		cularrp;|
		curarrm;|
		dbkarow;|
		ddagger;|
		ddotseq;|
		demptyv;|
		diamond;|
		digamma;|
		dotplus;|
		dwangle;|
		epsilon;|
		eqcolon;|
		equivDD;|
		gesdoto;|
		gtquest;|
		gtrless;|
		harrcir;|
		intprod;|
		isindot;|
		larrbfs;|
		larrsim;|
		lbrksld;|
		lbrkslu;|
		ldrdhar;|
		lesdoto;|
		lessdot;|
		lessgtr;|
		lesssim;|
		lotimes;|
		lozenge;|
		ltquest;|
		luruhar;|
		maltese;|
		minusdu;|
		napprox;|
		natural;|
		nearrow;|
		nexists;|
		notinva;|
		notinvb;|
		notinvc;|
		notniva;|
		notnivb;|
		notnivc;|
		npolint;|
		npreceq;|
		nsqsube;|
		nsqsupe;|
		nsubset;|
		nsucceq;|
		nsupset;|
		nvinfin;|
		nvltrie;|
		nvrtrie;|
		nwarrow;|
		olcross;|
		omicron;|
		orderof;|
		orslope;|
		pertenk;|
		planckh;|
		pluscir;|
		plussim;|
		plustwo;|
		precsim;|
		quatint;|
		questeq;|
		rarrbfs;|
		rarrsim;|
		rbrksld;|
		rbrkslu;|
		rdldhar;|
		realine;|
		rotimes;|
		ruluhar;|
		searrow;|
		simplus;|
		simrarr;|
		subedot;|
		submult;|
		subplus;|
		subrarr;|
		succsim;|
		supdsub;|
		supedot;|
		suphsol;|
		suphsub;|
		suplarr;|
		supmult;|
		supplus;|
		swarrow;|
		topfork;|
		triplus;|
		tritime;|
		uparrow;|
		upsilon;|
		uwangle;|
		vzigzag;|
		zigrarr;|
		Aacute;|
		Abreve;|
		Agrave;|
		Assign;|
		Atilde;|
		Barwed;|
		Bumpeq;|
		Cacute;|
		Ccaron;|
		Ccedil;|
		Colone;|
		Conint;|
		CupCap;|
		Dagger;|
		Dcaron;|
		DotDot;|
		Dstrok;|
		Eacute;|
		Ecaron;|
		Egrave;|
		Exists;|
		ForAll;|
		Gammad;|
		Gbreve;|
		Gcedil;|
		HARDcy;|
		Hstrok;|
		Iacute;|
		Igrave;|
		Itilde;|
		Jsercy;|
		Kcedil;|
		Lacute;|
		Lambda;|
		Lcaron;|
		Lcedil;|
		Lmidot;|
		Lstrok;|
		Nacute;|
		Ncaron;|
		Ncedil;|
		Ntilde;|
		Oacute;|
		Odblac;|
		Ograve;|
		Oslash;|
		Otilde;|
		Otimes;|
		Racute;|
		Rarrtl;|
		Rcaron;|
		Rcedil;|
		SHCHcy;|
		SOFTcy;|
		Sacute;|
		Scaron;|
		Scedil;|
		Square;|
		Subset;|
		Supset;|
		Tcaron;|
		Tcedil;|
		Tstrok;|
		Uacute;|
		Ubreve;|
		Udblac;|
		Ugrave;|
		Utilde;|
		Vdashl;|
		Verbar;|
		Vvdash;|
		Yacute;|
		Zacute;|
		Zcaron;|
		aacute;|
		abreve;|
		agrave;|
		andand;|
		angmsd;|
		angsph;|
		apacir;|
		approx;|
		atilde;|
		barvee;|
		barwed;|
		becaus;|
		bernou;|
		bigcap;|
		bigcup;|
		bigvee;|
		bkarow;|
		bottom;|
		bowtie;|
		boxbox;|
		bprime;|
		brvbar;|
		bullet;|
		bumpeq;|
		cacute;|
		capand;|
		capcap;|
		capcup;|
		capdot;|
		ccaron;|
		ccedil;|
		circeq;|
		cirmid;|
		colone;|
		commat;|
		compfn;|
		conint;|
		coprod;|
		copysr;|
		cularr;|
		cupcap;|
		cupcup;|
		cupdot;|
		curarr;|
		curren;|
		cylcty;|
		dagger;|
		daleth;|
		dcaron;|
		dfisht;|
		divide;|
		divonx;|
		dlcorn;|
		dlcrop;|
		dollar;|
		drcorn;|
		drcrop;|
		dstrok;|
		eacute;|
		easter;|
		ecaron;|
		ecolon;|
		egrave;|
		egsdot;|
		elsdot;|
		emptyv;|
		emsp13;|
		emsp14;|
		eparsl;|
		eqcirc;|
		equals;|
		equest;|
		female;|
		ffilig;|
		ffllig;|
		forall;|
		frac12;|
		frac13;|
		frac14;|
		frac15;|
		frac16;|
		frac18;|
		frac23;|
		frac25;|
		frac34;|
		frac35;|
		frac38;|
		frac45;|
		frac56;|
		frac58;|
		frac78;|
		gacute;|
		gammad;|
		gbreve;|
		gesdot;|
		gesles;|
		gtlPar;|
		gtrarr;|
		gtrdot;|
		gtrsim;|
		hairsp;|
		hamilt;|
		hardcy;|
		hearts;|
		hellip;|
		hercon;|
		homtht;|
		horbar;|
		hslash;|
		hstrok;|
		hybull;|
		hyphen;|
		iacute;|
		igrave;|
		iiiint;|
		iinfin;|
		incare;|
		inodot;|
		intcal;|
		iquest;|
		isinsv;|
		itilde;|
		jsercy;|
		kappav;|
		kcedil;|
		kgreen;|
		lAtail;|
		lacute;|
		lagran;|
		lambda;|
		langle;|
		larrfs;|
		larrhk;|
		larrlp;|
		larrpl;|
		larrtl;|
		latail;|
		lbrace;|
		lbrack;|
		lcaron;|
		lcedil;|
		ldquor;|
		lesdot;|
		lesges;|
		lfisht;|
		lfloor;|
		lharul;|
		llhard;|
		lmidot;|
		lmoust;|
		loplus;|
		lowast;|
		lowbar;|
		lparlt;|
		lrhard;|
		lsaquo;|
		lsquor;|
		lstrok;|
		lthree;|
		ltimes;|
		ltlarr;|
		ltrPar;|
		mapsto;|
		marker;|
		mcomma;|
		midast;|
		midcir;|
		middot;|
		minusb;|
		minusd;|
		mnplus;|
		models;|
		mstpos;|
		nVDash;|
		nVdash;|
		nacute;|
		nbumpe;|
		ncaron;|
		ncedil;|
		nearhk;|
		nequiv;|
		nesear;|
		nexist;|
		nltrie;|
		notinE;|
		nparsl;|
		nprcue;|
		nrarrc;|
		nrarrw;|
		nrtrie;|
		nsccue;|
		nsimeq;|
		ntilde;|
		numero;|
		nvDash;|
		nvHarr;|
		nvdash;|
		nvlArr;|
		nvrArr;|
		nwarhk;|
		nwnear;|
		oacute;|
		odblac;|
		odsold;|
		ograve;|
		ominus;|
		origof;|
		oslash;|
		otilde;|
		otimes;|
		parsim;|
		percnt;|
		period;|
		permil;|
		phmmat;|
		planck;|
		plankv;|
		plusdo;|
		plusdu;|
		plusmn;|
		preceq;|
		primes;|
		prnsim;|
		propto;|
		prurel;|
		puncsp;|
		qprime;|
		rAtail;|
		racute;|
		rangle;|
		rarrap;|
		rarrfs;|
		rarrhk;|
		rarrlp;|
		rarrpl;|
		rarrtl;|
		ratail;|
		rbrace;|
		rbrack;|
		rcaron;|
		rcedil;|
		rdquor;|
		rfisht;|
		rfloor;|
		rharul;|
		rmoust;|
		roplus;|
		rpargt;|
		rsaquo;|
		rsquor;|
		rthree;|
		rtimes;|
		sacute;|
		scaron;|
		scedil;|
		scnsim;|
		searhk;|
		seswar;|
		sfrown;|
		shchcy;|
		sigmaf;|
		sigmav;|
		simdot;|
		smashp;|
		softcy;|
		solbar;|
		spades;|
		sqcaps;|
		sqcups;|
		sqsube;|
		sqsupe;|
		square;|
		squarf;|
		ssetmn;|
		ssmile;|
		sstarf;|
		subdot;|
		subset;|
		subsim;|
		subsub;|
		subsup;|
		succeq;|
		supdot;|
		supset;|
		supsim;|
		supsub;|
		supsup;|
		swarhk;|
		swnwar;|
		target;|
		tcaron;|
		tcedil;|
		telrec;|
		there4;|
		thetav;|
		thinsp;|
		thksim;|
		timesb;|
		timesd;|
		topbot;|
		topcir;|
		tprime;|
		tridot;|
		tstrok;|
		uacute;|
		ubreve;|
		udblac;|
		ufisht;|
		ugrave;|
		ulcorn;|
		ulcrop;|
		urcorn;|
		urcrop;|
		utilde;|
		vangrt;|
		varphi;|
		varrho;|
		veebar;|
		vellip;|
		verbar;|
		vsubnE;|
		vsubne;|
		vsupnE;|
		vsupne;|
		wedbar;|
		wedgeq;|
		weierp;|
		wreath;|
		xoplus;|
		xotime;|
		xsqcup;|
		xuplus;|
		xwedge;|
		yacute;|
		zacute;|
		zcaron;|
		zeetrf;|
		AElig;|
		Aacute|
		Acirc;|
		Agrave|
		Alpha;|
		Amacr;|
		Aogon;|
		Aring;|
		Atilde|
		Breve;|
		Ccedil|
		Ccirc;|
		Colon;|
		Cross;|
		Dashv;|
		Delta;|
		Eacute|
		Ecirc;|
		Egrave|
		Emacr;|
		Eogon;|
		Equal;|
		Gamma;|
		Gcirc;|
		Hacek;|
		Hcirc;|
		IJlig;|
		Iacute|
		Icirc;|
		Igrave|
		Imacr;|
		Iogon;|
		Iukcy;|
		Jcirc;|
		Jukcy;|
		Kappa;|
		Ntilde|
		OElig;|
		Oacute|
		Ocirc;|
		Ograve|
		Omacr;|
		Omega;|
		Oslash|
		Otilde|
		Prime;|
		RBarr;|
		Scirc;|
		Sigma;|
		THORN;|
		TRADE;|
		TSHcy;|
		Theta;|
		Tilde;|
		Uacute|
		Ubrcy;|
		Ucirc;|
		Ugrave|
		Umacr;|
		Union;|
		Uogon;|
		UpTee;|
		Uring;|
		VDash;|
		Vdash;|
		Wcirc;|
		Wedge;|
		Yacute|
		Ycirc;|
		aacute|
		acirc;|
		acute;|
		aelig;|
		agrave|
		aleph;|
		alpha;|
		amacr;|
		amalg;|
		angle;|
		angrt;|
		angst;|
		aogon;|
		aring;|
		asymp;|
		atilde|
		awint;|
		bcong;|
		bdquo;|
		bepsi;|
		blank;|
		blk12;|
		blk14;|
		blk34;|
		block;|
		boxDL;|
		boxDR;|
		boxDl;|
		boxDr;|
		boxHD;|
		boxHU;|
		boxHd;|
		boxHu;|
		boxUL;|
		boxUR;|
		boxUl;|
		boxUr;|
		boxVH;|
		boxVL;|
		boxVR;|
		boxVh;|
		boxVl;|
		boxVr;|
		boxdL;|
		boxdR;|
		boxdl;|
		boxdr;|
		boxhD;|
		boxhU;|
		boxhd;|
		boxhu;|
		boxuL;|
		boxuR;|
		boxul;|
		boxur;|
		boxvH;|
		boxvL;|
		boxvR;|
		boxvh;|
		boxvl;|
		boxvr;|
		breve;|
		brvbar|
		bsemi;|
		bsime;|
		bsolb;|
		bumpE;|
		bumpe;|
		caret;|
		caron;|
		ccaps;|
		ccedil|
		ccirc;|
		ccups;|
		cedil;|
		check;|
		clubs;|
		colon;|
		comma;|
		crarr;|
		cross;|
		csube;|
		csupe;|
		ctdot;|
		cuepr;|
		cuesc;|
		cupor;|
		curren|
		cuvee;|
		cuwed;|
		cwint;|
		dashv;|
		dblac;|
		ddarr;|
		delta;|
		dharl;|
		dharr;|
		diams;|
		disin;|
		divide|
		doteq;|
		dtdot;|
		dtrif;|
		duarr;|
		duhar;|
		eDDot;|
		eacute|
		ecirc;|
		efDot;|
		egrave|
		emacr;|
		empty;|
		eogon;|
		eplus;|
		epsiv;|
		eqsim;|
		equiv;|
		erDot;|
		erarr;|
		esdot;|
		exist;|
		fflig;|
		filig;|
		fjlig;|
		fllig;|
		fltns;|
		forkv;|
		frac12|
		frac14|
		frac34|
		frasl;|
		frown;|
		gamma;|
		gcirc;|
		gescc;|
		gimel;|
		gneqq;|
		gnsim;|
		grave;|
		gsime;|
		gsiml;|
		gtcir;|
		gtdot;|
		harrw;|
		hcirc;|
		hoarr;|
		iacute|
		icirc;|
		iexcl;|
		igrave|
		iiint;|
		iiota;|
		ijlig;|
		imacr;|
		image;|
		imath;|
		imped;|
		infin;|
		iogon;|
		iprod;|
		iquest|
		isinE;|
		isins;|
		isinv;|
		iukcy;|
		jcirc;|
		jmath;|
		jukcy;|
		kappa;|
		lAarr;|
		lBarr;|
		langd;|
		laquo;|
		larrb;|
		lates;|
		lbarr;|
		lbbrk;|
		lbrke;|
		lceil;|
		ldquo;|
		lescc;|
		lhard;|
		lharu;|
		lhblk;|
		llarr;|
		lltri;|
		lneqq;|
		lnsim;|
		loang;|
		loarr;|
		lobrk;|
		lopar;|
		lrarr;|
		lrhar;|
		lrtri;|
		lsime;|
		lsimg;|
		lsquo;|
		ltcir;|
		ltdot;|
		ltrie;|
		ltrif;|
		mDDot;|
		mdash;|
		micro;|
		middot|
		minus;|
		mumap;|
		nabla;|
		napid;|
		napos;|
		natur;|
		nbump;|
		ncong;|
		ndash;|
		neArr;|
		nearr;|
		nedot;|
		nesim;|
		ngeqq;|
		ngsim;|
		nhArr;|
		nharr;|
		nhpar;|
		nlArr;|
		nlarr;|
		nleqq;|
		nless;|
		nlsim;|
		nltri;|
		notin;|
		notni;|
		npart;|
		nprec;|
		nrArr;|
		nrarr;|
		nrtri;|
		nsime;|
		nsmid;|
		nspar;|
		nsubE;|
		nsube;|
		nsucc;|
		nsupE;|
		nsupe;|
		ntilde|
		numsp;|
		nvsim;|
		nwArr;|
		nwarr;|
		oacute|
		ocirc;|
		odash;|
		oelig;|
		ofcir;|
		ograve|
		ohbar;|
		olarr;|
		olcir;|
		oline;|
		omacr;|
		omega;|
		operp;|
		oplus;|
		orarr;|
		order;|
		oslash|
		otilde|
		ovbar;|
		parsl;|
		phone;|
		plusb;|
		pluse;|
		plusmn|
		pound;|
		prcue;|
		prime;|
		prnap;|
		prsim;|
		quest;|
		rAarr;|
		rBarr;|
		radic;|
		rangd;|
		range;|
		raquo;|
		rarrb;|
		rarrc;|
		rarrw;|
		ratio;|
		rbarr;|
		rbbrk;|
		rbrke;|
		rceil;|
		rdquo;|
		reals;|
		rhard;|
		rharu;|
		rlarr;|
		rlhar;|
		rnmid;|
		roang;|
		roarr;|
		robrk;|
		ropar;|
		rrarr;|
		rsquo;|
		rtrie;|
		rtrif;|
		sbquo;|
		sccue;|
		scirc;|
		scnap;|
		scsim;|
		sdotb;|
		sdote;|
		seArr;|
		searr;|
		setmn;|
		sharp;|
		sigma;|
		simeq;|
		simgE;|
		simlE;|
		simne;|
		slarr;|
		smile;|
		smtes;|
		sqcap;|
		sqcup;|
		sqsub;|
		sqsup;|
		srarr;|
		starf;|
		strns;|
		subnE;|
		subne;|
		supnE;|
		supne;|
		swArr;|
		swarr;|
		szlig;|
		theta;|
		thkap;|
		thorn;|
		tilde;|
		times;|
		trade;|
		trisb;|
		tshcy;|
		twixt;|
		uacute|
		ubrcy;|
		ucirc;|
		udarr;|
		udhar;|
		ugrave|
		uharl;|
		uharr;|
		uhblk;|
		ultri;|
		umacr;|
		uogon;|
		uplus;|
		upsih;|
		uring;|
		urtri;|
		utdot;|
		utrif;|
		uuarr;|
		vBarv;|
		vDash;|
		varpi;|
		vdash;|
		veeeq;|
		vltri;|
		vnsub;|
		vnsup;|
		vprop;|
		vrtri;|
		wcirc;|
		wedge;|
		xcirc;|
		xdtri;|
		xhArr;|
		xharr;|
		xlArr;|
		xlarr;|
		xodot;|
		xrArr;|
		xrarr;|
		xutri;|
		yacute|
		ycirc;|
		AElig|
		Acirc|
		Aopf;|
		Aring|
		Ascr;|
		Auml;|
		Barv;|
		Beta;|
		Bopf;|
		Bscr;|
		CHcy;|
		COPY;|
		Cdot;|
		Copf;|
		Cscr;|
		DJcy;|
		DScy;|
		DZcy;|
		Darr;|
		Dopf;|
		Dscr;|
		Ecirc|
		Edot;|
		Eopf;|
		Escr;|
		Esim;|
		Euml;|
		Fopf;|
		Fscr;|
		GJcy;|
		Gdot;|
		Gopf;|
		Gscr;|
		Hopf;|
		Hscr;|
		IEcy;|
		IOcy;|
		Icirc|
		Idot;|
		Iopf;|
		Iota;|
		Iscr;|
		Iuml;|
		Jopf;|
		Jscr;|
		KHcy;|
		KJcy;|
		Kopf;|
		Kscr;|
		LJcy;|
		Lang;|
		Larr;|
		Lopf;|
		Lscr;|
		Mopf;|
		Mscr;|
		NJcy;|
		Nopf;|
		Nscr;|
		Ocirc|
		Oopf;|
		Oscr;|
		Ouml;|
		Popf;|
		Pscr;|
		QUOT;|
		Qopf;|
		Qscr;|
		Rang;|
		Rarr;|
		Ropf;|
		Rscr;|
		SHcy;|
		Sopf;|
		Sqrt;|
		Sscr;|
		Star;|
		THORN|
		TScy;|
		Topf;|
		Tscr;|
		Uarr;|
		Ucirc|
		Uopf;|
		Upsi;|
		Uscr;|
		Uuml;|
		Vbar;|
		Vert;|
		Vopf;|
		Vscr;|
		Wopf;|
		Wscr;|
		Xopf;|
		Xscr;|
		YAcy;|
		YIcy;|
		YUcy;|
		Yopf;|
		Yscr;|
		Yuml;|
		ZHcy;|
		Zdot;|
		Zeta;|
		Zopf;|
		Zscr;|
		acirc|
		acute|
		aelig|
		andd;|
		andv;|
		ange;|
		aopf;|
		apid;|
		apos;|
		aring|
		ascr;|
		auml;|
		bNot;|
		bbrk;|
		beta;|
		beth;|
		bnot;|
		bopf;|
		boxH;|
		boxV;|
		boxh;|
		boxv;|
		bscr;|
		bsim;|
		bsol;|
		bull;|
		bump;|
		caps;|
		cdot;|
		cedil|
		cent;|
		chcy;|
		cirE;|
		circ;|
		cire;|
		comp;|
		cong;|
		copf;|
		copy;|
		cscr;|
		csub;|
		csup;|
		cups;|
		dArr;|
		dHar;|
		darr;|
		dash;|
		diam;|
		djcy;|
		dopf;|
		dscr;|
		dscy;|
		dsol;|
		dtri;|
		dzcy;|
		eDot;|
		ecir;|
		ecirc|
		edot;|
		emsp;|
		ensp;|
		eopf;|
		epar;|
		epsi;|
		escr;|
		esim;|
		euml;|
		euro;|
		excl;|
		flat;|
		fnof;|
		fopf;|
		fork;|
		fscr;|
		gdot;|
		geqq;|
		gesl;|
		gjcy;|
		gnap;|
		gneq;|
		gopf;|
		gscr;|
		gsim;|
		gtcc;|
		gvnE;|
		hArr;|
		half;|
		harr;|
		hbar;|
		hopf;|
		hscr;|
		icirc|
		iecy;|
		iexcl|
		imof;|
		iocy;|
		iopf;|
		iota;|
		iscr;|
		isin;|
		iuml;|
		jopf;|
		jscr;|
		khcy;|
		kjcy;|
		kopf;|
		kscr;|
		lArr;|
		lHar;|
		lang;|
		laquo|
		larr;|
		late;|
		lcub;|
		ldca;|
		ldsh;|
		leqq;|
		lesg;|
		ljcy;|
		lnap;|
		lneq;|
		lopf;|
		lozf;|
		lpar;|
		lscr;|
		lsim;|
		lsqb;|
		ltcc;|
		ltri;|
		lvnE;|
		macr;|
		male;|
		malt;|
		micro|
		mlcp;|
		mldr;|
		mopf;|
		mscr;|
		nGtv;|
		nLtv;|
		nang;|
		napE;|
		nbsp;|
		ncap;|
		ncup;|
		ngeq;|
		nges;|
		ngtr;|
		nisd;|
		njcy;|
		nldr;|
		nleq;|
		nles;|
		nmid;|
		nopf;|
		npar;|
		npre;|
		nsce;|
		nscr;|
		nsim;|
		nsub;|
		nsup;|
		ntgl;|
		ntlg;|
		nvap;|
		nvge;|
		nvgt;|
		nvle;|
		nvlt;|
		oast;|
		ocir;|
		ocirc|
		odiv;|
		odot;|
		ogon;|
		oint;|
		omid;|
		oopf;|
		opar;|
		ordf;|
		ordm;|
		oror;|
		oscr;|
		osol;|
		ouml;|
		para;|
		part;|
		perp;|
		phiv;|
		plus;|
		popf;|
		pound|
		prap;|
		prec;|
		prnE;|
		prod;|
		prop;|
		pscr;|
		qint;|
		qopf;|
		qscr;|
		quot;|
		rArr;|
		rHar;|
		race;|
		rang;|
		raquo|
		rarr;|
		rcub;|
		rdca;|
		rdsh;|
		real;|
		rect;|
		rhov;|
		ring;|
		ropf;|
		rpar;|
		rscr;|
		rsqb;|
		rtri;|
		scap;|
		scnE;|
		sdot;|
		sect;|
		semi;|
		sext;|
		shcy;|
		sime;|
		simg;|
		siml;|
		smid;|
		smte;|
		solb;|
		sopf;|
		spar;|
		squf;|
		sscr;|
		star;|
		subE;|
		sube;|
		succ;|
		sung;|
		sup1;|
		sup2;|
		sup3;|
		supE;|
		supe;|
		szlig|
		tbrk;|
		tdot;|
		thorn|
		times|
		tint;|
		toea;|
		topf;|
		tosa;|
		trie;|
		tscr;|
		tscy;|
		uArr;|
		uHar;|
		uarr;|
		ucirc|
		uopf;|
		upsi;|
		uscr;|
		utri;|
		uuml;|
		vArr;|
		vBar;|
		varr;|
		vert;|
		vopf;|
		vscr;|
		wopf;|
		wscr;|
		xcap;|
		xcup;|
		xmap;|
		xnis;|
		xopf;|
		xscr;|
		xvee;|
		yacy;|
		yicy;|
		yopf;|
		yscr;|
		yucy;|
		yuml;|
		zdot;|
		zeta;|
		zhcy;|
		zopf;|
		zscr;|
		zwnj;|
		AMP;|
		Acy;|
		Afr;|
		And;|
		Auml|
		Bcy;|
		Bfr;|
		COPY|
		Cap;|
		Cfr;|
		Chi;|
		Cup;|
		Dcy;|
		Del;|
		Dfr;|
		Dot;|
		ENG;|
		ETH;|
		Ecy;|
		Efr;|
		Eta;|
		Euml|
		Fcy;|
		Ffr;|
		Gcy;|
		Gfr;|
		Hat;|
		Hfr;|
		Icy;|
		Ifr;|
		Int;|
		Iuml|
		Jcy;|
		Jfr;|
		Kcy;|
		Kfr;|
		Lcy;|
		Lfr;|
		Lsh;|
		Map;|
		Mcy;|
		Mfr;|
		Ncy;|
		Nfr;|
		Not;|
		Ocy;|
		Ofr;|
		Ouml|
		Pcy;|
		Pfr;|
		Phi;|
		Psi;|
		QUOT|
		Qfr;|
		REG;|
		Rcy;|
		Rfr;|
		Rho;|
		Rsh;|
		Scy;|
		Sfr;|
		Sub;|
		Sum;|
		Sup;|
		Tab;|
		Tau;|
		Tcy;|
		Tfr;|
		Ucy;|
		Ufr;|
		Uuml|
		Vcy;|
		Vee;|
		Vfr;|
		Wfr;|
		Xfr;|
		Ycy;|
		Yfr;|
		Zcy;|
		Zfr;|
		acE;|
		acd;|
		acy;|
		afr;|
		amp;|
		and;|
		ang;|
		apE;|
		ape;|
		ast;|
		auml|
		bcy;|
		bfr;|
		bne;|
		bot;|
		cap;|
		cent|
		cfr;|
		chi;|
		cir;|
		copy|
		cup;|
		dcy;|
		deg;|
		dfr;|
		die;|
		div;|
		dot;|
		ecy;|
		efr;|
		egs;|
		ell;|
		els;|
		eng;|
		eta;|
		eth;|
		euml|
		fcy;|
		ffr;|
		gEl;|
		gap;|
		gcy;|
		gel;|
		geq;|
		ges;|
		gfr;|
		ggg;|
		glE;|
		gla;|
		glj;|
		gnE;|
		gne;|
		hfr;|
		icy;|
		iff;|
		ifr;|
		int;|
		iuml|
		jcy;|
		jfr;|
		kcy;|
		kfr;|
		lEg;|
		lap;|
		lat;|
		lcy;|
		leg;|
		leq;|
		les;|
		lfr;|
		lgE;|
		lnE;|
		lne;|
		loz;|
		lrm;|
		lsh;|
		macr|
		map;|
		mcy;|
		mfr;|
		mho;|
		mid;|
		nGg;|
		nGt;|
		nLl;|
		nLt;|
		nap;|
		nbsp|
		ncy;|
		nfr;|
		ngE;|
		nge;|
		ngt;|
		nis;|
		niv;|
		nlE;|
		nle;|
		nlt;|
		not;|
		npr;|
		nsc;|
		num;|
		ocy;|
		ofr;|
		ogt;|
		ohm;|
		olt;|
		ord;|
		ordf|
		ordm|
		orv;|
		ouml|
		par;|
		para|
		pcy;|
		pfr;|
		phi;|
		piv;|
		prE;|
		pre;|
		psi;|
		qfr;|
		quot|
		rcy;|
		reg;|
		rfr;|
		rho;|
		rlm;|
		rsh;|
		scE;|
		sce;|
		scy;|
		sect|
		sfr;|
		shy;|
		sim;|
		smt;|
		sol;|
		squ;|
		sub;|
		sum;|
		sup1|
		sup2|
		sup3|
		sup;|
		tau;|
		tcy;|
		tfr;|
		top;|
		ucy;|
		ufr;|
		uml;|
		uuml|
		vcy;|
		vee;|
		vfr;|
		wfr;|
		xfr;|
		ycy;|
		yen;|
		yfr;|
		yuml|
		zcy;|
		zfr;|
		zwj;|
		AMP|
		DD;|
		ETH|
		GT;|
		Gg;|
		Gt;|
		Im;|
		LT;|
		Ll;|
		Lt;|
		Mu;|
		Nu;|
		Or;|
		Pi;|
		Pr;|
		REG|
		Re;|
		Sc;|
		Xi;|
		ac;|
		af;|
		amp|
		ap;|
		dd;|
		deg|
		ee;|
		eg;|
		el;|
		eth|
		gE;|
		ge;|
		gg;|
		gl;|
		gt;|
		ic;|
		ii;|
		in;|
		it;|
		lE;|
		le;|
		lg;|
		ll;|
		lt;|
		mp;|
		mu;|
		ne;|
		ni;|
		not|
		nu;|
		oS;|
		or;|
		pi;|
		pm;|
		pr;|
		reg|
		rx;|
		sc;|
		shy|
		uml|
		wp;|
		wr;|
		xi;|
		yen|
		GT|
		LT|
		gt|
		lt';

	public const CHAR_REF_REGEX = '~
				( .*? )                      # 1. prefix
				&
				(?:
					\\# (?:
						0*(\\d+)           |  # 2. decimal
						[xX]0*([0-9A-Fa-f]+) # 3. hexadecimal
					)
					( ; ) ?                  # 4. semicolon
					|
					( \\# )                   # 5. bare hash
					|
					(
		CounterClockwiseContourIntegral;|
		ClockwiseContourIntegral;|
		DoubleLongLeftRightArrow;|
		NotNestedGreaterGreater;|
		DiacriticalDoubleAcute;|
		NotSquareSupersetEqual;|
		CloseCurlyDoubleQuote;|
		DoubleContourIntegral;|
		FilledVerySmallSquare;|
		NegativeVeryThinSpace;|
		NotPrecedesSlantEqual;|
		NotRightTriangleEqual;|
		NotSucceedsSlantEqual;|
		CapitalDifferentialD;|
		DoubleLeftRightArrow;|
		DoubleLongRightArrow;|
		EmptyVerySmallSquare;|
		NestedGreaterGreater;|
		NotDoubleVerticalBar;|
		NotGreaterSlantEqual;|
		NotLeftTriangleEqual;|
		NotSquareSubsetEqual;|
		OpenCurlyDoubleQuote;|
		ReverseUpEquilibrium;|
		DoubleLongLeftArrow;|
		DownLeftRightVector;|
		LeftArrowRightArrow;|
		NegativeMediumSpace;|
		NotGreaterFullEqual;|
		NotRightTriangleBar;|
		RightArrowLeftArrow;|
		SquareSupersetEqual;|
		leftrightsquigarrow;|
		DownRightTeeVector;|
		DownRightVectorBar;|
		LongLeftRightArrow;|
		Longleftrightarrow;|
		NegativeThickSpace;|
		NotLeftTriangleBar;|
		PrecedesSlantEqual;|
		ReverseEquilibrium;|
		RightDoubleBracket;|
		RightDownTeeVector;|
		RightDownVectorBar;|
		RightTriangleEqual;|
		SquareIntersection;|
		SucceedsSlantEqual;|
		blacktriangleright;|
		longleftrightarrow;|
		DoubleUpDownArrow;|
		DoubleVerticalBar;|
		DownLeftTeeVector;|
		DownLeftVectorBar;|
		FilledSmallSquare;|
		GreaterSlantEqual;|
		LeftDoubleBracket;|
		LeftDownTeeVector;|
		LeftDownVectorBar;|
		LeftTriangleEqual;|
		NegativeThinSpace;|
		NotGreaterGreater;|
		NotLessSlantEqual;|
		NotNestedLessLess;|
		NotReverseElement;|
		NotSquareSuperset;|
		NotTildeFullEqual;|
		RightAngleBracket;|
		RightUpDownVector;|
		SquareSubsetEqual;|
		VerticalSeparator;|
		blacktriangledown;|
		blacktriangleleft;|
		leftrightharpoons;|
		rightleftharpoons;|
		twoheadrightarrow;|
		DiacriticalAcute;|
		DiacriticalGrave;|
		DiacriticalTilde;|
		DoubleRightArrow;|
		DownArrowUpArrow;|
		EmptySmallSquare;|
		GreaterEqualLess;|
		GreaterFullEqual;|
		LeftAngleBracket;|
		LeftUpDownVector;|
		LessEqualGreater;|
		NonBreakingSpace;|
		NotPrecedesEqual;|
		NotRightTriangle;|
		NotSucceedsEqual;|
		NotSucceedsTilde;|
		NotSupersetEqual;|
		RightTriangleBar;|
		RightUpTeeVector;|
		RightUpVectorBar;|
		UnderParenthesis;|
		UpArrowDownArrow;|
		circlearrowright;|
		downharpoonright;|
		ntrianglerighteq;|
		rightharpoondown;|
		rightrightarrows;|
		twoheadleftarrow;|
		vartriangleright;|
		CloseCurlyQuote;|
		ContourIntegral;|
		DoubleDownArrow;|
		DoubleLeftArrow;|
		DownRightVector;|
		LeftRightVector;|
		LeftTriangleBar;|
		LeftUpTeeVector;|
		LeftUpVectorBar;|
		LowerRightArrow;|
		NotGreaterEqual;|
		NotGreaterTilde;|
		NotHumpDownHump;|
		NotLeftTriangle;|
		NotSquareSubset;|
		OverParenthesis;|
		RightDownVector;|
		ShortRightArrow;|
		UpperRightArrow;|
		bigtriangledown;|
		circlearrowleft;|
		curvearrowright;|
		downharpoonleft;|
		leftharpoondown;|
		leftrightarrows;|
		nLeftrightarrow;|
		nleftrightarrow;|
		ntrianglelefteq;|
		rightleftarrows;|
		rightsquigarrow;|
		rightthreetimes;|
		straightepsilon;|
		trianglerighteq;|
		vartriangleleft;|
		DiacriticalDot;|
		DoubleRightTee;|
		DownLeftVector;|
		GreaterGreater;|
		HorizontalLine;|
		InvisibleComma;|
		InvisibleTimes;|
		LeftDownVector;|
		LeftRightArrow;|
		Leftrightarrow;|
		LessSlantEqual;|
		LongRightArrow;|
		Longrightarrow;|
		LowerLeftArrow;|
		NestedLessLess;|
		NotGreaterLess;|
		NotLessGreater;|
		NotSubsetEqual;|
		NotVerticalBar;|
		OpenCurlyQuote;|
		ReverseElement;|
		RightTeeVector;|
		RightVectorBar;|
		ShortDownArrow;|
		ShortLeftArrow;|
		SquareSuperset;|
		TildeFullEqual;|
		UpperLeftArrow;|
		ZeroWidthSpace;|
		curvearrowleft;|
		doublebarwedge;|
		downdownarrows;|
		hookrightarrow;|
		leftleftarrows;|
		leftrightarrow;|
		leftthreetimes;|
		longrightarrow;|
		looparrowright;|
		nshortparallel;|
		ntriangleright;|
		rightarrowtail;|
		rightharpoonup;|
		trianglelefteq;|
		upharpoonright;|
		ApplyFunction;|
		DifferentialD;|
		DoubleLeftTee;|
		DoubleUpArrow;|
		LeftTeeVector;|
		LeftVectorBar;|
		LessFullEqual;|
		LongLeftArrow;|
		Longleftarrow;|
		NotEqualTilde;|
		NotTildeEqual;|
		NotTildeTilde;|
		Poincareplane;|
		PrecedesEqual;|
		PrecedesTilde;|
		RightArrowBar;|
		RightTeeArrow;|
		RightTriangle;|
		RightUpVector;|
		SucceedsEqual;|
		SucceedsTilde;|
		SupersetEqual;|
		UpEquilibrium;|
		VerticalTilde;|
		VeryThinSpace;|
		bigtriangleup;|
		blacktriangle;|
		divideontimes;|
		fallingdotseq;|
		hookleftarrow;|
		leftarrowtail;|
		leftharpoonup;|
		longleftarrow;|
		looparrowleft;|
		measuredangle;|
		ntriangleleft;|
		shortparallel;|
		smallsetminus;|
		triangleright;|
		upharpoonleft;|
		varsubsetneqq;|
		varsupsetneqq;|
		DownArrowBar;|
		DownTeeArrow;|
		ExponentialE;|
		GreaterEqual;|
		GreaterTilde;|
		HilbertSpace;|
		HumpDownHump;|
		Intersection;|
		LeftArrowBar;|
		LeftTeeArrow;|
		LeftTriangle;|
		LeftUpVector;|
		NotCongruent;|
		NotHumpEqual;|
		NotLessEqual;|
		NotLessTilde;|
		Proportional;|
		RightCeiling;|
		RoundImplies;|
		ShortUpArrow;|
		SquareSubset;|
		UnderBracket;|
		VerticalLine;|
		blacklozenge;|
		exponentiale;|
		risingdotseq;|
		triangledown;|
		triangleleft;|
		varsubsetneq;|
		varsupsetneq;|
		CircleMinus;|
		CircleTimes;|
		Equilibrium;|
		GreaterLess;|
		LeftCeiling;|
		LessGreater;|
		MediumSpace;|
		NotLessLess;|
		NotPrecedes;|
		NotSucceeds;|
		NotSuperset;|
		OverBracket;|
		RightVector;|
		Rrightarrow;|
		RuleDelayed;|
		SmallCircle;|
		SquareUnion;|
		SubsetEqual;|
		UpDownArrow;|
		Updownarrow;|
		VerticalBar;|
		backepsilon;|
		blacksquare;|
		circledcirc;|
		circleddash;|
		curlyeqprec;|
		curlyeqsucc;|
		diamondsuit;|
		eqslantless;|
		expectation;|
		nRightarrow;|
		nrightarrow;|
		preccurlyeq;|
		precnapprox;|
		quaternions;|
		straightphi;|
		succcurlyeq;|
		succnapprox;|
		thickapprox;|
		updownarrow;|
		Bernoullis;|
		CirclePlus;|
		EqualTilde;|
		Fouriertrf;|
		ImaginaryI;|
		Laplacetrf;|
		LeftVector;|
		Lleftarrow;|
		NotElement;|
		NotGreater;|
		Proportion;|
		RightArrow;|
		RightFloor;|
		Rightarrow;|
		ThickSpace;|
		TildeEqual;|
		TildeTilde;|
		UnderBrace;|
		UpArrowBar;|
		UpTeeArrow;|
		circledast;|
		complement;|
		curlywedge;|
		eqslantgtr;|
		gtreqqless;|
		lessapprox;|
		lesseqqgtr;|
		lmoustache;|
		longmapsto;|
		mapstodown;|
		mapstoleft;|
		nLeftarrow;|
		nleftarrow;|
		nsubseteqq;|
		nsupseteqq;|
		precapprox;|
		rightarrow;|
		rmoustache;|
		sqsubseteq;|
		sqsupseteq;|
		subsetneqq;|
		succapprox;|
		supsetneqq;|
		upuparrows;|
		varepsilon;|
		varnothing;|
		Backslash;|
		CenterDot;|
		CircleDot;|
		Congruent;|
		Coproduct;|
		DoubleDot;|
		DownArrow;|
		DownBreve;|
		Downarrow;|
		HumpEqual;|
		LeftArrow;|
		LeftFloor;|
		Leftarrow;|
		LessTilde;|
		Mellintrf;|
		MinusPlus;|
		NotCupCap;|
		NotExists;|
		NotSubset;|
		OverBrace;|
		PlusMinus;|
		Therefore;|
		ThinSpace;|
		TripleDot;|
		UnionPlus;|
		backprime;|
		backsimeq;|
		bigotimes;|
		centerdot;|
		checkmark;|
		complexes;|
		dotsquare;|
		downarrow;|
		gtrapprox;|
		gtreqless;|
		gvertneqq;|
		heartsuit;|
		leftarrow;|
		lesseqgtr;|
		lvertneqq;|
		ngeqslant;|
		nleqslant;|
		nparallel;|
		nshortmid;|
		nsubseteq;|
		nsupseteq;|
		pitchfork;|
		rationals;|
		spadesuit;|
		subseteqq;|
		subsetneq;|
		supseteqq;|
		supsetneq;|
		therefore;|
		triangleq;|
		varpropto;|
		DDotrahd;|
		DotEqual;|
		Integral;|
		LessLess;|
		NotEqual;|
		NotTilde;|
		PartialD;|
		Precedes;|
		RightTee;|
		Succeeds;|
		SuchThat;|
		Superset;|
		Uarrocir;|
		UnderBar;|
		andslope;|
		angmsdaa;|
		angmsdab;|
		angmsdac;|
		angmsdad;|
		angmsdae;|
		angmsdaf;|
		angmsdag;|
		angmsdah;|
		angrtvbd;|
		approxeq;|
		awconint;|
		backcong;|
		barwedge;|
		bbrktbrk;|
		bigoplus;|
		bigsqcup;|
		biguplus;|
		bigwedge;|
		boxminus;|
		boxtimes;|
		bsolhsub;|
		capbrcup;|
		circledR;|
		circledS;|
		cirfnint;|
		clubsuit;|
		cupbrcap;|
		curlyvee;|
		cwconint;|
		doteqdot;|
		dotminus;|
		drbkarow;|
		dzigrarr;|
		elinters;|
		emptyset;|
		eqvparsl;|
		fpartint;|
		geqslant;|
		gesdotol;|
		gnapprox;|
		hksearow;|
		hkswarow;|
		imagline;|
		imagpart;|
		infintie;|
		integers;|
		intercal;|
		intlarhk;|
		laemptyv;|
		ldrushar;|
		leqslant;|
		lesdotor;|
		llcorner;|
		lnapprox;|
		lrcorner;|
		lurdshar;|
		mapstoup;|
		multimap;|
		naturals;|
		ncongdot;|
		notindot;|
		otimesas;|
		parallel;|
		plusacir;|
		pointint;|
		precneqq;|
		precnsim;|
		profalar;|
		profline;|
		profsurf;|
		raemptyv;|
		realpart;|
		rppolint;|
		rtriltri;|
		scpolint;|
		setminus;|
		shortmid;|
		smeparsl;|
		sqsubset;|
		sqsupset;|
		subseteq;|
		succneqq;|
		succnsim;|
		supseteq;|
		thetasym;|
		thicksim;|
		timesbar;|
		triangle;|
		triminus;|
		trpezium;|
		ulcorner;|
		urcorner;|
		varkappa;|
		varsigma;|
		vartheta;|
		Because;|
		Cayleys;|
		Cconint;|
		Cedilla;|
		Diamond;|
		DownTee;|
		Element;|
		Epsilon;|
		Implies;|
		LeftTee;|
		NewLine;|
		NoBreak;|
		NotLess;|
		Omicron;|
		OverBar;|
		Product;|
		UpArrow;|
		Uparrow;|
		Upsilon;|
		alefsym;|
		angrtvb;|
		angzarr;|
		asympeq;|
		backsim;|
		because;|
		bemptyv;|
		between;|
		bigcirc;|
		bigodot;|
		bigstar;|
		bnequiv;|
		boxplus;|
		ccupssm;|
		cemptyv;|
		cirscir;|
		coloneq;|
		congdot;|
		cudarrl;|
		cudarrr;|
		cularrp;|
		curarrm;|
		dbkarow;|
		ddagger;|
		ddotseq;|
		demptyv;|
		diamond;|
		digamma;|
		dotplus;|
		dwangle;|
		epsilon;|
		eqcolon;|
		equivDD;|
		gesdoto;|
		gtquest;|
		gtrless;|
		harrcir;|
		intprod;|
		isindot;|
		larrbfs;|
		larrsim;|
		lbrksld;|
		lbrkslu;|
		ldrdhar;|
		lesdoto;|
		lessdot;|
		lessgtr;|
		lesssim;|
		lotimes;|
		lozenge;|
		ltquest;|
		luruhar;|
		maltese;|
		minusdu;|
		napprox;|
		natural;|
		nearrow;|
		nexists;|
		notinva;|
		notinvb;|
		notinvc;|
		notniva;|
		notnivb;|
		notnivc;|
		npolint;|
		npreceq;|
		nsqsube;|
		nsqsupe;|
		nsubset;|
		nsucceq;|
		nsupset;|
		nvinfin;|
		nvltrie;|
		nvrtrie;|
		nwarrow;|
		olcross;|
		omicron;|
		orderof;|
		orslope;|
		pertenk;|
		planckh;|
		pluscir;|
		plussim;|
		plustwo;|
		precsim;|
		quatint;|
		questeq;|
		rarrbfs;|
		rarrsim;|
		rbrksld;|
		rbrkslu;|
		rdldhar;|
		realine;|
		rotimes;|
		ruluhar;|
		searrow;|
		simplus;|
		simrarr;|
		subedot;|
		submult;|
		subplus;|
		subrarr;|
		succsim;|
		supdsub;|
		supedot;|
		suphsol;|
		suphsub;|
		suplarr;|
		supmult;|
		supplus;|
		swarrow;|
		topfork;|
		triplus;|
		tritime;|
		uparrow;|
		upsilon;|
		uwangle;|
		vzigzag;|
		zigrarr;|
		Aacute;|
		Abreve;|
		Agrave;|
		Assign;|
		Atilde;|
		Barwed;|
		Bumpeq;|
		Cacute;|
		Ccaron;|
		Ccedil;|
		Colone;|
		Conint;|
		CupCap;|
		Dagger;|
		Dcaron;|
		DotDot;|
		Dstrok;|
		Eacute;|
		Ecaron;|
		Egrave;|
		Exists;|
		ForAll;|
		Gammad;|
		Gbreve;|
		Gcedil;|
		HARDcy;|
		Hstrok;|
		Iacute;|
		Igrave;|
		Itilde;|
		Jsercy;|
		Kcedil;|
		Lacute;|
		Lambda;|
		Lcaron;|
		Lcedil;|
		Lmidot;|
		Lstrok;|
		Nacute;|
		Ncaron;|
		Ncedil;|
		Ntilde;|
		Oacute;|
		Odblac;|
		Ograve;|
		Oslash;|
		Otilde;|
		Otimes;|
		Racute;|
		Rarrtl;|
		Rcaron;|
		Rcedil;|
		SHCHcy;|
		SOFTcy;|
		Sacute;|
		Scaron;|
		Scedil;|
		Square;|
		Subset;|
		Supset;|
		Tcaron;|
		Tcedil;|
		Tstrok;|
		Uacute;|
		Ubreve;|
		Udblac;|
		Ugrave;|
		Utilde;|
		Vdashl;|
		Verbar;|
		Vvdash;|
		Yacute;|
		Zacute;|
		Zcaron;|
		aacute;|
		abreve;|
		agrave;|
		andand;|
		angmsd;|
		angsph;|
		apacir;|
		approx;|
		atilde;|
		barvee;|
		barwed;|
		becaus;|
		bernou;|
		bigcap;|
		bigcup;|
		bigvee;|
		bkarow;|
		bottom;|
		bowtie;|
		boxbox;|
		bprime;|
		brvbar;|
		bullet;|
		bumpeq;|
		cacute;|
		capand;|
		capcap;|
		capcup;|
		capdot;|
		ccaron;|
		ccedil;|
		circeq;|
		cirmid;|
		colone;|
		commat;|
		compfn;|
		conint;|
		coprod;|
		copysr;|
		cularr;|
		cupcap;|
		cupcup;|
		cupdot;|
		curarr;|
		curren;|
		cylcty;|
		dagger;|
		daleth;|
		dcaron;|
		dfisht;|
		divide;|
		divonx;|
		dlcorn;|
		dlcrop;|
		dollar;|
		drcorn;|
		drcrop;|
		dstrok;|
		eacute;|
		easter;|
		ecaron;|
		ecolon;|
		egrave;|
		egsdot;|
		elsdot;|
		emptyv;|
		emsp13;|
		emsp14;|
		eparsl;|
		eqcirc;|
		equals;|
		equest;|
		female;|
		ffilig;|
		ffllig;|
		forall;|
		frac12;|
		frac13;|
		frac14;|
		frac15;|
		frac16;|
		frac18;|
		frac23;|
		frac25;|
		frac34;|
		frac35;|
		frac38;|
		frac45;|
		frac56;|
		frac58;|
		frac78;|
		gacute;|
		gammad;|
		gbreve;|
		gesdot;|
		gesles;|
		gtlPar;|
		gtrarr;|
		gtrdot;|
		gtrsim;|
		hairsp;|
		hamilt;|
		hardcy;|
		hearts;|
		hellip;|
		hercon;|
		homtht;|
		horbar;|
		hslash;|
		hstrok;|
		hybull;|
		hyphen;|
		iacute;|
		igrave;|
		iiiint;|
		iinfin;|
		incare;|
		inodot;|
		intcal;|
		iquest;|
		isinsv;|
		itilde;|
		jsercy;|
		kappav;|
		kcedil;|
		kgreen;|
		lAtail;|
		lacute;|
		lagran;|
		lambda;|
		langle;|
		larrfs;|
		larrhk;|
		larrlp;|
		larrpl;|
		larrtl;|
		latail;|
		lbrace;|
		lbrack;|
		lcaron;|
		lcedil;|
		ldquor;|
		lesdot;|
		lesges;|
		lfisht;|
		lfloor;|
		lharul;|
		llhard;|
		lmidot;|
		lmoust;|
		loplus;|
		lowast;|
		lowbar;|
		lparlt;|
		lrhard;|
		lsaquo;|
		lsquor;|
		lstrok;|
		lthree;|
		ltimes;|
		ltlarr;|
		ltrPar;|
		mapsto;|
		marker;|
		mcomma;|
		midast;|
		midcir;|
		middot;|
		minusb;|
		minusd;|
		mnplus;|
		models;|
		mstpos;|
		nVDash;|
		nVdash;|
		nacute;|
		nbumpe;|
		ncaron;|
		ncedil;|
		nearhk;|
		nequiv;|
		nesear;|
		nexist;|
		nltrie;|
		notinE;|
		nparsl;|
		nprcue;|
		nrarrc;|
		nrarrw;|
		nrtrie;|
		nsccue;|
		nsimeq;|
		ntilde;|
		numero;|
		nvDash;|
		nvHarr;|
		nvdash;|
		nvlArr;|
		nvrArr;|
		nwarhk;|
		nwnear;|
		oacute;|
		odblac;|
		odsold;|
		ograve;|
		ominus;|
		origof;|
		oslash;|
		otilde;|
		otimes;|
		parsim;|
		percnt;|
		period;|
		permil;|
		phmmat;|
		planck;|
		plankv;|
		plusdo;|
		plusdu;|
		plusmn;|
		preceq;|
		primes;|
		prnsim;|
		propto;|
		prurel;|
		puncsp;|
		qprime;|
		rAtail;|
		racute;|
		rangle;|
		rarrap;|
		rarrfs;|
		rarrhk;|
		rarrlp;|
		rarrpl;|
		rarrtl;|
		ratail;|
		rbrace;|
		rbrack;|
		rcaron;|
		rcedil;|
		rdquor;|
		rfisht;|
		rfloor;|
		rharul;|
		rmoust;|
		roplus;|
		rpargt;|
		rsaquo;|
		rsquor;|
		rthree;|
		rtimes;|
		sacute;|
		scaron;|
		scedil;|
		scnsim;|
		searhk;|
		seswar;|
		sfrown;|
		shchcy;|
		sigmaf;|
		sigmav;|
		simdot;|
		smashp;|
		softcy;|
		solbar;|
		spades;|
		sqcaps;|
		sqcups;|
		sqsube;|
		sqsupe;|
		square;|
		squarf;|
		ssetmn;|
		ssmile;|
		sstarf;|
		subdot;|
		subset;|
		subsim;|
		subsub;|
		subsup;|
		succeq;|
		supdot;|
		supset;|
		supsim;|
		supsub;|
		supsup;|
		swarhk;|
		swnwar;|
		target;|
		tcaron;|
		tcedil;|
		telrec;|
		there4;|
		thetav;|
		thinsp;|
		thksim;|
		timesb;|
		timesd;|
		topbot;|
		topcir;|
		tprime;|
		tridot;|
		tstrok;|
		uacute;|
		ubreve;|
		udblac;|
		ufisht;|
		ugrave;|
		ulcorn;|
		ulcrop;|
		urcorn;|
		urcrop;|
		utilde;|
		vangrt;|
		varphi;|
		varrho;|
		veebar;|
		vellip;|
		verbar;|
		vsubnE;|
		vsubne;|
		vsupnE;|
		vsupne;|
		wedbar;|
		wedgeq;|
		weierp;|
		wreath;|
		xoplus;|
		xotime;|
		xsqcup;|
		xuplus;|
		xwedge;|
		yacute;|
		zacute;|
		zcaron;|
		zeetrf;|
		AElig;|
		Aacute|
		Acirc;|
		Agrave|
		Alpha;|
		Amacr;|
		Aogon;|
		Aring;|
		Atilde|
		Breve;|
		Ccedil|
		Ccirc;|
		Colon;|
		Cross;|
		Dashv;|
		Delta;|
		Eacute|
		Ecirc;|
		Egrave|
		Emacr;|
		Eogon;|
		Equal;|
		Gamma;|
		Gcirc;|
		Hacek;|
		Hcirc;|
		IJlig;|
		Iacute|
		Icirc;|
		Igrave|
		Imacr;|
		Iogon;|
		Iukcy;|
		Jcirc;|
		Jukcy;|
		Kappa;|
		Ntilde|
		OElig;|
		Oacute|
		Ocirc;|
		Ograve|
		Omacr;|
		Omega;|
		Oslash|
		Otilde|
		Prime;|
		RBarr;|
		Scirc;|
		Sigma;|
		THORN;|
		TRADE;|
		TSHcy;|
		Theta;|
		Tilde;|
		Uacute|
		Ubrcy;|
		Ucirc;|
		Ugrave|
		Umacr;|
		Union;|
		Uogon;|
		UpTee;|
		Uring;|
		VDash;|
		Vdash;|
		Wcirc;|
		Wedge;|
		Yacute|
		Ycirc;|
		aacute|
		acirc;|
		acute;|
		aelig;|
		agrave|
		aleph;|
		alpha;|
		amacr;|
		amalg;|
		angle;|
		angrt;|
		angst;|
		aogon;|
		aring;|
		asymp;|
		atilde|
		awint;|
		bcong;|
		bdquo;|
		bepsi;|
		blank;|
		blk12;|
		blk14;|
		blk34;|
		block;|
		boxDL;|
		boxDR;|
		boxDl;|
		boxDr;|
		boxHD;|
		boxHU;|
		boxHd;|
		boxHu;|
		boxUL;|
		boxUR;|
		boxUl;|
		boxUr;|
		boxVH;|
		boxVL;|
		boxVR;|
		boxVh;|
		boxVl;|
		boxVr;|
		boxdL;|
		boxdR;|
		boxdl;|
		boxdr;|
		boxhD;|
		boxhU;|
		boxhd;|
		boxhu;|
		boxuL;|
		boxuR;|
		boxul;|
		boxur;|
		boxvH;|
		boxvL;|
		boxvR;|
		boxvh;|
		boxvl;|
		boxvr;|
		breve;|
		brvbar|
		bsemi;|
		bsime;|
		bsolb;|
		bumpE;|
		bumpe;|
		caret;|
		caron;|
		ccaps;|
		ccedil|
		ccirc;|
		ccups;|
		cedil;|
		check;|
		clubs;|
		colon;|
		comma;|
		crarr;|
		cross;|
		csube;|
		csupe;|
		ctdot;|
		cuepr;|
		cuesc;|
		cupor;|
		curren|
		cuvee;|
		cuwed;|
		cwint;|
		dashv;|
		dblac;|
		ddarr;|
		delta;|
		dharl;|
		dharr;|
		diams;|
		disin;|
		divide|
		doteq;|
		dtdot;|
		dtrif;|
		duarr;|
		duhar;|
		eDDot;|
		eacute|
		ecirc;|
		efDot;|
		egrave|
		emacr;|
		empty;|
		eogon;|
		eplus;|
		epsiv;|
		eqsim;|
		equiv;|
		erDot;|
		erarr;|
		esdot;|
		exist;|
		fflig;|
		filig;|
		fjlig;|
		fllig;|
		fltns;|
		forkv;|
		frac12|
		frac14|
		frac34|
		frasl;|
		frown;|
		gamma;|
		gcirc;|
		gescc;|
		gimel;|
		gneqq;|
		gnsim;|
		grave;|
		gsime;|
		gsiml;|
		gtcir;|
		gtdot;|
		harrw;|
		hcirc;|
		hoarr;|
		iacute|
		icirc;|
		iexcl;|
		igrave|
		iiint;|
		iiota;|
		ijlig;|
		imacr;|
		image;|
		imath;|
		imped;|
		infin;|
		iogon;|
		iprod;|
		iquest|
		isinE;|
		isins;|
		isinv;|
		iukcy;|
		jcirc;|
		jmath;|
		jukcy;|
		kappa;|
		lAarr;|
		lBarr;|
		langd;|
		laquo;|
		larrb;|
		lates;|
		lbarr;|
		lbbrk;|
		lbrke;|
		lceil;|
		ldquo;|
		lescc;|
		lhard;|
		lharu;|
		lhblk;|
		llarr;|
		lltri;|
		lneqq;|
		lnsim;|
		loang;|
		loarr;|
		lobrk;|
		lopar;|
		lrarr;|
		lrhar;|
		lrtri;|
		lsime;|
		lsimg;|
		lsquo;|
		ltcir;|
		ltdot;|
		ltrie;|
		ltrif;|
		mDDot;|
		mdash;|
		micro;|
		middot|
		minus;|
		mumap;|
		nabla;|
		napid;|
		napos;|
		natur;|
		nbump;|
		ncong;|
		ndash;|
		neArr;|
		nearr;|
		nedot;|
		nesim;|
		ngeqq;|
		ngsim;|
		nhArr;|
		nharr;|
		nhpar;|
		nlArr;|
		nlarr;|
		nleqq;|
		nless;|
		nlsim;|
		nltri;|
		notin;|
		notni;|
		npart;|
		nprec;|
		nrArr;|
		nrarr;|
		nrtri;|
		nsime;|
		nsmid;|
		nspar;|
		nsubE;|
		nsube;|
		nsucc;|
		nsupE;|
		nsupe;|
		ntilde|
		numsp;|
		nvsim;|
		nwArr;|
		nwarr;|
		oacute|
		ocirc;|
		odash;|
		oelig;|
		ofcir;|
		ograve|
		ohbar;|
		olarr;|
		olcir;|
		oline;|
		omacr;|
		omega;|
		operp;|
		oplus;|
		orarr;|
		order;|
		oslash|
		otilde|
		ovbar;|
		parsl;|
		phone;|
		plusb;|
		pluse;|
		plusmn|
		pound;|
		prcue;|
		prime;|
		prnap;|
		prsim;|
		quest;|
		rAarr;|
		rBarr;|
		radic;|
		rangd;|
		range;|
		raquo;|
		rarrb;|
		rarrc;|
		rarrw;|
		ratio;|
		rbarr;|
		rbbrk;|
		rbrke;|
		rceil;|
		rdquo;|
		reals;|
		rhard;|
		rharu;|
		rlarr;|
		rlhar;|
		rnmid;|
		roang;|
		roarr;|
		robrk;|
		ropar;|
		rrarr;|
		rsquo;|
		rtrie;|
		rtrif;|
		sbquo;|
		sccue;|
		scirc;|
		scnap;|
		scsim;|
		sdotb;|
		sdote;|
		seArr;|
		searr;|
		setmn;|
		sharp;|
		sigma;|
		simeq;|
		simgE;|
		simlE;|
		simne;|
		slarr;|
		smile;|
		smtes;|
		sqcap;|
		sqcup;|
		sqsub;|
		sqsup;|
		srarr;|
		starf;|
		strns;|
		subnE;|
		subne;|
		supnE;|
		supne;|
		swArr;|
		swarr;|
		szlig;|
		theta;|
		thkap;|
		thorn;|
		tilde;|
		times;|
		trade;|
		trisb;|
		tshcy;|
		twixt;|
		uacute|
		ubrcy;|
		ucirc;|
		udarr;|
		udhar;|
		ugrave|
		uharl;|
		uharr;|
		uhblk;|
		ultri;|
		umacr;|
		uogon;|
		uplus;|
		upsih;|
		uring;|
		urtri;|
		utdot;|
		utrif;|
		uuarr;|
		vBarv;|
		vDash;|
		varpi;|
		vdash;|
		veeeq;|
		vltri;|
		vnsub;|
		vnsup;|
		vprop;|
		vrtri;|
		wcirc;|
		wedge;|
		xcirc;|
		xdtri;|
		xhArr;|
		xharr;|
		xlArr;|
		xlarr;|
		xodot;|
		xrArr;|
		xrarr;|
		xutri;|
		yacute|
		ycirc;|
		AElig|
		Acirc|
		Aopf;|
		Aring|
		Ascr;|
		Auml;|
		Barv;|
		Beta;|
		Bopf;|
		Bscr;|
		CHcy;|
		COPY;|
		Cdot;|
		Copf;|
		Cscr;|
		DJcy;|
		DScy;|
		DZcy;|
		Darr;|
		Dopf;|
		Dscr;|
		Ecirc|
		Edot;|
		Eopf;|
		Escr;|
		Esim;|
		Euml;|
		Fopf;|
		Fscr;|
		GJcy;|
		Gdot;|
		Gopf;|
		Gscr;|
		Hopf;|
		Hscr;|
		IEcy;|
		IOcy;|
		Icirc|
		Idot;|
		Iopf;|
		Iota;|
		Iscr;|
		Iuml;|
		Jopf;|
		Jscr;|
		KHcy;|
		KJcy;|
		Kopf;|
		Kscr;|
		LJcy;|
		Lang;|
		Larr;|
		Lopf;|
		Lscr;|
		Mopf;|
		Mscr;|
		NJcy;|
		Nopf;|
		Nscr;|
		Ocirc|
		Oopf;|
		Oscr;|
		Ouml;|
		Popf;|
		Pscr;|
		QUOT;|
		Qopf;|
		Qscr;|
		Rang;|
		Rarr;|
		Ropf;|
		Rscr;|
		SHcy;|
		Sopf;|
		Sqrt;|
		Sscr;|
		Star;|
		THORN|
		TScy;|
		Topf;|
		Tscr;|
		Uarr;|
		Ucirc|
		Uopf;|
		Upsi;|
		Uscr;|
		Uuml;|
		Vbar;|
		Vert;|
		Vopf;|
		Vscr;|
		Wopf;|
		Wscr;|
		Xopf;|
		Xscr;|
		YAcy;|
		YIcy;|
		YUcy;|
		Yopf;|
		Yscr;|
		Yuml;|
		ZHcy;|
		Zdot;|
		Zeta;|
		Zopf;|
		Zscr;|
		acirc|
		acute|
		aelig|
		andd;|
		andv;|
		ange;|
		aopf;|
		apid;|
		apos;|
		aring|
		ascr;|
		auml;|
		bNot;|
		bbrk;|
		beta;|
		beth;|
		bnot;|
		bopf;|
		boxH;|
		boxV;|
		boxh;|
		boxv;|
		bscr;|
		bsim;|
		bsol;|
		bull;|
		bump;|
		caps;|
		cdot;|
		cedil|
		cent;|
		chcy;|
		cirE;|
		circ;|
		cire;|
		comp;|
		cong;|
		copf;|
		copy;|
		cscr;|
		csub;|
		csup;|
		cups;|
		dArr;|
		dHar;|
		darr;|
		dash;|
		diam;|
		djcy;|
		dopf;|
		dscr;|
		dscy;|
		dsol;|
		dtri;|
		dzcy;|
		eDot;|
		ecir;|
		ecirc|
		edot;|
		emsp;|
		ensp;|
		eopf;|
		epar;|
		epsi;|
		escr;|
		esim;|
		euml;|
		euro;|
		excl;|
		flat;|
		fnof;|
		fopf;|
		fork;|
		fscr;|
		gdot;|
		geqq;|
		gesl;|
		gjcy;|
		gnap;|
		gneq;|
		gopf;|
		gscr;|
		gsim;|
		gtcc;|
		gvnE;|
		hArr;|
		half;|
		harr;|
		hbar;|
		hopf;|
		hscr;|
		icirc|
		iecy;|
		iexcl|
		imof;|
		iocy;|
		iopf;|
		iota;|
		iscr;|
		isin;|
		iuml;|
		jopf;|
		jscr;|
		khcy;|
		kjcy;|
		kopf;|
		kscr;|
		lArr;|
		lHar;|
		lang;|
		laquo|
		larr;|
		late;|
		lcub;|
		ldca;|
		ldsh;|
		leqq;|
		lesg;|
		ljcy;|
		lnap;|
		lneq;|
		lopf;|
		lozf;|
		lpar;|
		lscr;|
		lsim;|
		lsqb;|
		ltcc;|
		ltri;|
		lvnE;|
		macr;|
		male;|
		malt;|
		micro|
		mlcp;|
		mldr;|
		mopf;|
		mscr;|
		nGtv;|
		nLtv;|
		nang;|
		napE;|
		nbsp;|
		ncap;|
		ncup;|
		ngeq;|
		nges;|
		ngtr;|
		nisd;|
		njcy;|
		nldr;|
		nleq;|
		nles;|
		nmid;|
		nopf;|
		npar;|
		npre;|
		nsce;|
		nscr;|
		nsim;|
		nsub;|
		nsup;|
		ntgl;|
		ntlg;|
		nvap;|
		nvge;|
		nvgt;|
		nvle;|
		nvlt;|
		oast;|
		ocir;|
		ocirc|
		odiv;|
		odot;|
		ogon;|
		oint;|
		omid;|
		oopf;|
		opar;|
		ordf;|
		ordm;|
		oror;|
		oscr;|
		osol;|
		ouml;|
		para;|
		part;|
		perp;|
		phiv;|
		plus;|
		popf;|
		pound|
		prap;|
		prec;|
		prnE;|
		prod;|
		prop;|
		pscr;|
		qint;|
		qopf;|
		qscr;|
		quot;|
		rArr;|
		rHar;|
		race;|
		rang;|
		raquo|
		rarr;|
		rcub;|
		rdca;|
		rdsh;|
		real;|
		rect;|
		rhov;|
		ring;|
		ropf;|
		rpar;|
		rscr;|
		rsqb;|
		rtri;|
		scap;|
		scnE;|
		sdot;|
		sect;|
		semi;|
		sext;|
		shcy;|
		sime;|
		simg;|
		siml;|
		smid;|
		smte;|
		solb;|
		sopf;|
		spar;|
		squf;|
		sscr;|
		star;|
		subE;|
		sube;|
		succ;|
		sung;|
		sup1;|
		sup2;|
		sup3;|
		supE;|
		supe;|
		szlig|
		tbrk;|
		tdot;|
		thorn|
		times|
		tint;|
		toea;|
		topf;|
		tosa;|
		trie;|
		tscr;|
		tscy;|
		uArr;|
		uHar;|
		uarr;|
		ucirc|
		uopf;|
		upsi;|
		uscr;|
		utri;|
		uuml;|
		vArr;|
		vBar;|
		varr;|
		vert;|
		vopf;|
		vscr;|
		wopf;|
		wscr;|
		xcap;|
		xcup;|
		xmap;|
		xnis;|
		xopf;|
		xscr;|
		xvee;|
		yacy;|
		yicy;|
		yopf;|
		yscr;|
		yucy;|
		yuml;|
		zdot;|
		zeta;|
		zhcy;|
		zopf;|
		zscr;|
		zwnj;|
		AMP;|
		Acy;|
		Afr;|
		And;|
		Auml|
		Bcy;|
		Bfr;|
		COPY|
		Cap;|
		Cfr;|
		Chi;|
		Cup;|
		Dcy;|
		Del;|
		Dfr;|
		Dot;|
		ENG;|
		ETH;|
		Ecy;|
		Efr;|
		Eta;|
		Euml|
		Fcy;|
		Ffr;|
		Gcy;|
		Gfr;|
		Hat;|
		Hfr;|
		Icy;|
		Ifr;|
		Int;|
		Iuml|
		Jcy;|
		Jfr;|
		Kcy;|
		Kfr;|
		Lcy;|
		Lfr;|
		Lsh;|
		Map;|
		Mcy;|
		Mfr;|
		Ncy;|
		Nfr;|
		Not;|
		Ocy;|
		Ofr;|
		Ouml|
		Pcy;|
		Pfr;|
		Phi;|
		Psi;|
		QUOT|
		Qfr;|
		REG;|
		Rcy;|
		Rfr;|
		Rho;|
		Rsh;|
		Scy;|
		Sfr;|
		Sub;|
		Sum;|
		Sup;|
		Tab;|
		Tau;|
		Tcy;|
		Tfr;|
		Ucy;|
		Ufr;|
		Uuml|
		Vcy;|
		Vee;|
		Vfr;|
		Wfr;|
		Xfr;|
		Ycy;|
		Yfr;|
		Zcy;|
		Zfr;|
		acE;|
		acd;|
		acy;|
		afr;|
		amp;|
		and;|
		ang;|
		apE;|
		ape;|
		ast;|
		auml|
		bcy;|
		bfr;|
		bne;|
		bot;|
		cap;|
		cent|
		cfr;|
		chi;|
		cir;|
		copy|
		cup;|
		dcy;|
		deg;|
		dfr;|
		die;|
		div;|
		dot;|
		ecy;|
		efr;|
		egs;|
		ell;|
		els;|
		eng;|
		eta;|
		eth;|
		euml|
		fcy;|
		ffr;|
		gEl;|
		gap;|
		gcy;|
		gel;|
		geq;|
		ges;|
		gfr;|
		ggg;|
		glE;|
		gla;|
		glj;|
		gnE;|
		gne;|
		hfr;|
		icy;|
		iff;|
		ifr;|
		int;|
		iuml|
		jcy;|
		jfr;|
		kcy;|
		kfr;|
		lEg;|
		lap;|
		lat;|
		lcy;|
		leg;|
		leq;|
		les;|
		lfr;|
		lgE;|
		lnE;|
		lne;|
		loz;|
		lrm;|
		lsh;|
		macr|
		map;|
		mcy;|
		mfr;|
		mho;|
		mid;|
		nGg;|
		nGt;|
		nLl;|
		nLt;|
		nap;|
		nbsp|
		ncy;|
		nfr;|
		ngE;|
		nge;|
		ngt;|
		nis;|
		niv;|
		nlE;|
		nle;|
		nlt;|
		not;|
		npr;|
		nsc;|
		num;|
		ocy;|
		ofr;|
		ogt;|
		ohm;|
		olt;|
		ord;|
		ordf|
		ordm|
		orv;|
		ouml|
		par;|
		para|
		pcy;|
		pfr;|
		phi;|
		piv;|
		prE;|
		pre;|
		psi;|
		qfr;|
		quot|
		rcy;|
		reg;|
		rfr;|
		rho;|
		rlm;|
		rsh;|
		scE;|
		sce;|
		scy;|
		sect|
		sfr;|
		shy;|
		sim;|
		smt;|
		sol;|
		squ;|
		sub;|
		sum;|
		sup1|
		sup2|
		sup3|
		sup;|
		tau;|
		tcy;|
		tfr;|
		top;|
		ucy;|
		ufr;|
		uml;|
		uuml|
		vcy;|
		vee;|
		vfr;|
		wfr;|
		xfr;|
		ycy;|
		yen;|
		yfr;|
		yuml|
		zcy;|
		zfr;|
		zwj;|
		AMP|
		DD;|
		ETH|
		GT;|
		Gg;|
		Gt;|
		Im;|
		LT;|
		Ll;|
		Lt;|
		Mu;|
		Nu;|
		Or;|
		Pi;|
		Pr;|
		REG|
		Re;|
		Sc;|
		Xi;|
		ac;|
		af;|
		amp|
		ap;|
		dd;|
		deg|
		ee;|
		eg;|
		el;|
		eth|
		gE;|
		ge;|
		gg;|
		gl;|
		gt;|
		ic;|
		ii;|
		in;|
		it;|
		lE;|
		le;|
		lg;|
		ll;|
		lt;|
		mp;|
		mu;|
		ne;|
		ni;|
		not|
		nu;|
		oS;|
		or;|
		pi;|
		pm;|
		pr;|
		reg|
		rx;|
		sc;|
		shy|
		uml|
		wp;|
		wr;|
		xi;|
		yen|
		GT|
		LT|
		gt|
		lt) # 6. known named
					(?:
						(?<! ; )             # Assert no semicolon prior
						( [=a-zA-Z0-9] )     # 7. attribute suffix
					)?
					|
					( [a-zA-Z0-9]+ ; )       # 8. invalid named
				)
				# S = study, for efficient knownNamed
				# A = anchor, to avoid unnecessary movement of the whole pattern on failure
				~xAsS';

	public const NAMED_ENTITY_TRANSLATION = [
		'Aacute;' => 'Á',
		'Aacute' => 'Á',
		'aacute;' => 'á',
		'aacute' => 'á',
		'Abreve;' => 'Ă',
		'abreve;' => 'ă',
		'ac;' => '∾',
		'acd;' => '∿',
		'acE;' => '∾̳',
		'Acirc;' => 'Â',
		'Acirc' => 'Â',
		'acirc;' => 'â',
		'acirc' => 'â',
		'acute;' => '´',
		'acute' => '´',
		'Acy;' => 'А',
		'acy;' => 'а',
		'AElig;' => 'Æ',
		'AElig' => 'Æ',
		'aelig;' => 'æ',
		'aelig' => 'æ',
		'af;' => '⁡',
		'Afr;' => '𝔄',
		'afr;' => '𝔞',
		'Agrave;' => 'À',
		'Agrave' => 'À',
		'agrave;' => 'à',
		'agrave' => 'à',
		'alefsym;' => 'ℵ',
		'aleph;' => 'ℵ',
		'Alpha;' => 'Α',
		'alpha;' => 'α',
		'Amacr;' => 'Ā',
		'amacr;' => 'ā',
		'amalg;' => '⨿',
		'amp;' => '&',
		'amp' => '&',
		'AMP;' => '&',
		'AMP' => '&',
		'andand;' => '⩕',
		'And;' => '⩓',
		'and;' => '∧',
		'andd;' => '⩜',
		'andslope;' => '⩘',
		'andv;' => '⩚',
		'ang;' => '∠',
		'ange;' => '⦤',
		'angle;' => '∠',
		'angmsdaa;' => '⦨',
		'angmsdab;' => '⦩',
		'angmsdac;' => '⦪',
		'angmsdad;' => '⦫',
		'angmsdae;' => '⦬',
		'angmsdaf;' => '⦭',
		'angmsdag;' => '⦮',
		'angmsdah;' => '⦯',
		'angmsd;' => '∡',
		'angrt;' => '∟',
		'angrtvb;' => '⊾',
		'angrtvbd;' => '⦝',
		'angsph;' => '∢',
		'angst;' => 'Å',
		'angzarr;' => '⍼',
		'Aogon;' => 'Ą',
		'aogon;' => 'ą',
		'Aopf;' => '𝔸',
		'aopf;' => '𝕒',
		'apacir;' => '⩯',
		'ap;' => '≈',
		'apE;' => '⩰',
		'ape;' => '≊',
		'apid;' => '≋',
		'apos;' => '\'',
		'ApplyFunction;' => '⁡',
		'approx;' => '≈',
		'approxeq;' => '≊',
		'Aring;' => 'Å',
		'Aring' => 'Å',
		'aring;' => 'å',
		'aring' => 'å',
		'Ascr;' => '𝒜',
		'ascr;' => '𝒶',
		'Assign;' => '≔',
		'ast;' => '*',
		'asymp;' => '≈',
		'asympeq;' => '≍',
		'Atilde;' => 'Ã',
		'Atilde' => 'Ã',
		'atilde;' => 'ã',
		'atilde' => 'ã',
		'Auml;' => 'Ä',
		'Auml' => 'Ä',
		'auml;' => 'ä',
		'auml' => 'ä',
		'awconint;' => '∳',
		'awint;' => '⨑',
		'backcong;' => '≌',
		'backepsilon;' => '϶',
		'backprime;' => '‵',
		'backsim;' => '∽',
		'backsimeq;' => '⋍',
		'Backslash;' => '∖',
		'Barv;' => '⫧',
		'barvee;' => '⊽',
		'barwed;' => '⌅',
		'Barwed;' => '⌆',
		'barwedge;' => '⌅',
		'bbrk;' => '⎵',
		'bbrktbrk;' => '⎶',
		'bcong;' => '≌',
		'Bcy;' => 'Б',
		'bcy;' => 'б',
		'bdquo;' => '„',
		'becaus;' => '∵',
		'because;' => '∵',
		'Because;' => '∵',
		'bemptyv;' => '⦰',
		'bepsi;' => '϶',
		'bernou;' => 'ℬ',
		'Bernoullis;' => 'ℬ',
		'Beta;' => 'Β',
		'beta;' => 'β',
		'beth;' => 'ℶ',
		'between;' => '≬',
		'Bfr;' => '𝔅',
		'bfr;' => '𝔟',
		'bigcap;' => '⋂',
		'bigcirc;' => '◯',
		'bigcup;' => '⋃',
		'bigodot;' => '⨀',
		'bigoplus;' => '⨁',
		'bigotimes;' => '⨂',
		'bigsqcup;' => '⨆',
		'bigstar;' => '★',
		'bigtriangledown;' => '▽',
		'bigtriangleup;' => '△',
		'biguplus;' => '⨄',
		'bigvee;' => '⋁',
		'bigwedge;' => '⋀',
		'bkarow;' => '⤍',
		'blacklozenge;' => '⧫',
		'blacksquare;' => '▪',
		'blacktriangle;' => '▴',
		'blacktriangledown;' => '▾',
		'blacktriangleleft;' => '◂',
		'blacktriangleright;' => '▸',
		'blank;' => '␣',
		'blk12;' => '▒',
		'blk14;' => '░',
		'blk34;' => '▓',
		'block;' => '█',
		'bne;' => '=⃥',
		'bnequiv;' => '≡⃥',
		'bNot;' => '⫭',
		'bnot;' => '⌐',
		'Bopf;' => '𝔹',
		'bopf;' => '𝕓',
		'bot;' => '⊥',
		'bottom;' => '⊥',
		'bowtie;' => '⋈',
		'boxbox;' => '⧉',
		'boxdl;' => '┐',
		'boxdL;' => '╕',
		'boxDl;' => '╖',
		'boxDL;' => '╗',
		'boxdr;' => '┌',
		'boxdR;' => '╒',
		'boxDr;' => '╓',
		'boxDR;' => '╔',
		'boxh;' => '─',
		'boxH;' => '═',
		'boxhd;' => '┬',
		'boxHd;' => '╤',
		'boxhD;' => '╥',
		'boxHD;' => '╦',
		'boxhu;' => '┴',
		'boxHu;' => '╧',
		'boxhU;' => '╨',
		'boxHU;' => '╩',
		'boxminus;' => '⊟',
		'boxplus;' => '⊞',
		'boxtimes;' => '⊠',
		'boxul;' => '┘',
		'boxuL;' => '╛',
		'boxUl;' => '╜',
		'boxUL;' => '╝',
		'boxur;' => '└',
		'boxuR;' => '╘',
		'boxUr;' => '╙',
		'boxUR;' => '╚',
		'boxv;' => '│',
		'boxV;' => '║',
		'boxvh;' => '┼',
		'boxvH;' => '╪',
		'boxVh;' => '╫',
		'boxVH;' => '╬',
		'boxvl;' => '┤',
		'boxvL;' => '╡',
		'boxVl;' => '╢',
		'boxVL;' => '╣',
		'boxvr;' => '├',
		'boxvR;' => '╞',
		'boxVr;' => '╟',
		'boxVR;' => '╠',
		'bprime;' => '‵',
		'breve;' => '˘',
		'Breve;' => '˘',
		'brvbar;' => '¦',
		'brvbar' => '¦',
		'bscr;' => '𝒷',
		'Bscr;' => 'ℬ',
		'bsemi;' => '⁏',
		'bsim;' => '∽',
		'bsime;' => '⋍',
		'bsolb;' => '⧅',
		'bsol;' => '\\',
		'bsolhsub;' => '⟈',
		'bull;' => '•',
		'bullet;' => '•',
		'bump;' => '≎',
		'bumpE;' => '⪮',
		'bumpe;' => '≏',
		'Bumpeq;' => '≎',
		'bumpeq;' => '≏',
		'Cacute;' => 'Ć',
		'cacute;' => 'ć',
		'capand;' => '⩄',
		'capbrcup;' => '⩉',
		'capcap;' => '⩋',
		'cap;' => '∩',
		'Cap;' => '⋒',
		'capcup;' => '⩇',
		'capdot;' => '⩀',
		'CapitalDifferentialD;' => 'ⅅ',
		'caps;' => '∩︀',
		'caret;' => '⁁',
		'caron;' => 'ˇ',
		'Cayleys;' => 'ℭ',
		'ccaps;' => '⩍',
		'Ccaron;' => 'Č',
		'ccaron;' => 'č',
		'Ccedil;' => 'Ç',
		'Ccedil' => 'Ç',
		'ccedil;' => 'ç',
		'ccedil' => 'ç',
		'Ccirc;' => 'Ĉ',
		'ccirc;' => 'ĉ',
		'Cconint;' => '∰',
		'ccups;' => '⩌',
		'ccupssm;' => '⩐',
		'Cdot;' => 'Ċ',
		'cdot;' => 'ċ',
		'cedil;' => '¸',
		'cedil' => '¸',
		'Cedilla;' => '¸',
		'cemptyv;' => '⦲',
		'cent;' => '¢',
		'cent' => '¢',
		'centerdot;' => '·',
		'CenterDot;' => '·',
		'cfr;' => '𝔠',
		'Cfr;' => 'ℭ',
		'CHcy;' => 'Ч',
		'chcy;' => 'ч',
		'check;' => '✓',
		'checkmark;' => '✓',
		'Chi;' => 'Χ',
		'chi;' => 'χ',
		'circ;' => 'ˆ',
		'circeq;' => '≗',
		'circlearrowleft;' => '↺',
		'circlearrowright;' => '↻',
		'circledast;' => '⊛',
		'circledcirc;' => '⊚',
		'circleddash;' => '⊝',
		'CircleDot;' => '⊙',
		'circledR;' => '®',
		'circledS;' => 'Ⓢ',
		'CircleMinus;' => '⊖',
		'CirclePlus;' => '⊕',
		'CircleTimes;' => '⊗',
		'cir;' => '○',
		'cirE;' => '⧃',
		'cire;' => '≗',
		'cirfnint;' => '⨐',
		'cirmid;' => '⫯',
		'cirscir;' => '⧂',
		'ClockwiseContourIntegral;' => '∲',
		'CloseCurlyDoubleQuote;' => '”',
		'CloseCurlyQuote;' => '’',
		'clubs;' => '♣',
		'clubsuit;' => '♣',
		'colon;' => ':',
		'Colon;' => '∷',
		'Colone;' => '⩴',
		'colone;' => '≔',
		'coloneq;' => '≔',
		'comma;' => ',',
		'commat;' => '@',
		'comp;' => '∁',
		'compfn;' => '∘',
		'complement;' => '∁',
		'complexes;' => 'ℂ',
		'cong;' => '≅',
		'congdot;' => '⩭',
		'Congruent;' => '≡',
		'conint;' => '∮',
		'Conint;' => '∯',
		'ContourIntegral;' => '∮',
		'copf;' => '𝕔',
		'Copf;' => 'ℂ',
		'coprod;' => '∐',
		'Coproduct;' => '∐',
		'copy;' => '©',
		'copy' => '©',
		'COPY;' => '©',
		'COPY' => '©',
		'copysr;' => '℗',
		'CounterClockwiseContourIntegral;' => '∳',
		'crarr;' => '↵',
		'cross;' => '✗',
		'Cross;' => '⨯',
		'Cscr;' => '𝒞',
		'cscr;' => '𝒸',
		'csub;' => '⫏',
		'csube;' => '⫑',
		'csup;' => '⫐',
		'csupe;' => '⫒',
		'ctdot;' => '⋯',
		'cudarrl;' => '⤸',
		'cudarrr;' => '⤵',
		'cuepr;' => '⋞',
		'cuesc;' => '⋟',
		'cularr;' => '↶',
		'cularrp;' => '⤽',
		'cupbrcap;' => '⩈',
		'cupcap;' => '⩆',
		'CupCap;' => '≍',
		'cup;' => '∪',
		'Cup;' => '⋓',
		'cupcup;' => '⩊',
		'cupdot;' => '⊍',
		'cupor;' => '⩅',
		'cups;' => '∪︀',
		'curarr;' => '↷',
		'curarrm;' => '⤼',
		'curlyeqprec;' => '⋞',
		'curlyeqsucc;' => '⋟',
		'curlyvee;' => '⋎',
		'curlywedge;' => '⋏',
		'curren;' => '¤',
		'curren' => '¤',
		'curvearrowleft;' => '↶',
		'curvearrowright;' => '↷',
		'cuvee;' => '⋎',
		'cuwed;' => '⋏',
		'cwconint;' => '∲',
		'cwint;' => '∱',
		'cylcty;' => '⌭',
		'dagger;' => '†',
		'Dagger;' => '‡',
		'daleth;' => 'ℸ',
		'darr;' => '↓',
		'Darr;' => '↡',
		'dArr;' => '⇓',
		'dash;' => '‐',
		'Dashv;' => '⫤',
		'dashv;' => '⊣',
		'dbkarow;' => '⤏',
		'dblac;' => '˝',
		'Dcaron;' => 'Ď',
		'dcaron;' => 'ď',
		'Dcy;' => 'Д',
		'dcy;' => 'д',
		'ddagger;' => '‡',
		'ddarr;' => '⇊',
		'DD;' => 'ⅅ',
		'dd;' => 'ⅆ',
		'DDotrahd;' => '⤑',
		'ddotseq;' => '⩷',
		'deg;' => '°',
		'deg' => '°',
		'Del;' => '∇',
		'Delta;' => 'Δ',
		'delta;' => 'δ',
		'demptyv;' => '⦱',
		'dfisht;' => '⥿',
		'Dfr;' => '𝔇',
		'dfr;' => '𝔡',
		'dHar;' => '⥥',
		'dharl;' => '⇃',
		'dharr;' => '⇂',
		'DiacriticalAcute;' => '´',
		'DiacriticalDot;' => '˙',
		'DiacriticalDoubleAcute;' => '˝',
		'DiacriticalGrave;' => '`',
		'DiacriticalTilde;' => '˜',
		'diam;' => '⋄',
		'diamond;' => '⋄',
		'Diamond;' => '⋄',
		'diamondsuit;' => '♦',
		'diams;' => '♦',
		'die;' => '¨',
		'DifferentialD;' => 'ⅆ',
		'digamma;' => 'ϝ',
		'disin;' => '⋲',
		'div;' => '÷',
		'divide;' => '÷',
		'divide' => '÷',
		'divideontimes;' => '⋇',
		'divonx;' => '⋇',
		'DJcy;' => 'Ђ',
		'djcy;' => 'ђ',
		'dlcorn;' => '⌞',
		'dlcrop;' => '⌍',
		'dollar;' => '$',
		'Dopf;' => '𝔻',
		'dopf;' => '𝕕',
		'Dot;' => '¨',
		'dot;' => '˙',
		'DotDot;' => '⃜',
		'doteq;' => '≐',
		'doteqdot;' => '≑',
		'DotEqual;' => '≐',
		'dotminus;' => '∸',
		'dotplus;' => '∔',
		'dotsquare;' => '⊡',
		'doublebarwedge;' => '⌆',
		'DoubleContourIntegral;' => '∯',
		'DoubleDot;' => '¨',
		'DoubleDownArrow;' => '⇓',
		'DoubleLeftArrow;' => '⇐',
		'DoubleLeftRightArrow;' => '⇔',
		'DoubleLeftTee;' => '⫤',
		'DoubleLongLeftArrow;' => '⟸',
		'DoubleLongLeftRightArrow;' => '⟺',
		'DoubleLongRightArrow;' => '⟹',
		'DoubleRightArrow;' => '⇒',
		'DoubleRightTee;' => '⊨',
		'DoubleUpArrow;' => '⇑',
		'DoubleUpDownArrow;' => '⇕',
		'DoubleVerticalBar;' => '∥',
		'DownArrowBar;' => '⤓',
		'downarrow;' => '↓',
		'DownArrow;' => '↓',
		'Downarrow;' => '⇓',
		'DownArrowUpArrow;' => '⇵',
		'DownBreve;' => '̑',
		'downdownarrows;' => '⇊',
		'downharpoonleft;' => '⇃',
		'downharpoonright;' => '⇂',
		'DownLeftRightVector;' => '⥐',
		'DownLeftTeeVector;' => '⥞',
		'DownLeftVectorBar;' => '⥖',
		'DownLeftVector;' => '↽',
		'DownRightTeeVector;' => '⥟',
		'DownRightVectorBar;' => '⥗',
		'DownRightVector;' => '⇁',
		'DownTeeArrow;' => '↧',
		'DownTee;' => '⊤',
		'drbkarow;' => '⤐',
		'drcorn;' => '⌟',
		'drcrop;' => '⌌',
		'Dscr;' => '𝒟',
		'dscr;' => '𝒹',
		'DScy;' => 'Ѕ',
		'dscy;' => 'ѕ',
		'dsol;' => '⧶',
		'Dstrok;' => 'Đ',
		'dstrok;' => 'đ',
		'dtdot;' => '⋱',
		'dtri;' => '▿',
		'dtrif;' => '▾',
		'duarr;' => '⇵',
		'duhar;' => '⥯',
		'dwangle;' => '⦦',
		'DZcy;' => 'Џ',
		'dzcy;' => 'џ',
		'dzigrarr;' => '⟿',
		'Eacute;' => 'É',
		'Eacute' => 'É',
		'eacute;' => 'é',
		'eacute' => 'é',
		'easter;' => '⩮',
		'Ecaron;' => 'Ě',
		'ecaron;' => 'ě',
		'Ecirc;' => 'Ê',
		'Ecirc' => 'Ê',
		'ecirc;' => 'ê',
		'ecirc' => 'ê',
		'ecir;' => '≖',
		'ecolon;' => '≕',
		'Ecy;' => 'Э',
		'ecy;' => 'э',
		'eDDot;' => '⩷',
		'Edot;' => 'Ė',
		'edot;' => 'ė',
		'eDot;' => '≑',
		'ee;' => 'ⅇ',
		'efDot;' => '≒',
		'Efr;' => '𝔈',
		'efr;' => '𝔢',
		'eg;' => '⪚',
		'Egrave;' => 'È',
		'Egrave' => 'È',
		'egrave;' => 'è',
		'egrave' => 'è',
		'egs;' => '⪖',
		'egsdot;' => '⪘',
		'el;' => '⪙',
		'Element;' => '∈',
		'elinters;' => '⏧',
		'ell;' => 'ℓ',
		'els;' => '⪕',
		'elsdot;' => '⪗',
		'Emacr;' => 'Ē',
		'emacr;' => 'ē',
		'empty;' => '∅',
		'emptyset;' => '∅',
		'EmptySmallSquare;' => '◻',
		'emptyv;' => '∅',
		'EmptyVerySmallSquare;' => '▫',
		'emsp13;' => ' ',
		'emsp14;' => ' ',
		'emsp;' => ' ',
		'ENG;' => 'Ŋ',
		'eng;' => 'ŋ',
		'ensp;' => ' ',
		'Eogon;' => 'Ę',
		'eogon;' => 'ę',
		'Eopf;' => '𝔼',
		'eopf;' => '𝕖',
		'epar;' => '⋕',
		'eparsl;' => '⧣',
		'eplus;' => '⩱',
		'epsi;' => 'ε',
		'Epsilon;' => 'Ε',
		'epsilon;' => 'ε',
		'epsiv;' => 'ϵ',
		'eqcirc;' => '≖',
		'eqcolon;' => '≕',
		'eqsim;' => '≂',
		'eqslantgtr;' => '⪖',
		'eqslantless;' => '⪕',
		'Equal;' => '⩵',
		'equals;' => '=',
		'EqualTilde;' => '≂',
		'equest;' => '≟',
		'Equilibrium;' => '⇌',
		'equiv;' => '≡',
		'equivDD;' => '⩸',
		'eqvparsl;' => '⧥',
		'erarr;' => '⥱',
		'erDot;' => '≓',
		'escr;' => 'ℯ',
		'Escr;' => 'ℰ',
		'esdot;' => '≐',
		'Esim;' => '⩳',
		'esim;' => '≂',
		'Eta;' => 'Η',
		'eta;' => 'η',
		'ETH;' => 'Ð',
		'ETH' => 'Ð',
		'eth;' => 'ð',
		'eth' => 'ð',
		'Euml;' => 'Ë',
		'Euml' => 'Ë',
		'euml;' => 'ë',
		'euml' => 'ë',
		'euro;' => '€',
		'excl;' => '!',
		'exist;' => '∃',
		'Exists;' => '∃',
		'expectation;' => 'ℰ',
		'exponentiale;' => 'ⅇ',
		'ExponentialE;' => 'ⅇ',
		'fallingdotseq;' => '≒',
		'Fcy;' => 'Ф',
		'fcy;' => 'ф',
		'female;' => '♀',
		'ffilig;' => 'ﬃ',
		'fflig;' => 'ﬀ',
		'ffllig;' => 'ﬄ',
		'Ffr;' => '𝔉',
		'ffr;' => '𝔣',
		'filig;' => 'ﬁ',
		'FilledSmallSquare;' => '◼',
		'FilledVerySmallSquare;' => '▪',
		'fjlig;' => 'fj',
		'flat;' => '♭',
		'fllig;' => 'ﬂ',
		'fltns;' => '▱',
		'fnof;' => 'ƒ',
		'Fopf;' => '𝔽',
		'fopf;' => '𝕗',
		'forall;' => '∀',
		'ForAll;' => '∀',
		'fork;' => '⋔',
		'forkv;' => '⫙',
		'Fouriertrf;' => 'ℱ',
		'fpartint;' => '⨍',
		'frac12;' => '½',
		'frac12' => '½',
		'frac13;' => '⅓',
		'frac14;' => '¼',
		'frac14' => '¼',
		'frac15;' => '⅕',
		'frac16;' => '⅙',
		'frac18;' => '⅛',
		'frac23;' => '⅔',
		'frac25;' => '⅖',
		'frac34;' => '¾',
		'frac34' => '¾',
		'frac35;' => '⅗',
		'frac38;' => '⅜',
		'frac45;' => '⅘',
		'frac56;' => '⅚',
		'frac58;' => '⅝',
		'frac78;' => '⅞',
		'frasl;' => '⁄',
		'frown;' => '⌢',
		'fscr;' => '𝒻',
		'Fscr;' => 'ℱ',
		'gacute;' => 'ǵ',
		'Gamma;' => 'Γ',
		'gamma;' => 'γ',
		'Gammad;' => 'Ϝ',
		'gammad;' => 'ϝ',
		'gap;' => '⪆',
		'Gbreve;' => 'Ğ',
		'gbreve;' => 'ğ',
		'Gcedil;' => 'Ģ',
		'Gcirc;' => 'Ĝ',
		'gcirc;' => 'ĝ',
		'Gcy;' => 'Г',
		'gcy;' => 'г',
		'Gdot;' => 'Ġ',
		'gdot;' => 'ġ',
		'ge;' => '≥',
		'gE;' => '≧',
		'gEl;' => '⪌',
		'gel;' => '⋛',
		'geq;' => '≥',
		'geqq;' => '≧',
		'geqslant;' => '⩾',
		'gescc;' => '⪩',
		'ges;' => '⩾',
		'gesdot;' => '⪀',
		'gesdoto;' => '⪂',
		'gesdotol;' => '⪄',
		'gesl;' => '⋛︀',
		'gesles;' => '⪔',
		'Gfr;' => '𝔊',
		'gfr;' => '𝔤',
		'gg;' => '≫',
		'Gg;' => '⋙',
		'ggg;' => '⋙',
		'gimel;' => 'ℷ',
		'GJcy;' => 'Ѓ',
		'gjcy;' => 'ѓ',
		'gla;' => '⪥',
		'gl;' => '≷',
		'glE;' => '⪒',
		'glj;' => '⪤',
		'gnap;' => '⪊',
		'gnapprox;' => '⪊',
		'gne;' => '⪈',
		'gnE;' => '≩',
		'gneq;' => '⪈',
		'gneqq;' => '≩',
		'gnsim;' => '⋧',
		'Gopf;' => '𝔾',
		'gopf;' => '𝕘',
		'grave;' => '`',
		'GreaterEqual;' => '≥',
		'GreaterEqualLess;' => '⋛',
		'GreaterFullEqual;' => '≧',
		'GreaterGreater;' => '⪢',
		'GreaterLess;' => '≷',
		'GreaterSlantEqual;' => '⩾',
		'GreaterTilde;' => '≳',
		'Gscr;' => '𝒢',
		'gscr;' => 'ℊ',
		'gsim;' => '≳',
		'gsime;' => '⪎',
		'gsiml;' => '⪐',
		'gtcc;' => '⪧',
		'gtcir;' => '⩺',
		'gt;' => '>',
		'gt' => '>',
		'GT;' => '>',
		'GT' => '>',
		'Gt;' => '≫',
		'gtdot;' => '⋗',
		'gtlPar;' => '⦕',
		'gtquest;' => '⩼',
		'gtrapprox;' => '⪆',
		'gtrarr;' => '⥸',
		'gtrdot;' => '⋗',
		'gtreqless;' => '⋛',
		'gtreqqless;' => '⪌',
		'gtrless;' => '≷',
		'gtrsim;' => '≳',
		'gvertneqq;' => '≩︀',
		'gvnE;' => '≩︀',
		'Hacek;' => 'ˇ',
		'hairsp;' => ' ',
		'half;' => '½',
		'hamilt;' => 'ℋ',
		'HARDcy;' => 'Ъ',
		'hardcy;' => 'ъ',
		'harrcir;' => '⥈',
		'harr;' => '↔',
		'hArr;' => '⇔',
		'harrw;' => '↭',
		'Hat;' => '^',
		'hbar;' => 'ℏ',
		'Hcirc;' => 'Ĥ',
		'hcirc;' => 'ĥ',
		'hearts;' => '♥',
		'heartsuit;' => '♥',
		'hellip;' => '…',
		'hercon;' => '⊹',
		'hfr;' => '𝔥',
		'Hfr;' => 'ℌ',
		'HilbertSpace;' => 'ℋ',
		'hksearow;' => '⤥',
		'hkswarow;' => '⤦',
		'hoarr;' => '⇿',
		'homtht;' => '∻',
		'hookleftarrow;' => '↩',
		'hookrightarrow;' => '↪',
		'hopf;' => '𝕙',
		'Hopf;' => 'ℍ',
		'horbar;' => '―',
		'HorizontalLine;' => '─',
		'hscr;' => '𝒽',
		'Hscr;' => 'ℋ',
		'hslash;' => 'ℏ',
		'Hstrok;' => 'Ħ',
		'hstrok;' => 'ħ',
		'HumpDownHump;' => '≎',
		'HumpEqual;' => '≏',
		'hybull;' => '⁃',
		'hyphen;' => '‐',
		'Iacute;' => 'Í',
		'Iacute' => 'Í',
		'iacute;' => 'í',
		'iacute' => 'í',
		'ic;' => '⁣',
		'Icirc;' => 'Î',
		'Icirc' => 'Î',
		'icirc;' => 'î',
		'icirc' => 'î',
		'Icy;' => 'И',
		'icy;' => 'и',
		'Idot;' => 'İ',
		'IEcy;' => 'Е',
		'iecy;' => 'е',
		'iexcl;' => '¡',
		'iexcl' => '¡',
		'iff;' => '⇔',
		'ifr;' => '𝔦',
		'Ifr;' => 'ℑ',
		'Igrave;' => 'Ì',
		'Igrave' => 'Ì',
		'igrave;' => 'ì',
		'igrave' => 'ì',
		'ii;' => 'ⅈ',
		'iiiint;' => '⨌',
		'iiint;' => '∭',
		'iinfin;' => '⧜',
		'iiota;' => '℩',
		'IJlig;' => 'Ĳ',
		'ijlig;' => 'ĳ',
		'Imacr;' => 'Ī',
		'imacr;' => 'ī',
		'image;' => 'ℑ',
		'ImaginaryI;' => 'ⅈ',
		'imagline;' => 'ℐ',
		'imagpart;' => 'ℑ',
		'imath;' => 'ı',
		'Im;' => 'ℑ',
		'imof;' => '⊷',
		'imped;' => 'Ƶ',
		'Implies;' => '⇒',
		'incare;' => '℅',
		'in;' => '∈',
		'infin;' => '∞',
		'infintie;' => '⧝',
		'inodot;' => 'ı',
		'intcal;' => '⊺',
		'int;' => '∫',
		'Int;' => '∬',
		'integers;' => 'ℤ',
		'Integral;' => '∫',
		'intercal;' => '⊺',
		'Intersection;' => '⋂',
		'intlarhk;' => '⨗',
		'intprod;' => '⨼',
		'InvisibleComma;' => '⁣',
		'InvisibleTimes;' => '⁢',
		'IOcy;' => 'Ё',
		'iocy;' => 'ё',
		'Iogon;' => 'Į',
		'iogon;' => 'į',
		'Iopf;' => '𝕀',
		'iopf;' => '𝕚',
		'Iota;' => 'Ι',
		'iota;' => 'ι',
		'iprod;' => '⨼',
		'iquest;' => '¿',
		'iquest' => '¿',
		'iscr;' => '𝒾',
		'Iscr;' => 'ℐ',
		'isin;' => '∈',
		'isindot;' => '⋵',
		'isinE;' => '⋹',
		'isins;' => '⋴',
		'isinsv;' => '⋳',
		'isinv;' => '∈',
		'it;' => '⁢',
		'Itilde;' => 'Ĩ',
		'itilde;' => 'ĩ',
		'Iukcy;' => 'І',
		'iukcy;' => 'і',
		'Iuml;' => 'Ï',
		'Iuml' => 'Ï',
		'iuml;' => 'ï',
		'iuml' => 'ï',
		'Jcirc;' => 'Ĵ',
		'jcirc;' => 'ĵ',
		'Jcy;' => 'Й',
		'jcy;' => 'й',
		'Jfr;' => '𝔍',
		'jfr;' => '𝔧',
		'jmath;' => 'ȷ',
		'Jopf;' => '𝕁',
		'jopf;' => '𝕛',
		'Jscr;' => '𝒥',
		'jscr;' => '𝒿',
		'Jsercy;' => 'Ј',
		'jsercy;' => 'ј',
		'Jukcy;' => 'Є',
		'jukcy;' => 'є',
		'Kappa;' => 'Κ',
		'kappa;' => 'κ',
		'kappav;' => 'ϰ',
		'Kcedil;' => 'Ķ',
		'kcedil;' => 'ķ',
		'Kcy;' => 'К',
		'kcy;' => 'к',
		'Kfr;' => '𝔎',
		'kfr;' => '𝔨',
		'kgreen;' => 'ĸ',
		'KHcy;' => 'Х',
		'khcy;' => 'х',
		'KJcy;' => 'Ќ',
		'kjcy;' => 'ќ',
		'Kopf;' => '𝕂',
		'kopf;' => '𝕜',
		'Kscr;' => '𝒦',
		'kscr;' => '𝓀',
		'lAarr;' => '⇚',
		'Lacute;' => 'Ĺ',
		'lacute;' => 'ĺ',
		'laemptyv;' => '⦴',
		'lagran;' => 'ℒ',
		'Lambda;' => 'Λ',
		'lambda;' => 'λ',
		'lang;' => '⟨',
		'Lang;' => '⟪',
		'langd;' => '⦑',
		'langle;' => '⟨',
		'lap;' => '⪅',
		'Laplacetrf;' => 'ℒ',
		'laquo;' => '«',
		'laquo' => '«',
		'larrb;' => '⇤',
		'larrbfs;' => '⤟',
		'larr;' => '←',
		'Larr;' => '↞',
		'lArr;' => '⇐',
		'larrfs;' => '⤝',
		'larrhk;' => '↩',
		'larrlp;' => '↫',
		'larrpl;' => '⤹',
		'larrsim;' => '⥳',
		'larrtl;' => '↢',
		'latail;' => '⤙',
		'lAtail;' => '⤛',
		'lat;' => '⪫',
		'late;' => '⪭',
		'lates;' => '⪭︀',
		'lbarr;' => '⤌',
		'lBarr;' => '⤎',
		'lbbrk;' => '❲',
		'lbrace;' => '{',
		'lbrack;' => '[',
		'lbrke;' => '⦋',
		'lbrksld;' => '⦏',
		'lbrkslu;' => '⦍',
		'Lcaron;' => 'Ľ',
		'lcaron;' => 'ľ',
		'Lcedil;' => 'Ļ',
		'lcedil;' => 'ļ',
		'lceil;' => '⌈',
		'lcub;' => '{',
		'Lcy;' => 'Л',
		'lcy;' => 'л',
		'ldca;' => '⤶',
		'ldquo;' => '“',
		'ldquor;' => '„',
		'ldrdhar;' => '⥧',
		'ldrushar;' => '⥋',
		'ldsh;' => '↲',
		'le;' => '≤',
		'lE;' => '≦',
		'LeftAngleBracket;' => '⟨',
		'LeftArrowBar;' => '⇤',
		'leftarrow;' => '←',
		'LeftArrow;' => '←',
		'Leftarrow;' => '⇐',
		'LeftArrowRightArrow;' => '⇆',
		'leftarrowtail;' => '↢',
		'LeftCeiling;' => '⌈',
		'LeftDoubleBracket;' => '⟦',
		'LeftDownTeeVector;' => '⥡',
		'LeftDownVectorBar;' => '⥙',
		'LeftDownVector;' => '⇃',
		'LeftFloor;' => '⌊',
		'leftharpoondown;' => '↽',
		'leftharpoonup;' => '↼',
		'leftleftarrows;' => '⇇',
		'leftrightarrow;' => '↔',
		'LeftRightArrow;' => '↔',
		'Leftrightarrow;' => '⇔',
		'leftrightarrows;' => '⇆',
		'leftrightharpoons;' => '⇋',
		'leftrightsquigarrow;' => '↭',
		'LeftRightVector;' => '⥎',
		'LeftTeeArrow;' => '↤',
		'LeftTee;' => '⊣',
		'LeftTeeVector;' => '⥚',
		'leftthreetimes;' => '⋋',
		'LeftTriangleBar;' => '⧏',
		'LeftTriangle;' => '⊲',
		'LeftTriangleEqual;' => '⊴',
		'LeftUpDownVector;' => '⥑',
		'LeftUpTeeVector;' => '⥠',
		'LeftUpVectorBar;' => '⥘',
		'LeftUpVector;' => '↿',
		'LeftVectorBar;' => '⥒',
		'LeftVector;' => '↼',
		'lEg;' => '⪋',
		'leg;' => '⋚',
		'leq;' => '≤',
		'leqq;' => '≦',
		'leqslant;' => '⩽',
		'lescc;' => '⪨',
		'les;' => '⩽',
		'lesdot;' => '⩿',
		'lesdoto;' => '⪁',
		'lesdotor;' => '⪃',
		'lesg;' => '⋚︀',
		'lesges;' => '⪓',
		'lessapprox;' => '⪅',
		'lessdot;' => '⋖',
		'lesseqgtr;' => '⋚',
		'lesseqqgtr;' => '⪋',
		'LessEqualGreater;' => '⋚',
		'LessFullEqual;' => '≦',
		'LessGreater;' => '≶',
		'lessgtr;' => '≶',
		'LessLess;' => '⪡',
		'lesssim;' => '≲',
		'LessSlantEqual;' => '⩽',
		'LessTilde;' => '≲',
		'lfisht;' => '⥼',
		'lfloor;' => '⌊',
		'Lfr;' => '𝔏',
		'lfr;' => '𝔩',
		'lg;' => '≶',
		'lgE;' => '⪑',
		'lHar;' => '⥢',
		'lhard;' => '↽',
		'lharu;' => '↼',
		'lharul;' => '⥪',
		'lhblk;' => '▄',
		'LJcy;' => 'Љ',
		'ljcy;' => 'љ',
		'llarr;' => '⇇',
		'll;' => '≪',
		'Ll;' => '⋘',
		'llcorner;' => '⌞',
		'Lleftarrow;' => '⇚',
		'llhard;' => '⥫',
		'lltri;' => '◺',
		'Lmidot;' => 'Ŀ',
		'lmidot;' => 'ŀ',
		'lmoustache;' => '⎰',
		'lmoust;' => '⎰',
		'lnap;' => '⪉',
		'lnapprox;' => '⪉',
		'lne;' => '⪇',
		'lnE;' => '≨',
		'lneq;' => '⪇',
		'lneqq;' => '≨',
		'lnsim;' => '⋦',
		'loang;' => '⟬',
		'loarr;' => '⇽',
		'lobrk;' => '⟦',
		'longleftarrow;' => '⟵',
		'LongLeftArrow;' => '⟵',
		'Longleftarrow;' => '⟸',
		'longleftrightarrow;' => '⟷',
		'LongLeftRightArrow;' => '⟷',
		'Longleftrightarrow;' => '⟺',
		'longmapsto;' => '⟼',
		'longrightarrow;' => '⟶',
		'LongRightArrow;' => '⟶',
		'Longrightarrow;' => '⟹',
		'looparrowleft;' => '↫',
		'looparrowright;' => '↬',
		'lopar;' => '⦅',
		'Lopf;' => '𝕃',
		'lopf;' => '𝕝',
		'loplus;' => '⨭',
		'lotimes;' => '⨴',
		'lowast;' => '∗',
		'lowbar;' => '_',
		'LowerLeftArrow;' => '↙',
		'LowerRightArrow;' => '↘',
		'loz;' => '◊',
		'lozenge;' => '◊',
		'lozf;' => '⧫',
		'lpar;' => '(',
		'lparlt;' => '⦓',
		'lrarr;' => '⇆',
		'lrcorner;' => '⌟',
		'lrhar;' => '⇋',
		'lrhard;' => '⥭',
		'lrm;' => '‎',
		'lrtri;' => '⊿',
		'lsaquo;' => '‹',
		'lscr;' => '𝓁',
		'Lscr;' => 'ℒ',
		'lsh;' => '↰',
		'Lsh;' => '↰',
		'lsim;' => '≲',
		'lsime;' => '⪍',
		'lsimg;' => '⪏',
		'lsqb;' => '[',
		'lsquo;' => '‘',
		'lsquor;' => '‚',
		'Lstrok;' => 'Ł',
		'lstrok;' => 'ł',
		'ltcc;' => '⪦',
		'ltcir;' => '⩹',
		'lt;' => '<',
		'lt' => '<',
		'LT;' => '<',
		'LT' => '<',
		'Lt;' => '≪',
		'ltdot;' => '⋖',
		'lthree;' => '⋋',
		'ltimes;' => '⋉',
		'ltlarr;' => '⥶',
		'ltquest;' => '⩻',
		'ltri;' => '◃',
		'ltrie;' => '⊴',
		'ltrif;' => '◂',
		'ltrPar;' => '⦖',
		'lurdshar;' => '⥊',
		'luruhar;' => '⥦',
		'lvertneqq;' => '≨︀',
		'lvnE;' => '≨︀',
		'macr;' => '¯',
		'macr' => '¯',
		'male;' => '♂',
		'malt;' => '✠',
		'maltese;' => '✠',
		'Map;' => '⤅',
		'map;' => '↦',
		'mapsto;' => '↦',
		'mapstodown;' => '↧',
		'mapstoleft;' => '↤',
		'mapstoup;' => '↥',
		'marker;' => '▮',
		'mcomma;' => '⨩',
		'Mcy;' => 'М',
		'mcy;' => 'м',
		'mdash;' => '—',
		'mDDot;' => '∺',
		'measuredangle;' => '∡',
		'MediumSpace;' => ' ',
		'Mellintrf;' => 'ℳ',
		'Mfr;' => '𝔐',
		'mfr;' => '𝔪',
		'mho;' => '℧',
		'micro;' => 'µ',
		'micro' => 'µ',
		'midast;' => '*',
		'midcir;' => '⫰',
		'mid;' => '∣',
		'middot;' => '·',
		'middot' => '·',
		'minusb;' => '⊟',
		'minus;' => '−',
		'minusd;' => '∸',
		'minusdu;' => '⨪',
		'MinusPlus;' => '∓',
		'mlcp;' => '⫛',
		'mldr;' => '…',
		'mnplus;' => '∓',
		'models;' => '⊧',
		'Mopf;' => '𝕄',
		'mopf;' => '𝕞',
		'mp;' => '∓',
		'mscr;' => '𝓂',
		'Mscr;' => 'ℳ',
		'mstpos;' => '∾',
		'Mu;' => 'Μ',
		'mu;' => 'μ',
		'multimap;' => '⊸',
		'mumap;' => '⊸',
		'nabla;' => '∇',
		'Nacute;' => 'Ń',
		'nacute;' => 'ń',
		'nang;' => '∠⃒',
		'nap;' => '≉',
		'napE;' => '⩰̸',
		'napid;' => '≋̸',
		'napos;' => 'ŉ',
		'napprox;' => '≉',
		'natural;' => '♮',
		'naturals;' => 'ℕ',
		'natur;' => '♮',
		'nbsp;' => ' ',
		'nbsp' => ' ',
		'nbump;' => '≎̸',
		'nbumpe;' => '≏̸',
		'ncap;' => '⩃',
		'Ncaron;' => 'Ň',
		'ncaron;' => 'ň',
		'Ncedil;' => 'Ņ',
		'ncedil;' => 'ņ',
		'ncong;' => '≇',
		'ncongdot;' => '⩭̸',
		'ncup;' => '⩂',
		'Ncy;' => 'Н',
		'ncy;' => 'н',
		'ndash;' => '–',
		'nearhk;' => '⤤',
		'nearr;' => '↗',
		'neArr;' => '⇗',
		'nearrow;' => '↗',
		'ne;' => '≠',
		'nedot;' => '≐̸',
		'NegativeMediumSpace;' => '​',
		'NegativeThickSpace;' => '​',
		'NegativeThinSpace;' => '​',
		'NegativeVeryThinSpace;' => '​',
		'nequiv;' => '≢',
		'nesear;' => '⤨',
		'nesim;' => '≂̸',
		'NestedGreaterGreater;' => '≫',
		'NestedLessLess;' => '≪',
		'NewLine;' => '
',
		'nexist;' => '∄',
		'nexists;' => '∄',
		'Nfr;' => '𝔑',
		'nfr;' => '𝔫',
		'ngE;' => '≧̸',
		'nge;' => '≱',
		'ngeq;' => '≱',
		'ngeqq;' => '≧̸',
		'ngeqslant;' => '⩾̸',
		'nges;' => '⩾̸',
		'nGg;' => '⋙̸',
		'ngsim;' => '≵',
		'nGt;' => '≫⃒',
		'ngt;' => '≯',
		'ngtr;' => '≯',
		'nGtv;' => '≫̸',
		'nharr;' => '↮',
		'nhArr;' => '⇎',
		'nhpar;' => '⫲',
		'ni;' => '∋',
		'nis;' => '⋼',
		'nisd;' => '⋺',
		'niv;' => '∋',
		'NJcy;' => 'Њ',
		'njcy;' => 'њ',
		'nlarr;' => '↚',
		'nlArr;' => '⇍',
		'nldr;' => '‥',
		'nlE;' => '≦̸',
		'nle;' => '≰',
		'nleftarrow;' => '↚',
		'nLeftarrow;' => '⇍',
		'nleftrightarrow;' => '↮',
		'nLeftrightarrow;' => '⇎',
		'nleq;' => '≰',
		'nleqq;' => '≦̸',
		'nleqslant;' => '⩽̸',
		'nles;' => '⩽̸',
		'nless;' => '≮',
		'nLl;' => '⋘̸',
		'nlsim;' => '≴',
		'nLt;' => '≪⃒',
		'nlt;' => '≮',
		'nltri;' => '⋪',
		'nltrie;' => '⋬',
		'nLtv;' => '≪̸',
		'nmid;' => '∤',
		'NoBreak;' => '⁠',
		'NonBreakingSpace;' => ' ',
		'nopf;' => '𝕟',
		'Nopf;' => 'ℕ',
		'Not;' => '⫬',
		'not;' => '¬',
		'not' => '¬',
		'NotCongruent;' => '≢',
		'NotCupCap;' => '≭',
		'NotDoubleVerticalBar;' => '∦',
		'NotElement;' => '∉',
		'NotEqual;' => '≠',
		'NotEqualTilde;' => '≂̸',
		'NotExists;' => '∄',
		'NotGreater;' => '≯',
		'NotGreaterEqual;' => '≱',
		'NotGreaterFullEqual;' => '≧̸',
		'NotGreaterGreater;' => '≫̸',
		'NotGreaterLess;' => '≹',
		'NotGreaterSlantEqual;' => '⩾̸',
		'NotGreaterTilde;' => '≵',
		'NotHumpDownHump;' => '≎̸',
		'NotHumpEqual;' => '≏̸',
		'notin;' => '∉',
		'notindot;' => '⋵̸',
		'notinE;' => '⋹̸',
		'notinva;' => '∉',
		'notinvb;' => '⋷',
		'notinvc;' => '⋶',
		'NotLeftTriangleBar;' => '⧏̸',
		'NotLeftTriangle;' => '⋪',
		'NotLeftTriangleEqual;' => '⋬',
		'NotLess;' => '≮',
		'NotLessEqual;' => '≰',
		'NotLessGreater;' => '≸',
		'NotLessLess;' => '≪̸',
		'NotLessSlantEqual;' => '⩽̸',
		'NotLessTilde;' => '≴',
		'NotNestedGreaterGreater;' => '⪢̸',
		'NotNestedLessLess;' => '⪡̸',
		'notni;' => '∌',
		'notniva;' => '∌',
		'notnivb;' => '⋾',
		'notnivc;' => '⋽',
		'NotPrecedes;' => '⊀',
		'NotPrecedesEqual;' => '⪯̸',
		'NotPrecedesSlantEqual;' => '⋠',
		'NotReverseElement;' => '∌',
		'NotRightTriangleBar;' => '⧐̸',
		'NotRightTriangle;' => '⋫',
		'NotRightTriangleEqual;' => '⋭',
		'NotSquareSubset;' => '⊏̸',
		'NotSquareSubsetEqual;' => '⋢',
		'NotSquareSuperset;' => '⊐̸',
		'NotSquareSupersetEqual;' => '⋣',
		'NotSubset;' => '⊂⃒',
		'NotSubsetEqual;' => '⊈',
		'NotSucceeds;' => '⊁',
		'NotSucceedsEqual;' => '⪰̸',
		'NotSucceedsSlantEqual;' => '⋡',
		'NotSucceedsTilde;' => '≿̸',
		'NotSuperset;' => '⊃⃒',
		'NotSupersetEqual;' => '⊉',
		'NotTilde;' => '≁',
		'NotTildeEqual;' => '≄',
		'NotTildeFullEqual;' => '≇',
		'NotTildeTilde;' => '≉',
		'NotVerticalBar;' => '∤',
		'nparallel;' => '∦',
		'npar;' => '∦',
		'nparsl;' => '⫽⃥',
		'npart;' => '∂̸',
		'npolint;' => '⨔',
		'npr;' => '⊀',
		'nprcue;' => '⋠',
		'nprec;' => '⊀',
		'npreceq;' => '⪯̸',
		'npre;' => '⪯̸',
		'nrarrc;' => '⤳̸',
		'nrarr;' => '↛',
		'nrArr;' => '⇏',
		'nrarrw;' => '↝̸',
		'nrightarrow;' => '↛',
		'nRightarrow;' => '⇏',
		'nrtri;' => '⋫',
		'nrtrie;' => '⋭',
		'nsc;' => '⊁',
		'nsccue;' => '⋡',
		'nsce;' => '⪰̸',
		'Nscr;' => '𝒩',
		'nscr;' => '𝓃',
		'nshortmid;' => '∤',
		'nshortparallel;' => '∦',
		'nsim;' => '≁',
		'nsime;' => '≄',
		'nsimeq;' => '≄',
		'nsmid;' => '∤',
		'nspar;' => '∦',
		'nsqsube;' => '⋢',
		'nsqsupe;' => '⋣',
		'nsub;' => '⊄',
		'nsubE;' => '⫅̸',
		'nsube;' => '⊈',
		'nsubset;' => '⊂⃒',
		'nsubseteq;' => '⊈',
		'nsubseteqq;' => '⫅̸',
		'nsucc;' => '⊁',
		'nsucceq;' => '⪰̸',
		'nsup;' => '⊅',
		'nsupE;' => '⫆̸',
		'nsupe;' => '⊉',
		'nsupset;' => '⊃⃒',
		'nsupseteq;' => '⊉',
		'nsupseteqq;' => '⫆̸',
		'ntgl;' => '≹',
		'Ntilde;' => 'Ñ',
		'Ntilde' => 'Ñ',
		'ntilde;' => 'ñ',
		'ntilde' => 'ñ',
		'ntlg;' => '≸',
		'ntriangleleft;' => '⋪',
		'ntrianglelefteq;' => '⋬',
		'ntriangleright;' => '⋫',
		'ntrianglerighteq;' => '⋭',
		'Nu;' => 'Ν',
		'nu;' => 'ν',
		'num;' => '#',
		'numero;' => '№',
		'numsp;' => ' ',
		'nvap;' => '≍⃒',
		'nvdash;' => '⊬',
		'nvDash;' => '⊭',
		'nVdash;' => '⊮',
		'nVDash;' => '⊯',
		'nvge;' => '≥⃒',
		'nvgt;' => '>⃒',
		'nvHarr;' => '⤄',
		'nvinfin;' => '⧞',
		'nvlArr;' => '⤂',
		'nvle;' => '≤⃒',
		'nvlt;' => '<⃒',
		'nvltrie;' => '⊴⃒',
		'nvrArr;' => '⤃',
		'nvrtrie;' => '⊵⃒',
		'nvsim;' => '∼⃒',
		'nwarhk;' => '⤣',
		'nwarr;' => '↖',
		'nwArr;' => '⇖',
		'nwarrow;' => '↖',
		'nwnear;' => '⤧',
		'Oacute;' => 'Ó',
		'Oacute' => 'Ó',
		'oacute;' => 'ó',
		'oacute' => 'ó',
		'oast;' => '⊛',
		'Ocirc;' => 'Ô',
		'Ocirc' => 'Ô',
		'ocirc;' => 'ô',
		'ocirc' => 'ô',
		'ocir;' => '⊚',
		'Ocy;' => 'О',
		'ocy;' => 'о',
		'odash;' => '⊝',
		'Odblac;' => 'Ő',
		'odblac;' => 'ő',
		'odiv;' => '⨸',
		'odot;' => '⊙',
		'odsold;' => '⦼',
		'OElig;' => 'Œ',
		'oelig;' => 'œ',
		'ofcir;' => '⦿',
		'Ofr;' => '𝔒',
		'ofr;' => '𝔬',
		'ogon;' => '˛',
		'Ograve;' => 'Ò',
		'Ograve' => 'Ò',
		'ograve;' => 'ò',
		'ograve' => 'ò',
		'ogt;' => '⧁',
		'ohbar;' => '⦵',
		'ohm;' => 'Ω',
		'oint;' => '∮',
		'olarr;' => '↺',
		'olcir;' => '⦾',
		'olcross;' => '⦻',
		'oline;' => '‾',
		'olt;' => '⧀',
		'Omacr;' => 'Ō',
		'omacr;' => 'ō',
		'Omega;' => 'Ω',
		'omega;' => 'ω',
		'Omicron;' => 'Ο',
		'omicron;' => 'ο',
		'omid;' => '⦶',
		'ominus;' => '⊖',
		'Oopf;' => '𝕆',
		'oopf;' => '𝕠',
		'opar;' => '⦷',
		'OpenCurlyDoubleQuote;' => '“',
		'OpenCurlyQuote;' => '‘',
		'operp;' => '⦹',
		'oplus;' => '⊕',
		'orarr;' => '↻',
		'Or;' => '⩔',
		'or;' => '∨',
		'ord;' => '⩝',
		'order;' => 'ℴ',
		'orderof;' => 'ℴ',
		'ordf;' => 'ª',
		'ordf' => 'ª',
		'ordm;' => 'º',
		'ordm' => 'º',
		'origof;' => '⊶',
		'oror;' => '⩖',
		'orslope;' => '⩗',
		'orv;' => '⩛',
		'oS;' => 'Ⓢ',
		'Oscr;' => '𝒪',
		'oscr;' => 'ℴ',
		'Oslash;' => 'Ø',
		'Oslash' => 'Ø',
		'oslash;' => 'ø',
		'oslash' => 'ø',
		'osol;' => '⊘',
		'Otilde;' => 'Õ',
		'Otilde' => 'Õ',
		'otilde;' => 'õ',
		'otilde' => 'õ',
		'otimesas;' => '⨶',
		'Otimes;' => '⨷',
		'otimes;' => '⊗',
		'Ouml;' => 'Ö',
		'Ouml' => 'Ö',
		'ouml;' => 'ö',
		'ouml' => 'ö',
		'ovbar;' => '⌽',
		'OverBar;' => '‾',
		'OverBrace;' => '⏞',
		'OverBracket;' => '⎴',
		'OverParenthesis;' => '⏜',
		'para;' => '¶',
		'para' => '¶',
		'parallel;' => '∥',
		'par;' => '∥',
		'parsim;' => '⫳',
		'parsl;' => '⫽',
		'part;' => '∂',
		'PartialD;' => '∂',
		'Pcy;' => 'П',
		'pcy;' => 'п',
		'percnt;' => '%',
		'period;' => '.',
		'permil;' => '‰',
		'perp;' => '⊥',
		'pertenk;' => '‱',
		'Pfr;' => '𝔓',
		'pfr;' => '𝔭',
		'Phi;' => 'Φ',
		'phi;' => 'φ',
		'phiv;' => 'ϕ',
		'phmmat;' => 'ℳ',
		'phone;' => '☎',
		'Pi;' => 'Π',
		'pi;' => 'π',
		'pitchfork;' => '⋔',
		'piv;' => 'ϖ',
		'planck;' => 'ℏ',
		'planckh;' => 'ℎ',
		'plankv;' => 'ℏ',
		'plusacir;' => '⨣',
		'plusb;' => '⊞',
		'pluscir;' => '⨢',
		'plus;' => '+',
		'plusdo;' => '∔',
		'plusdu;' => '⨥',
		'pluse;' => '⩲',
		'PlusMinus;' => '±',
		'plusmn;' => '±',
		'plusmn' => '±',
		'plussim;' => '⨦',
		'plustwo;' => '⨧',
		'pm;' => '±',
		'Poincareplane;' => 'ℌ',
		'pointint;' => '⨕',
		'popf;' => '𝕡',
		'Popf;' => 'ℙ',
		'pound;' => '£',
		'pound' => '£',
		'prap;' => '⪷',
		'Pr;' => '⪻',
		'pr;' => '≺',
		'prcue;' => '≼',
		'precapprox;' => '⪷',
		'prec;' => '≺',
		'preccurlyeq;' => '≼',
		'Precedes;' => '≺',
		'PrecedesEqual;' => '⪯',
		'PrecedesSlantEqual;' => '≼',
		'PrecedesTilde;' => '≾',
		'preceq;' => '⪯',
		'precnapprox;' => '⪹',
		'precneqq;' => '⪵',
		'precnsim;' => '⋨',
		'pre;' => '⪯',
		'prE;' => '⪳',
		'precsim;' => '≾',
		'prime;' => '′',
		'Prime;' => '″',
		'primes;' => 'ℙ',
		'prnap;' => '⪹',
		'prnE;' => '⪵',
		'prnsim;' => '⋨',
		'prod;' => '∏',
		'Product;' => '∏',
		'profalar;' => '⌮',
		'profline;' => '⌒',
		'profsurf;' => '⌓',
		'prop;' => '∝',
		'Proportional;' => '∝',
		'Proportion;' => '∷',
		'propto;' => '∝',
		'prsim;' => '≾',
		'prurel;' => '⊰',
		'Pscr;' => '𝒫',
		'pscr;' => '𝓅',
		'Psi;' => 'Ψ',
		'psi;' => 'ψ',
		'puncsp;' => ' ',
		'Qfr;' => '𝔔',
		'qfr;' => '𝔮',
		'qint;' => '⨌',
		'qopf;' => '𝕢',
		'Qopf;' => 'ℚ',
		'qprime;' => '⁗',
		'Qscr;' => '𝒬',
		'qscr;' => '𝓆',
		'quaternions;' => 'ℍ',
		'quatint;' => '⨖',
		'quest;' => '?',
		'questeq;' => '≟',
		'quot;' => '"',
		'quot' => '"',
		'QUOT;' => '"',
		'QUOT' => '"',
		'rAarr;' => '⇛',
		'race;' => '∽̱',
		'Racute;' => 'Ŕ',
		'racute;' => 'ŕ',
		'radic;' => '√',
		'raemptyv;' => '⦳',
		'rang;' => '⟩',
		'Rang;' => '⟫',
		'rangd;' => '⦒',
		'range;' => '⦥',
		'rangle;' => '⟩',
		'raquo;' => '»',
		'raquo' => '»',
		'rarrap;' => '⥵',
		'rarrb;' => '⇥',
		'rarrbfs;' => '⤠',
		'rarrc;' => '⤳',
		'rarr;' => '→',
		'Rarr;' => '↠',
		'rArr;' => '⇒',
		'rarrfs;' => '⤞',
		'rarrhk;' => '↪',
		'rarrlp;' => '↬',
		'rarrpl;' => '⥅',
		'rarrsim;' => '⥴',
		'Rarrtl;' => '⤖',
		'rarrtl;' => '↣',
		'rarrw;' => '↝',
		'ratail;' => '⤚',
		'rAtail;' => '⤜',
		'ratio;' => '∶',
		'rationals;' => 'ℚ',
		'rbarr;' => '⤍',
		'rBarr;' => '⤏',
		'RBarr;' => '⤐',
		'rbbrk;' => '❳',
		'rbrace;' => '}',
		'rbrack;' => ']',
		'rbrke;' => '⦌',
		'rbrksld;' => '⦎',
		'rbrkslu;' => '⦐',
		'Rcaron;' => 'Ř',
		'rcaron;' => 'ř',
		'Rcedil;' => 'Ŗ',
		'rcedil;' => 'ŗ',
		'rceil;' => '⌉',
		'rcub;' => '}',
		'Rcy;' => 'Р',
		'rcy;' => 'р',
		'rdca;' => '⤷',
		'rdldhar;' => '⥩',
		'rdquo;' => '”',
		'rdquor;' => '”',
		'rdsh;' => '↳',
		'real;' => 'ℜ',
		'realine;' => 'ℛ',
		'realpart;' => 'ℜ',
		'reals;' => 'ℝ',
		'Re;' => 'ℜ',
		'rect;' => '▭',
		'reg;' => '®',
		'reg' => '®',
		'REG;' => '®',
		'REG' => '®',
		'ReverseElement;' => '∋',
		'ReverseEquilibrium;' => '⇋',
		'ReverseUpEquilibrium;' => '⥯',
		'rfisht;' => '⥽',
		'rfloor;' => '⌋',
		'rfr;' => '𝔯',
		'Rfr;' => 'ℜ',
		'rHar;' => '⥤',
		'rhard;' => '⇁',
		'rharu;' => '⇀',
		'rharul;' => '⥬',
		'Rho;' => 'Ρ',
		'rho;' => 'ρ',
		'rhov;' => 'ϱ',
		'RightAngleBracket;' => '⟩',
		'RightArrowBar;' => '⇥',
		'rightarrow;' => '→',
		'RightArrow;' => '→',
		'Rightarrow;' => '⇒',
		'RightArrowLeftArrow;' => '⇄',
		'rightarrowtail;' => '↣',
		'RightCeiling;' => '⌉',
		'RightDoubleBracket;' => '⟧',
		'RightDownTeeVector;' => '⥝',
		'RightDownVectorBar;' => '⥕',
		'RightDownVector;' => '⇂',
		'RightFloor;' => '⌋',
		'rightharpoondown;' => '⇁',
		'rightharpoonup;' => '⇀',
		'rightleftarrows;' => '⇄',
		'rightleftharpoons;' => '⇌',
		'rightrightarrows;' => '⇉',
		'rightsquigarrow;' => '↝',
		'RightTeeArrow;' => '↦',
		'RightTee;' => '⊢',
		'RightTeeVector;' => '⥛',
		'rightthreetimes;' => '⋌',
		'RightTriangleBar;' => '⧐',
		'RightTriangle;' => '⊳',
		'RightTriangleEqual;' => '⊵',
		'RightUpDownVector;' => '⥏',
		'RightUpTeeVector;' => '⥜',
		'RightUpVectorBar;' => '⥔',
		'RightUpVector;' => '↾',
		'RightVectorBar;' => '⥓',
		'RightVector;' => '⇀',
		'ring;' => '˚',
		'risingdotseq;' => '≓',
		'rlarr;' => '⇄',
		'rlhar;' => '⇌',
		'rlm;' => '‏',
		'rmoustache;' => '⎱',
		'rmoust;' => '⎱',
		'rnmid;' => '⫮',
		'roang;' => '⟭',
		'roarr;' => '⇾',
		'robrk;' => '⟧',
		'ropar;' => '⦆',
		'ropf;' => '𝕣',
		'Ropf;' => 'ℝ',
		'roplus;' => '⨮',
		'rotimes;' => '⨵',
		'RoundImplies;' => '⥰',
		'rpar;' => ')',
		'rpargt;' => '⦔',
		'rppolint;' => '⨒',
		'rrarr;' => '⇉',
		'Rrightarrow;' => '⇛',
		'rsaquo;' => '›',
		'rscr;' => '𝓇',
		'Rscr;' => 'ℛ',
		'rsh;' => '↱',
		'Rsh;' => '↱',
		'rsqb;' => ']',
		'rsquo;' => '’',
		'rsquor;' => '’',
		'rthree;' => '⋌',
		'rtimes;' => '⋊',
		'rtri;' => '▹',
		'rtrie;' => '⊵',
		'rtrif;' => '▸',
		'rtriltri;' => '⧎',
		'RuleDelayed;' => '⧴',
		'ruluhar;' => '⥨',
		'rx;' => '℞',
		'Sacute;' => 'Ś',
		'sacute;' => 'ś',
		'sbquo;' => '‚',
		'scap;' => '⪸',
		'Scaron;' => 'Š',
		'scaron;' => 'š',
		'Sc;' => '⪼',
		'sc;' => '≻',
		'sccue;' => '≽',
		'sce;' => '⪰',
		'scE;' => '⪴',
		'Scedil;' => 'Ş',
		'scedil;' => 'ş',
		'Scirc;' => 'Ŝ',
		'scirc;' => 'ŝ',
		'scnap;' => '⪺',
		'scnE;' => '⪶',
		'scnsim;' => '⋩',
		'scpolint;' => '⨓',
		'scsim;' => '≿',
		'Scy;' => 'С',
		'scy;' => 'с',
		'sdotb;' => '⊡',
		'sdot;' => '⋅',
		'sdote;' => '⩦',
		'searhk;' => '⤥',
		'searr;' => '↘',
		'seArr;' => '⇘',
		'searrow;' => '↘',
		'sect;' => '§',
		'sect' => '§',
		'semi;' => ';',
		'seswar;' => '⤩',
		'setminus;' => '∖',
		'setmn;' => '∖',
		'sext;' => '✶',
		'Sfr;' => '𝔖',
		'sfr;' => '𝔰',
		'sfrown;' => '⌢',
		'sharp;' => '♯',
		'SHCHcy;' => 'Щ',
		'shchcy;' => 'щ',
		'SHcy;' => 'Ш',
		'shcy;' => 'ш',
		'ShortDownArrow;' => '↓',
		'ShortLeftArrow;' => '←',
		'shortmid;' => '∣',
		'shortparallel;' => '∥',
		'ShortRightArrow;' => '→',
		'ShortUpArrow;' => '↑',
		'shy;' => '­',
		'shy' => '­',
		'Sigma;' => 'Σ',
		'sigma;' => 'σ',
		'sigmaf;' => 'ς',
		'sigmav;' => 'ς',
		'sim;' => '∼',
		'simdot;' => '⩪',
		'sime;' => '≃',
		'simeq;' => '≃',
		'simg;' => '⪞',
		'simgE;' => '⪠',
		'siml;' => '⪝',
		'simlE;' => '⪟',
		'simne;' => '≆',
		'simplus;' => '⨤',
		'simrarr;' => '⥲',
		'slarr;' => '←',
		'SmallCircle;' => '∘',
		'smallsetminus;' => '∖',
		'smashp;' => '⨳',
		'smeparsl;' => '⧤',
		'smid;' => '∣',
		'smile;' => '⌣',
		'smt;' => '⪪',
		'smte;' => '⪬',
		'smtes;' => '⪬︀',
		'SOFTcy;' => 'Ь',
		'softcy;' => 'ь',
		'solbar;' => '⌿',
		'solb;' => '⧄',
		'sol;' => '/',
		'Sopf;' => '𝕊',
		'sopf;' => '𝕤',
		'spades;' => '♠',
		'spadesuit;' => '♠',
		'spar;' => '∥',
		'sqcap;' => '⊓',
		'sqcaps;' => '⊓︀',
		'sqcup;' => '⊔',
		'sqcups;' => '⊔︀',
		'Sqrt;' => '√',
		'sqsub;' => '⊏',
		'sqsube;' => '⊑',
		'sqsubset;' => '⊏',
		'sqsubseteq;' => '⊑',
		'sqsup;' => '⊐',
		'sqsupe;' => '⊒',
		'sqsupset;' => '⊐',
		'sqsupseteq;' => '⊒',
		'square;' => '□',
		'Square;' => '□',
		'SquareIntersection;' => '⊓',
		'SquareSubset;' => '⊏',
		'SquareSubsetEqual;' => '⊑',
		'SquareSuperset;' => '⊐',
		'SquareSupersetEqual;' => '⊒',
		'SquareUnion;' => '⊔',
		'squarf;' => '▪',
		'squ;' => '□',
		'squf;' => '▪',
		'srarr;' => '→',
		'Sscr;' => '𝒮',
		'sscr;' => '𝓈',
		'ssetmn;' => '∖',
		'ssmile;' => '⌣',
		'sstarf;' => '⋆',
		'Star;' => '⋆',
		'star;' => '☆',
		'starf;' => '★',
		'straightepsilon;' => 'ϵ',
		'straightphi;' => 'ϕ',
		'strns;' => '¯',
		'sub;' => '⊂',
		'Sub;' => '⋐',
		'subdot;' => '⪽',
		'subE;' => '⫅',
		'sube;' => '⊆',
		'subedot;' => '⫃',
		'submult;' => '⫁',
		'subnE;' => '⫋',
		'subne;' => '⊊',
		'subplus;' => '⪿',
		'subrarr;' => '⥹',
		'subset;' => '⊂',
		'Subset;' => '⋐',
		'subseteq;' => '⊆',
		'subseteqq;' => '⫅',
		'SubsetEqual;' => '⊆',
		'subsetneq;' => '⊊',
		'subsetneqq;' => '⫋',
		'subsim;' => '⫇',
		'subsub;' => '⫕',
		'subsup;' => '⫓',
		'succapprox;' => '⪸',
		'succ;' => '≻',
		'succcurlyeq;' => '≽',
		'Succeeds;' => '≻',
		'SucceedsEqual;' => '⪰',
		'SucceedsSlantEqual;' => '≽',
		'SucceedsTilde;' => '≿',
		'succeq;' => '⪰',
		'succnapprox;' => '⪺',
		'succneqq;' => '⪶',
		'succnsim;' => '⋩',
		'succsim;' => '≿',
		'SuchThat;' => '∋',
		'sum;' => '∑',
		'Sum;' => '∑',
		'sung;' => '♪',
		'sup1;' => '¹',
		'sup1' => '¹',
		'sup2;' => '²',
		'sup2' => '²',
		'sup3;' => '³',
		'sup3' => '³',
		'sup;' => '⊃',
		'Sup;' => '⋑',
		'supdot;' => '⪾',
		'supdsub;' => '⫘',
		'supE;' => '⫆',
		'supe;' => '⊇',
		'supedot;' => '⫄',
		'Superset;' => '⊃',
		'SupersetEqual;' => '⊇',
		'suphsol;' => '⟉',
		'suphsub;' => '⫗',
		'suplarr;' => '⥻',
		'supmult;' => '⫂',
		'supnE;' => '⫌',
		'supne;' => '⊋',
		'supplus;' => '⫀',
		'supset;' => '⊃',
		'Supset;' => '⋑',
		'supseteq;' => '⊇',
		'supseteqq;' => '⫆',
		'supsetneq;' => '⊋',
		'supsetneqq;' => '⫌',
		'supsim;' => '⫈',
		'supsub;' => '⫔',
		'supsup;' => '⫖',
		'swarhk;' => '⤦',
		'swarr;' => '↙',
		'swArr;' => '⇙',
		'swarrow;' => '↙',
		'swnwar;' => '⤪',
		'szlig;' => 'ß',
		'szlig' => 'ß',
		'Tab;' => '	',
		'target;' => '⌖',
		'Tau;' => 'Τ',
		'tau;' => 'τ',
		'tbrk;' => '⎴',
		'Tcaron;' => 'Ť',
		'tcaron;' => 'ť',
		'Tcedil;' => 'Ţ',
		'tcedil;' => 'ţ',
		'Tcy;' => 'Т',
		'tcy;' => 'т',
		'tdot;' => '⃛',
		'telrec;' => '⌕',
		'Tfr;' => '𝔗',
		'tfr;' => '𝔱',
		'there4;' => '∴',
		'therefore;' => '∴',
		'Therefore;' => '∴',
		'Theta;' => 'Θ',
		'theta;' => 'θ',
		'thetasym;' => 'ϑ',
		'thetav;' => 'ϑ',
		'thickapprox;' => '≈',
		'thicksim;' => '∼',
		'ThickSpace;' => '  ',
		'ThinSpace;' => ' ',
		'thinsp;' => ' ',
		'thkap;' => '≈',
		'thksim;' => '∼',
		'THORN;' => 'Þ',
		'THORN' => 'Þ',
		'thorn;' => 'þ',
		'thorn' => 'þ',
		'tilde;' => '˜',
		'Tilde;' => '∼',
		'TildeEqual;' => '≃',
		'TildeFullEqual;' => '≅',
		'TildeTilde;' => '≈',
		'timesbar;' => '⨱',
		'timesb;' => '⊠',
		'times;' => '×',
		'times' => '×',
		'timesd;' => '⨰',
		'tint;' => '∭',
		'toea;' => '⤨',
		'topbot;' => '⌶',
		'topcir;' => '⫱',
		'top;' => '⊤',
		'Topf;' => '𝕋',
		'topf;' => '𝕥',
		'topfork;' => '⫚',
		'tosa;' => '⤩',
		'tprime;' => '‴',
		'trade;' => '™',
		'TRADE;' => '™',
		'triangle;' => '▵',
		'triangledown;' => '▿',
		'triangleleft;' => '◃',
		'trianglelefteq;' => '⊴',
		'triangleq;' => '≜',
		'triangleright;' => '▹',
		'trianglerighteq;' => '⊵',
		'tridot;' => '◬',
		'trie;' => '≜',
		'triminus;' => '⨺',
		'TripleDot;' => '⃛',
		'triplus;' => '⨹',
		'trisb;' => '⧍',
		'tritime;' => '⨻',
		'trpezium;' => '⏢',
		'Tscr;' => '𝒯',
		'tscr;' => '𝓉',
		'TScy;' => 'Ц',
		'tscy;' => 'ц',
		'TSHcy;' => 'Ћ',
		'tshcy;' => 'ћ',
		'Tstrok;' => 'Ŧ',
		'tstrok;' => 'ŧ',
		'twixt;' => '≬',
		'twoheadleftarrow;' => '↞',
		'twoheadrightarrow;' => '↠',
		'Uacute;' => 'Ú',
		'Uacute' => 'Ú',
		'uacute;' => 'ú',
		'uacute' => 'ú',
		'uarr;' => '↑',
		'Uarr;' => '↟',
		'uArr;' => '⇑',
		'Uarrocir;' => '⥉',
		'Ubrcy;' => 'Ў',
		'ubrcy;' => 'ў',
		'Ubreve;' => 'Ŭ',
		'ubreve;' => 'ŭ',
		'Ucirc;' => 'Û',
		'Ucirc' => 'Û',
		'ucirc;' => 'û',
		'ucirc' => 'û',
		'Ucy;' => 'У',
		'ucy;' => 'у',
		'udarr;' => '⇅',
		'Udblac;' => 'Ű',
		'udblac;' => 'ű',
		'udhar;' => '⥮',
		'ufisht;' => '⥾',
		'Ufr;' => '𝔘',
		'ufr;' => '𝔲',
		'Ugrave;' => 'Ù',
		'Ugrave' => 'Ù',
		'ugrave;' => 'ù',
		'ugrave' => 'ù',
		'uHar;' => '⥣',
		'uharl;' => '↿',
		'uharr;' => '↾',
		'uhblk;' => '▀',
		'ulcorn;' => '⌜',
		'ulcorner;' => '⌜',
		'ulcrop;' => '⌏',
		'ultri;' => '◸',
		'Umacr;' => 'Ū',
		'umacr;' => 'ū',
		'uml;' => '¨',
		'uml' => '¨',
		'UnderBar;' => '_',
		'UnderBrace;' => '⏟',
		'UnderBracket;' => '⎵',
		'UnderParenthesis;' => '⏝',
		'Union;' => '⋃',
		'UnionPlus;' => '⊎',
		'Uogon;' => 'Ų',
		'uogon;' => 'ų',
		'Uopf;' => '𝕌',
		'uopf;' => '𝕦',
		'UpArrowBar;' => '⤒',
		'uparrow;' => '↑',
		'UpArrow;' => '↑',
		'Uparrow;' => '⇑',
		'UpArrowDownArrow;' => '⇅',
		'updownarrow;' => '↕',
		'UpDownArrow;' => '↕',
		'Updownarrow;' => '⇕',
		'UpEquilibrium;' => '⥮',
		'upharpoonleft;' => '↿',
		'upharpoonright;' => '↾',
		'uplus;' => '⊎',
		'UpperLeftArrow;' => '↖',
		'UpperRightArrow;' => '↗',
		'upsi;' => 'υ',
		'Upsi;' => 'ϒ',
		'upsih;' => 'ϒ',
		'Upsilon;' => 'Υ',
		'upsilon;' => 'υ',
		'UpTeeArrow;' => '↥',
		'UpTee;' => '⊥',
		'upuparrows;' => '⇈',
		'urcorn;' => '⌝',
		'urcorner;' => '⌝',
		'urcrop;' => '⌎',
		'Uring;' => 'Ů',
		'uring;' => 'ů',
		'urtri;' => '◹',
		'Uscr;' => '𝒰',
		'uscr;' => '𝓊',
		'utdot;' => '⋰',
		'Utilde;' => 'Ũ',
		'utilde;' => 'ũ',
		'utri;' => '▵',
		'utrif;' => '▴',
		'uuarr;' => '⇈',
		'Uuml;' => 'Ü',
		'Uuml' => 'Ü',
		'uuml;' => 'ü',
		'uuml' => 'ü',
		'uwangle;' => '⦧',
		'vangrt;' => '⦜',
		'varepsilon;' => 'ϵ',
		'varkappa;' => 'ϰ',
		'varnothing;' => '∅',
		'varphi;' => 'ϕ',
		'varpi;' => 'ϖ',
		'varpropto;' => '∝',
		'varr;' => '↕',
		'vArr;' => '⇕',
		'varrho;' => 'ϱ',
		'varsigma;' => 'ς',
		'varsubsetneq;' => '⊊︀',
		'varsubsetneqq;' => '⫋︀',
		'varsupsetneq;' => '⊋︀',
		'varsupsetneqq;' => '⫌︀',
		'vartheta;' => 'ϑ',
		'vartriangleleft;' => '⊲',
		'vartriangleright;' => '⊳',
		'vBar;' => '⫨',
		'Vbar;' => '⫫',
		'vBarv;' => '⫩',
		'Vcy;' => 'В',
		'vcy;' => 'в',
		'vdash;' => '⊢',
		'vDash;' => '⊨',
		'Vdash;' => '⊩',
		'VDash;' => '⊫',
		'Vdashl;' => '⫦',
		'veebar;' => '⊻',
		'vee;' => '∨',
		'Vee;' => '⋁',
		'veeeq;' => '≚',
		'vellip;' => '⋮',
		'verbar;' => '|',
		'Verbar;' => '‖',
		'vert;' => '|',
		'Vert;' => '‖',
		'VerticalBar;' => '∣',
		'VerticalLine;' => '|',
		'VerticalSeparator;' => '❘',
		'VerticalTilde;' => '≀',
		'VeryThinSpace;' => ' ',
		'Vfr;' => '𝔙',
		'vfr;' => '𝔳',
		'vltri;' => '⊲',
		'vnsub;' => '⊂⃒',
		'vnsup;' => '⊃⃒',
		'Vopf;' => '𝕍',
		'vopf;' => '𝕧',
		'vprop;' => '∝',
		'vrtri;' => '⊳',
		'Vscr;' => '𝒱',
		'vscr;' => '𝓋',
		'vsubnE;' => '⫋︀',
		'vsubne;' => '⊊︀',
		'vsupnE;' => '⫌︀',
		'vsupne;' => '⊋︀',
		'Vvdash;' => '⊪',
		'vzigzag;' => '⦚',
		'Wcirc;' => 'Ŵ',
		'wcirc;' => 'ŵ',
		'wedbar;' => '⩟',
		'wedge;' => '∧',
		'Wedge;' => '⋀',
		'wedgeq;' => '≙',
		'weierp;' => '℘',
		'Wfr;' => '𝔚',
		'wfr;' => '𝔴',
		'Wopf;' => '𝕎',
		'wopf;' => '𝕨',
		'wp;' => '℘',
		'wr;' => '≀',
		'wreath;' => '≀',
		'Wscr;' => '𝒲',
		'wscr;' => '𝓌',
		'xcap;' => '⋂',
		'xcirc;' => '◯',
		'xcup;' => '⋃',
		'xdtri;' => '▽',
		'Xfr;' => '𝔛',
		'xfr;' => '𝔵',
		'xharr;' => '⟷',
		'xhArr;' => '⟺',
		'Xi;' => 'Ξ',
		'xi;' => 'ξ',
		'xlarr;' => '⟵',
		'xlArr;' => '⟸',
		'xmap;' => '⟼',
		'xnis;' => '⋻',
		'xodot;' => '⨀',
		'Xopf;' => '𝕏',
		'xopf;' => '𝕩',
		'xoplus;' => '⨁',
		'xotime;' => '⨂',
		'xrarr;' => '⟶',
		'xrArr;' => '⟹',
		'Xscr;' => '𝒳',
		'xscr;' => '𝓍',
		'xsqcup;' => '⨆',
		'xuplus;' => '⨄',
		'xutri;' => '△',
		'xvee;' => '⋁',
		'xwedge;' => '⋀',
		'Yacute;' => 'Ý',
		'Yacute' => 'Ý',
		'yacute;' => 'ý',
		'yacute' => 'ý',
		'YAcy;' => 'Я',
		'yacy;' => 'я',
		'Ycirc;' => 'Ŷ',
		'ycirc;' => 'ŷ',
		'Ycy;' => 'Ы',
		'ycy;' => 'ы',
		'yen;' => '¥',
		'yen' => '¥',
		'Yfr;' => '𝔜',
		'yfr;' => '𝔶',
		'YIcy;' => 'Ї',
		'yicy;' => 'ї',
		'Yopf;' => '𝕐',
		'yopf;' => '𝕪',
		'Yscr;' => '𝒴',
		'yscr;' => '𝓎',
		'YUcy;' => 'Ю',
		'yucy;' => 'ю',
		'yuml;' => 'ÿ',
		'yuml' => 'ÿ',
		'Yuml;' => 'Ÿ',
		'Zacute;' => 'Ź',
		'zacute;' => 'ź',
		'Zcaron;' => 'Ž',
		'zcaron;' => 'ž',
		'Zcy;' => 'З',
		'zcy;' => 'з',
		'Zdot;' => 'Ż',
		'zdot;' => 'ż',
		'zeetrf;' => 'ℨ',
		'ZeroWidthSpace;' => '​',
		'Zeta;' => 'Ζ',
		'zeta;' => 'ζ',
		'zfr;' => '𝔷',
		'Zfr;' => 'ℨ',
		'ZHcy;' => 'Ж',
		'zhcy;' => 'ж',
		'zigrarr;' => '⇝',
		'zopf;' => '𝕫',
		'Zopf;' => 'ℤ',
		'Zscr;' => '𝒵',
		'zscr;' => '𝓏',
		'zwj;' => '‍',
		'zwnj;' => '‌',
	];

	public const LEGACY_NUMERIC_ENTITIES = [
		0 => '�',
		128 => '€',
		130 => '‚',
		131 => 'ƒ',
		132 => '„',
		133 => '…',
		134 => '†',
		135 => '‡',
		136 => 'ˆ',
		137 => '‰',
		138 => 'Š',
		139 => '‹',
		140 => 'Œ',
		142 => 'Ž',
		145 => '‘',
		146 => '’',
		147 => '“',
		148 => '”',
		149 => '•',
		150 => '–',
		151 => '—',
		152 => '˜',
		153 => '™',
		154 => 'š',
		155 => '›',
		156 => 'œ',
		158 => 'ž',
		159 => 'Ÿ',
	];

	public const QUIRKY_PREFIX_REGEX = '~
		//Silmaril//dtd html Pro v0r11 19970101//|
		//AS//DTD HTML 3\\.0 asWedit \\+ extensions//|
		//AdvaSoft Ltd//DTD HTML 3\\.0 asWedit \\+ extensions//|
		//IETF//DTD HTML 2\\.0 Level 1//|
		//IETF//DTD HTML 2\\.0 Level 2//|
		//IETF//DTD HTML 2\\.0 Strict Level 1//|
		//IETF//DTD HTML 2\\.0 Strict Level 2//|
		//IETF//DTD HTML 2\\.0 Strict//|
		//IETF//DTD HTML 2\\.0//|
		//IETF//DTD HTML 2\\.1E//|
		//IETF//DTD HTML 3\\.0//|
		//IETF//DTD HTML 3\\.2 Final//|
		//IETF//DTD HTML 3\\.2//|
		//IETF//DTD HTML 3//|
		//IETF//DTD HTML Level 0//|
		//IETF//DTD HTML Level 1//|
		//IETF//DTD HTML Level 2//|
		//IETF//DTD HTML Level 3//|
		//IETF//DTD HTML Strict Level 0//|
		//IETF//DTD HTML Strict Level 1//|
		//IETF//DTD HTML Strict Level 2//|
		//IETF//DTD HTML Strict Level 3//|
		//IETF//DTD HTML Strict//|
		//IETF//DTD HTML//|
		//Metrius//DTD Metrius Presentational//|
		//Microsoft//DTD Internet Explorer 2\\.0 HTML Strict//|
		//Microsoft//DTD Internet Explorer 2\\.0 HTML//|
		//Microsoft//DTD Internet Explorer 2\\.0 Tables//|
		//Microsoft//DTD Internet Explorer 3\\.0 HTML Strict//|
		//Microsoft//DTD Internet Explorer 3\\.0 HTML//|
		//Microsoft//DTD Internet Explorer 3\\.0 Tables//|
		//Netscape Comm\\. Corp\\.//DTD HTML//|
		//Netscape Comm\\. Corp\\.//DTD Strict HTML//|
		//O\'Reilly and Associates//DTD HTML 2\\.0//|
		//O\'Reilly and Associates//DTD HTML Extended 1\\.0//|
		//O\'Reilly and Associates//DTD HTML Extended Relaxed 1\\.0//|
		//SoftQuad Software//DTD HoTMetaL PRO 6\\.0\\:\\:19990601\\:\\:extensions to HTML 4\\.0//|
		//SoftQuad//DTD HoTMetaL PRO 4\\.0\\:\\:19971010\\:\\:extensions to HTML 4\\.0//|
		//Spyglass//DTD HTML 2\\.0 Extended//|
		//SQ//DTD HTML 2\\.0 HoTMetaL \\+ extensions//|
		//Sun Microsystems Corp\\.//DTD HotJava HTML//|
		//Sun Microsystems Corp\\.//DTD HotJava Strict HTML//|
		//W3C//DTD HTML 3 1995\\-03\\-24//|
		//W3C//DTD HTML 3\\.2 Draft//|
		//W3C//DTD HTML 3\\.2 Final//|
		//W3C//DTD HTML 3\\.2//|
		//W3C//DTD HTML 3\\.2S Draft//|
		//W3C//DTD HTML 4\\.0 Frameset//|
		//W3C//DTD HTML 4\\.0 Transitional//|
		//W3C//DTD HTML Experimental 19960712//|
		//W3C//DTD HTML Experimental 970421//|
		//W3C//DTD W3 HTML//|
		//W3O//DTD W3 HTML 3\\.0//|
		//WebTechs//DTD Mozilla HTML 2\\.0//|
		//WebTechs//DTD Mozilla HTML//~xAi';

	public const NAME_START_CHAR_CONV_TABLE = [
		0, 64, 0, 16777215,
		91, 94, 0, 16777215,
		96, 96, 0, 16777215,
		123, 191, 0, 16777215,
		215, 215, 0, 16777215,
		247, 247, 0, 16777215,
		306, 307, 0, 16777215,
		319, 320, 0, 16777215,
		329, 329, 0, 16777215,
		383, 383, 0, 16777215,
		452, 460, 0, 16777215,
		497, 499, 0, 16777215,
		502, 505, 0, 16777215,
		536, 591, 0, 16777215,
		681, 698, 0, 16777215,
		706, 901, 0, 16777215,
		903, 903, 0, 16777215,
		907, 907, 0, 16777215,
		909, 909, 0, 16777215,
		930, 930, 0, 16777215,
		975, 975, 0, 16777215,
		983, 985, 0, 16777215,
		987, 987, 0, 16777215,
		989, 989, 0, 16777215,
		991, 991, 0, 16777215,
		993, 993, 0, 16777215,
		1012, 1024, 0, 16777215,
		1037, 1037, 0, 16777215,
		1104, 1104, 0, 16777215,
		1117, 1117, 0, 16777215,
		1154, 1167, 0, 16777215,
		1221, 1222, 0, 16777215,
		1225, 1226, 0, 16777215,
		1229, 1231, 0, 16777215,
		1260, 1261, 0, 16777215,
		1270, 1271, 0, 16777215,
		1274, 1328, 0, 16777215,
		1367, 1368, 0, 16777215,
		1370, 1376, 0, 16777215,
		1415, 1487, 0, 16777215,
		1515, 1519, 0, 16777215,
		1523, 1568, 0, 16777215,
		1595, 1600, 0, 16777215,
		1611, 1648, 0, 16777215,
		1720, 1721, 0, 16777215,
		1727, 1727, 0, 16777215,
		1743, 1743, 0, 16777215,
		1748, 1748, 0, 16777215,
		1750, 1764, 0, 16777215,
		1767, 2308, 0, 16777215,
		2362, 2364, 0, 16777215,
		2366, 2391, 0, 16777215,
		2402, 2436, 0, 16777215,
		2445, 2446, 0, 16777215,
		2449, 2450, 0, 16777215,
		2473, 2473, 0, 16777215,
		2481, 2481, 0, 16777215,
		2483, 2485, 0, 16777215,
		2490, 2523, 0, 16777215,
		2526, 2526, 0, 16777215,
		2530, 2543, 0, 16777215,
		2546, 2564, 0, 16777215,
		2571, 2574, 0, 16777215,
		2577, 2578, 0, 16777215,
		2601, 2601, 0, 16777215,
		2609, 2609, 0, 16777215,
		2612, 2612, 0, 16777215,
		2615, 2615, 0, 16777215,
		2618, 2648, 0, 16777215,
		2653, 2653, 0, 16777215,
		2655, 2673, 0, 16777215,
		2677, 2692, 0, 16777215,
		2700, 2700, 0, 16777215,
		2702, 2702, 0, 16777215,
		2706, 2706, 0, 16777215,
		2729, 2729, 0, 16777215,
		2737, 2737, 0, 16777215,
		2740, 2740, 0, 16777215,
		2746, 2748, 0, 16777215,
		2750, 2783, 0, 16777215,
		2785, 2820, 0, 16777215,
		2829, 2830, 0, 16777215,
		2833, 2834, 0, 16777215,
		2857, 2857, 0, 16777215,
		2865, 2865, 0, 16777215,
		2868, 2869, 0, 16777215,
		2874, 2876, 0, 16777215,
		2878, 2907, 0, 16777215,
		2910, 2910, 0, 16777215,
		2914, 2948, 0, 16777215,
		2955, 2957, 0, 16777215,
		2961, 2961, 0, 16777215,
		2966, 2968, 0, 16777215,
		2971, 2971, 0, 16777215,
		2973, 2973, 0, 16777215,
		2976, 2978, 0, 16777215,
		2981, 2983, 0, 16777215,
		2987, 2989, 0, 16777215,
		2998, 2998, 0, 16777215,
		3002, 3076, 0, 16777215,
		3085, 3085, 0, 16777215,
		3089, 3089, 0, 16777215,
		3113, 3113, 0, 16777215,
		3124, 3124, 0, 16777215,
		3130, 3167, 0, 16777215,
		3170, 3204, 0, 16777215,
		3213, 3213, 0, 16777215,
		3217, 3217, 0, 16777215,
		3241, 3241, 0, 16777215,
		3252, 3252, 0, 16777215,
		3258, 3293, 0, 16777215,
		3295, 3295, 0, 16777215,
		3298, 3332, 0, 16777215,
		3341, 3341, 0, 16777215,
		3345, 3345, 0, 16777215,
		3369, 3369, 0, 16777215,
		3386, 3423, 0, 16777215,
		3426, 3584, 0, 16777215,
		3631, 3631, 0, 16777215,
		3633, 3633, 0, 16777215,
		3636, 3647, 0, 16777215,
		3654, 3712, 0, 16777215,
		3715, 3715, 0, 16777215,
		3717, 3718, 0, 16777215,
		3721, 3721, 0, 16777215,
		3723, 3724, 0, 16777215,
		3726, 3731, 0, 16777215,
		3736, 3736, 0, 16777215,
		3744, 3744, 0, 16777215,
		3748, 3748, 0, 16777215,
		3750, 3750, 0, 16777215,
		3752, 3753, 0, 16777215,
		3756, 3756, 0, 16777215,
		3759, 3759, 0, 16777215,
		3761, 3761, 0, 16777215,
		3764, 3772, 0, 16777215,
		3774, 3775, 0, 16777215,
		3781, 3903, 0, 16777215,
		3912, 3912, 0, 16777215,
		3946, 4255, 0, 16777215,
		4294, 4303, 0, 16777215,
		4343, 4351, 0, 16777215,
		4353, 4353, 0, 16777215,
		4356, 4356, 0, 16777215,
		4360, 4360, 0, 16777215,
		4362, 4362, 0, 16777215,
		4365, 4365, 0, 16777215,
		4371, 4411, 0, 16777215,
		4413, 4413, 0, 16777215,
		4415, 4415, 0, 16777215,
		4417, 4427, 0, 16777215,
		4429, 4429, 0, 16777215,
		4431, 4431, 0, 16777215,
		4433, 4435, 0, 16777215,
		4438, 4440, 0, 16777215,
		4442, 4446, 0, 16777215,
		4450, 4450, 0, 16777215,
		4452, 4452, 0, 16777215,
		4454, 4454, 0, 16777215,
		4456, 4456, 0, 16777215,
		4458, 4460, 0, 16777215,
		4463, 4465, 0, 16777215,
		4468, 4468, 0, 16777215,
		4470, 4509, 0, 16777215,
		4511, 4519, 0, 16777215,
		4521, 4522, 0, 16777215,
		4524, 4525, 0, 16777215,
		4528, 4534, 0, 16777215,
		4537, 4537, 0, 16777215,
		4539, 4539, 0, 16777215,
		4547, 4586, 0, 16777215,
		4588, 4591, 0, 16777215,
		4593, 4600, 0, 16777215,
		4602, 7679, 0, 16777215,
		7836, 7839, 0, 16777215,
		7930, 7935, 0, 16777215,
		7958, 7959, 0, 16777215,
		7966, 7967, 0, 16777215,
		8006, 8007, 0, 16777215,
		8014, 8015, 0, 16777215,
		8024, 8024, 0, 16777215,
		8026, 8026, 0, 16777215,
		8028, 8028, 0, 16777215,
		8030, 8030, 0, 16777215,
		8062, 8063, 0, 16777215,
		8117, 8117, 0, 16777215,
		8125, 8125, 0, 16777215,
		8127, 8129, 0, 16777215,
		8133, 8133, 0, 16777215,
		8141, 8143, 0, 16777215,
		8148, 8149, 0, 16777215,
		8156, 8159, 0, 16777215,
		8173, 8177, 0, 16777215,
		8181, 8181, 0, 16777215,
		8189, 8485, 0, 16777215,
		8487, 8489, 0, 16777215,
		8492, 8493, 0, 16777215,
		8495, 8575, 0, 16777215,
		8579, 12294, 0, 16777215,
		12296, 12320, 0, 16777215,
		12330, 12352, 0, 16777215,
		12437, 12448, 0, 16777215,
		12539, 12548, 0, 16777215,
		12589, 19967, 0, 16777215,
		40870, 44031, 0, 16777215,
		55204, 1114111, 0, 16777215 ];

	public const NAME_CHAR_CONV_TABLE = [
		0, 44, 0, 16777215,
		47, 47, 0, 16777215,
		58, 64, 0, 16777215,
		91, 94, 0, 16777215,
		96, 96, 0, 16777215,
		123, 182, 0, 16777215,
		184, 191, 0, 16777215,
		215, 215, 0, 16777215,
		247, 247, 0, 16777215,
		306, 307, 0, 16777215,
		319, 320, 0, 16777215,
		329, 329, 0, 16777215,
		383, 383, 0, 16777215,
		452, 460, 0, 16777215,
		497, 499, 0, 16777215,
		502, 505, 0, 16777215,
		536, 591, 0, 16777215,
		681, 698, 0, 16777215,
		706, 719, 0, 16777215,
		722, 767, 0, 16777215,
		838, 863, 0, 16777215,
		866, 901, 0, 16777215,
		907, 907, 0, 16777215,
		909, 909, 0, 16777215,
		930, 930, 0, 16777215,
		975, 975, 0, 16777215,
		983, 985, 0, 16777215,
		987, 987, 0, 16777215,
		989, 989, 0, 16777215,
		991, 991, 0, 16777215,
		993, 993, 0, 16777215,
		1012, 1024, 0, 16777215,
		1037, 1037, 0, 16777215,
		1104, 1104, 0, 16777215,
		1117, 1117, 0, 16777215,
		1154, 1154, 0, 16777215,
		1159, 1167, 0, 16777215,
		1221, 1222, 0, 16777215,
		1225, 1226, 0, 16777215,
		1229, 1231, 0, 16777215,
		1260, 1261, 0, 16777215,
		1270, 1271, 0, 16777215,
		1274, 1328, 0, 16777215,
		1367, 1368, 0, 16777215,
		1370, 1376, 0, 16777215,
		1415, 1424, 0, 16777215,
		1442, 1442, 0, 16777215,
		1466, 1466, 0, 16777215,
		1470, 1470, 0, 16777215,
		1472, 1472, 0, 16777215,
		1475, 1475, 0, 16777215,
		1477, 1487, 0, 16777215,
		1515, 1519, 0, 16777215,
		1523, 1568, 0, 16777215,
		1595, 1599, 0, 16777215,
		1619, 1631, 0, 16777215,
		1642, 1647, 0, 16777215,
		1720, 1721, 0, 16777215,
		1727, 1727, 0, 16777215,
		1743, 1743, 0, 16777215,
		1748, 1748, 0, 16777215,
		1769, 1769, 0, 16777215,
		1774, 1775, 0, 16777215,
		1786, 2304, 0, 16777215,
		2308, 2308, 0, 16777215,
		2362, 2363, 0, 16777215,
		2382, 2384, 0, 16777215,
		2389, 2391, 0, 16777215,
		2404, 2405, 0, 16777215,
		2416, 2432, 0, 16777215,
		2436, 2436, 0, 16777215,
		2445, 2446, 0, 16777215,
		2449, 2450, 0, 16777215,
		2473, 2473, 0, 16777215,
		2481, 2481, 0, 16777215,
		2483, 2485, 0, 16777215,
		2490, 2491, 0, 16777215,
		2493, 2493, 0, 16777215,
		2501, 2502, 0, 16777215,
		2505, 2506, 0, 16777215,
		2510, 2518, 0, 16777215,
		2520, 2523, 0, 16777215,
		2526, 2526, 0, 16777215,
		2532, 2533, 0, 16777215,
		2546, 2561, 0, 16777215,
		2563, 2564, 0, 16777215,
		2571, 2574, 0, 16777215,
		2577, 2578, 0, 16777215,
		2601, 2601, 0, 16777215,
		2609, 2609, 0, 16777215,
		2612, 2612, 0, 16777215,
		2615, 2615, 0, 16777215,
		2618, 2619, 0, 16777215,
		2621, 2621, 0, 16777215,
		2627, 2630, 0, 16777215,
		2633, 2634, 0, 16777215,
		2638, 2648, 0, 16777215,
		2653, 2653, 0, 16777215,
		2655, 2661, 0, 16777215,
		2677, 2688, 0, 16777215,
		2692, 2692, 0, 16777215,
		2700, 2700, 0, 16777215,
		2702, 2702, 0, 16777215,
		2706, 2706, 0, 16777215,
		2729, 2729, 0, 16777215,
		2737, 2737, 0, 16777215,
		2740, 2740, 0, 16777215,
		2746, 2747, 0, 16777215,
		2758, 2758, 0, 16777215,
		2762, 2762, 0, 16777215,
		2766, 2783, 0, 16777215,
		2785, 2789, 0, 16777215,
		2800, 2816, 0, 16777215,
		2820, 2820, 0, 16777215,
		2829, 2830, 0, 16777215,
		2833, 2834, 0, 16777215,
		2857, 2857, 0, 16777215,
		2865, 2865, 0, 16777215,
		2868, 2869, 0, 16777215,
		2874, 2875, 0, 16777215,
		2884, 2886, 0, 16777215,
		2889, 2890, 0, 16777215,
		2894, 2901, 0, 16777215,
		2904, 2907, 0, 16777215,
		2910, 2910, 0, 16777215,
		2914, 2917, 0, 16777215,
		2928, 2945, 0, 16777215,
		2948, 2948, 0, 16777215,
		2955, 2957, 0, 16777215,
		2961, 2961, 0, 16777215,
		2966, 2968, 0, 16777215,
		2971, 2971, 0, 16777215,
		2973, 2973, 0, 16777215,
		2976, 2978, 0, 16777215,
		2981, 2983, 0, 16777215,
		2987, 2989, 0, 16777215,
		2998, 2998, 0, 16777215,
		3002, 3005, 0, 16777215,
		3011, 3013, 0, 16777215,
		3017, 3017, 0, 16777215,
		3022, 3030, 0, 16777215,
		3032, 3046, 0, 16777215,
		3056, 3072, 0, 16777215,
		3076, 3076, 0, 16777215,
		3085, 3085, 0, 16777215,
		3089, 3089, 0, 16777215,
		3113, 3113, 0, 16777215,
		3124, 3124, 0, 16777215,
		3130, 3133, 0, 16777215,
		3141, 3141, 0, 16777215,
		3145, 3145, 0, 16777215,
		3150, 3156, 0, 16777215,
		3159, 3167, 0, 16777215,
		3170, 3173, 0, 16777215,
		3184, 3201, 0, 16777215,
		3204, 3204, 0, 16777215,
		3213, 3213, 0, 16777215,
		3217, 3217, 0, 16777215,
		3241, 3241, 0, 16777215,
		3252, 3252, 0, 16777215,
		3258, 3261, 0, 16777215,
		3269, 3269, 0, 16777215,
		3273, 3273, 0, 16777215,
		3278, 3284, 0, 16777215,
		3287, 3293, 0, 16777215,
		3295, 3295, 0, 16777215,
		3298, 3301, 0, 16777215,
		3312, 3329, 0, 16777215,
		3332, 3332, 0, 16777215,
		3341, 3341, 0, 16777215,
		3345, 3345, 0, 16777215,
		3369, 3369, 0, 16777215,
		3386, 3389, 0, 16777215,
		3396, 3397, 0, 16777215,
		3401, 3401, 0, 16777215,
		3406, 3414, 0, 16777215,
		3416, 3423, 0, 16777215,
		3426, 3429, 0, 16777215,
		3440, 3584, 0, 16777215,
		3631, 3631, 0, 16777215,
		3643, 3647, 0, 16777215,
		3663, 3663, 0, 16777215,
		3674, 3712, 0, 16777215,
		3715, 3715, 0, 16777215,
		3717, 3718, 0, 16777215,
		3721, 3721, 0, 16777215,
		3723, 3724, 0, 16777215,
		3726, 3731, 0, 16777215,
		3736, 3736, 0, 16777215,
		3744, 3744, 0, 16777215,
		3748, 3748, 0, 16777215,
		3750, 3750, 0, 16777215,
		3752, 3753, 0, 16777215,
		3756, 3756, 0, 16777215,
		3759, 3759, 0, 16777215,
		3770, 3770, 0, 16777215,
		3774, 3775, 0, 16777215,
		3781, 3781, 0, 16777215,
		3783, 3783, 0, 16777215,
		3790, 3791, 0, 16777215,
		3802, 3863, 0, 16777215,
		3866, 3871, 0, 16777215,
		3882, 3892, 0, 16777215,
		3894, 3894, 0, 16777215,
		3896, 3896, 0, 16777215,
		3898, 3901, 0, 16777215,
		3912, 3912, 0, 16777215,
		3946, 3952, 0, 16777215,
		3973, 3973, 0, 16777215,
		3980, 3983, 0, 16777215,
		3990, 3990, 0, 16777215,
		3992, 3992, 0, 16777215,
		4014, 4016, 0, 16777215,
		4024, 4024, 0, 16777215,
		4026, 4255, 0, 16777215,
		4294, 4303, 0, 16777215,
		4343, 4351, 0, 16777215,
		4353, 4353, 0, 16777215,
		4356, 4356, 0, 16777215,
		4360, 4360, 0, 16777215,
		4362, 4362, 0, 16777215,
		4365, 4365, 0, 16777215,
		4371, 4411, 0, 16777215,
		4413, 4413, 0, 16777215,
		4415, 4415, 0, 16777215,
		4417, 4427, 0, 16777215,
		4429, 4429, 0, 16777215,
		4431, 4431, 0, 16777215,
		4433, 4435, 0, 16777215,
		4438, 4440, 0, 16777215,
		4442, 4446, 0, 16777215,
		4450, 4450, 0, 16777215,
		4452, 4452, 0, 16777215,
		4454, 4454, 0, 16777215,
		4456, 4456, 0, 16777215,
		4458, 4460, 0, 16777215,
		4463, 4465, 0, 16777215,
		4468, 4468, 0, 16777215,
		4470, 4509, 0, 16777215,
		4511, 4519, 0, 16777215,
		4521, 4522, 0, 16777215,
		4524, 4525, 0, 16777215,
		4528, 4534, 0, 16777215,
		4537, 4537, 0, 16777215,
		4539, 4539, 0, 16777215,
		4547, 4586, 0, 16777215,
		4588, 4591, 0, 16777215,
		4593, 4600, 0, 16777215,
		4602, 7679, 0, 16777215,
		7836, 7839, 0, 16777215,
		7930, 7935, 0, 16777215,
		7958, 7959, 0, 16777215,
		7966, 7967, 0, 16777215,
		8006, 8007, 0, 16777215,
		8014, 8015, 0, 16777215,
		8024, 8024, 0, 16777215,
		8026, 8026, 0, 16777215,
		8028, 8028, 0, 16777215,
		8030, 8030, 0, 16777215,
		8062, 8063, 0, 16777215,
		8117, 8117, 0, 16777215,
		8125, 8125, 0, 16777215,
		8127, 8129, 0, 16777215,
		8133, 8133, 0, 16777215,
		8141, 8143, 0, 16777215,
		8148, 8149, 0, 16777215,
		8156, 8159, 0, 16777215,
		8173, 8177, 0, 16777215,
		8181, 8181, 0, 16777215,
		8189, 8399, 0, 16777215,
		8413, 8416, 0, 16777215,
		8418, 8485, 0, 16777215,
		8487, 8489, 0, 16777215,
		8492, 8493, 0, 16777215,
		8495, 8575, 0, 16777215,
		8579, 12292, 0, 16777215,
		12294, 12294, 0, 16777215,
		12296, 12320, 0, 16777215,
		12336, 12336, 0, 16777215,
		12342, 12352, 0, 16777215,
		12437, 12440, 0, 16777215,
		12443, 12444, 0, 16777215,
		12447, 12448, 0, 16777215,
		12539, 12539, 0, 16777215,
		12543, 12548, 0, 16777215,
		12589, 19967, 0, 16777215,
		40870, 44031, 0, 16777215,
		55204, 1114111, 0, 16777215 ];
}
