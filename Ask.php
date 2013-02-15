<?php

/**
 * Initialization file for the Ask library.
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

/**
 * This documentation group collects source code files belonging to Ask.
 *
 * @defgroup Ask Ask
 */

/**
 * Tests part of the Ask extension.
 *
 * @defgroup AskTests AskTest
 * @ingroup Ask
 * @ingroup Test
 */

// Attempt to include the DataValues lib if that hasn't been done yet.
if ( !defined( 'DataValues_VERSION' ) ) {
	@include_once( __DIR__ . '/../DataValues/DataValues.php' );
}

// Only initialize the extension when all dependencies are present.
if ( !defined( 'DataValues_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="https://www.mediawiki.org/wiki/Extension:DataValues">DataValues</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Ask">Ask</a>.<br />' );
}

define( 'Ask_VERSION', '0.1 alpha' );

// @codeCoverageIgnoreStart
call_user_func( function() {
	$extension = defined( 'MEDIAWIKI' ) ? 'mw' : 'standalone';
	require_once __DIR__ . '/Ask.' . $extension . '.php';
} );
// @codeCoverageIgnoreEnd
