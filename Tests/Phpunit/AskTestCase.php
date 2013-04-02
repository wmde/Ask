<?php

namespace Ask\Tests\Phpunit;

/**
 * Base class for unit tests in the Ask library.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
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
	 * @since 0.1
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

	/**
	 * @param array $array
	 * @param object $object Needs to implement both Typeable and ArrayValueProvider
	 */
	protected function assertToArrayStructure( array $array, $object ) {
		$this->assertInternalType( 'array', $array );
		$this->assertArrayHasKey( 'type', $array );
		$this->assertArrayHasKey( 'value', $array );
		$this->assertCount( 2, $array );

		$this->assertEquals(
			array(
				'type' => $object->getType(),
				'value' => $object->getArrayValue(),
			),
			$array
		);
	}

}
