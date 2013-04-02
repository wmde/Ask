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
return call_user_func( function() {

	// PSR-0 compliant :)

	$classes = array(
		'Ask\Tests\Phpunit\AskTestCase',

		'Ask\Tests\Phpunit\Language\Description\DescriptionTest',
		'Ask\Tests\Phpunit\Language\Description\DescriptionCollectionTest',

		'Ask\Tests\Phpunit\Language\Option\SortExpressionTest',

		'Ask\Tests\Phpunit\Language\Selection\SelectionRequestTest',
	);

	$paths = array();

	foreach ( $classes as $class ) {
		$path = str_replace( '\\', '/', $class ) . '.php';

		$paths[$class] = $path;
	}

	return $paths;

} );
