<?php

/**
 * Standalone setup for the Ask library for when it's not used in conjunction with MediaWiki.
 * The library should be included via the main entry point, Ask.php.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:Ask
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Ask
 * Source code:				https://gerrit.wikimedia.org/r/gitweb?p=mediawiki/extensions/Ask.git
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point for MediaWiki. Use Ask.php' );
}

spl_autoload_register( function ( $className ) {
	static $classes = false;

	if ( $classes === false ) {
		$classes = include( __DIR__ . '/' . 'Ask.classes.php' );
	}

	if ( array_key_exists( $className, $classes ) ) {
		include_once __DIR__ . '/' . $classes[$className];
	}
} );
