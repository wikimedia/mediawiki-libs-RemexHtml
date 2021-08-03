<?php

namespace Wikimedia\RemexHtml\Tools;

/**
 * Update the CHANGELOG file just before/after a release.
 * Run this with `composer update-changelog`.
 */
class UpdateChangeLog {
	public static function main() {
		$changeLogPath = __DIR__ . '/../CHANGELOG.md';
		$changeLog = file_get_contents( $changeLogPath );
		$changeLog = preg_replace_callback(
			'/^(#+) (\S+) (x\.x\.x|\d+\.\d+\.\d+)(.*)$/m',
			static function ( $matches ) use ( $changeLog ) {
				$line = $matches[1] . ' ' . $matches[2];
				if ( $matches[3] === 'x.x.x' ) {
					// Find the previous version
					if ( preg_match(
						'/^#+ ' . preg_quote( $matches[2], '/' ) .
						' (\d+)\.(\d+)\.(\d+)/m', $changeLog, $m2
					) === false ) {
						throw new \Exception( "Last version not found!" );
					}
					// Do a release!
					list( $ignore,$major,$minor,$patch ) = $m2;
					// We're only bumping patch levels for now.
					// FIXME add a command-line option to select whether
					// to bump major, minor, or patch.
					$nextVersion = "$major.$minor." . ( intval( $patch ) + 1 );
					$date = date( 'Y-m-d' );
					return "$line $nextVersion ($date)";
				} else {
					// Bump after a release
					return "$line x.x.x (not yet released)\n\n" . $matches[0];
				}
			},
			$changeLog, 1, $count );
		if ( $count != 1 ) {
			throw new \Exception( "Changelog entry not found!" );
		}
		file_put_contents( $changeLogPath, $changeLog );
	}
}
