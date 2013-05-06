#!/usr/bin/env php
<?php

require_once( 'PHPUnit/Runner/Version.php' );

if ( PHPUnit_Runner_Version::id() !== '@package_version@'
	&& version_compare( PHPUnit_Runner_Version::id(), '3.7', '<' )
) {
	die( 'PHPUnit 3.7 or later required, you have ' . PHPUnit_Runner_Version::id() . ".\n" );
}
require_once( 'PHPUnit/Autoload.php' );

define( 'DATAVALUES', true );
require_once( __DIR__ . '/../../Ask.php' );

spl_autoload_register( function ( $className ) {
	static $classes = false;

	if ( $classes === false ) {
		$classes = include(  __DIR__ . '/../AskTestClasses.php' );
	}

	if ( array_key_exists( $className, $classes ) ) {
		include_once __DIR__ . '/../../../' . $classes[$className];
	}
} );

echo 'Running tests for Ask version ' . Ask_VERSION . ".\n";

$arguments = $_SERVER['argv'];
array_shift( $arguments );

if ( array_search( '--group', $arguments ) === false ) {
	$arguments[] = '--group';
	$arguments[] = 'Ask';
}

$arguments[] = __DIR__;

$runner = new PHPUnit_TextUI_Command();
$runner->run( $arguments );
