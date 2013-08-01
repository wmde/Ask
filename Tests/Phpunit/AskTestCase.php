<?php

namespace Ask\Tests\Phpunit;

/**
 * Base class for unit tests in the Ask library.
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class AskTestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * Utility method taking an array of elements and wrapping
	 * each element in it's own array. Useful for data providers
	 * that only return a single argument.
	 *
	 * @since 1.0
	 *
	 * @param array $elements
	 *
	 * @return array
	 */
	protected function arrayWrap( array $elements ) {
		return array_map(
			function( $element ) {
				return array( $element );
			},
			$elements
		);
	}

	protected function assertPrimitiveStructure( $value ) {
		if ( is_array( $value ) || is_object( $value ) ) {
			// TODO: would be good if we could reject objects that are not simple maps
			$value = (array)$value;

			if ( empty( $value ) ) {
				$this->assertTrue( true );
			}

			foreach ( $value as $subValue ) {
				$this->assertPrimitiveStructure( $subValue );
			}
		}
		else {
			$this->assertFalse( is_resource( $value ), 'Value should not be a resource' );
		}
	}

}
