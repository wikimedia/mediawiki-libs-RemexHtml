<?php
# Stub out PHP8.4's Dom\Document so that references to it don't trigger
# phan errors on earlier PHP releases.
namespace Dom;

// phpcs:disable MediaWiki.Files.ClassMatchesFilename.NotMatch
// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound

class Document {
}

class DocumentType {
}

class HTMLDocument {
	/** @var DocumentType */
	public $doctype;

	public static function createEmpty( string $encoding = "UTF-8" ): self {
		return new self;
	}

	public static function createFromString(
		string $source, int $options = 0, ?string $overrideEncoding = null
	): self {
		return new self;
	}
}
