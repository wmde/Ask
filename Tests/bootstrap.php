<?php

/**
 * Test class registration file for the Ask library.
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

require_once( __DIR__ . '/../Ask.php' );

spl_autoload_register( function ( $className ) {
	static $classes = false;

	if ( $classes === false ) {
		$classes = include(  __DIR__ . '/AskTestClasses.php' );
	}

	if ( array_key_exists( $className, $classes ) ) {
		include_once __DIR__ . '/../../' . $classes[$className];
	}
} );