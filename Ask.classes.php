<?php

/**
 * Class registration file for the Ask library.
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
		'Ask\Arrayable',
		'Ask\Comparable',
		'Ask\Hashable',
		'Ask\Immutable',

		'Ask\Language\Description\AnyValue',
		'Ask\Language\Description\Conjunction',
		'Ask\Language\Description\Description',
		'Ask\Language\Description\DescriptionCollection',
		'Ask\Language\Description\Disjunction',
		'Ask\Language\Description\SomeProperty',
		'Ask\Language\Description\ValueDescription',

		'Ask\Language\Option\PropertyValueSortExpression',
		'Ask\Language\Option\QueryOptions',
		'Ask\Language\Option\SortExpression',
		'Ask\Language\Option\SortOptions',


		'Ask\Language\Selection\PropertySelection',
		'Ask\Language\Selection\SelectionRequest',
		'Ask\Language\Selection\SubjectSelection',

		'Ask\Language\Query'
	);

	$paths = array();

	foreach ( $classes as $class ) {
		$path = 'includes/' . str_replace( '\\', '/', $class ) . '.php';

		$paths[$class] = $path;
	}

	return $paths;

} );
