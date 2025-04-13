<?php

namespace Wikimedia\RemexHtml\Tools\FuzzTest;

use InvalidArgumentException;

/**
 * A simple client for an Html5Depurate web service
 * https://www.mediawiki.org/wiki/Html5Depurate
 */
class Html5Depurate {
	/** @var CurlHandle|false */
	private $curl;

	public function __construct( ?string $url ) {
		$this->curl = curl_init( $url );
		curl_setopt_array( $this->curl, [
			CURLOPT_FAILONERROR => true,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
		] );
	}

	public function tidy( string $text ): string {
		if ( isset( $text[0] ) && $text[0] === '@' ) {
			$text = ' ' . $text;
		}
		curl_setopt( $this->curl, CURLOPT_POSTFIELDS, [ 'text' => $text ] );
		$result = curl_exec( $this->curl );
		if ( $result === false ) {
			$error = curl_error( $this->curl );
			if ( $error === '' ) {
				$code = curl_getinfo( $this->curl, CURLINFO_HTTP_CODE );
				$error = "Html5Depurate returned code $code";
			}
			throw new InvalidArgumentException( $error );
		}

		return $result;
	}
}
