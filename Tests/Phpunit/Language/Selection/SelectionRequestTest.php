<?php

namespace Ask\Tests\Phpunit\Language\Selection;

use Ask\Language\Selection\SelectionRequest;

/**
 * Base class for unit tests for the Ask\Language\Selection\Selection implementing classes.
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
abstract class SelectionRequestTest extends \Ask\Tests\Phpunit\AskTestCase {

	/**
	 * @since 0.1
	 *
	 * @return SelectionRequest[]
	 */
	protected abstract function getInstances();

	/**
	 * @since 0.1
	 *
	 * @return SelectionRequest[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $request
	 */
	public function testReturnTypeOfGetType( SelectionRequest $request ) {
		$this->assertInternalType( 'integer', $request->getType() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $object
	 */
	public function testReturnValueOfToArray( SelectionRequest $object ) {
		$array = $object->toArray();
		$this->assertToArrayStructure( $array, $object );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $object
	 */
	public function testReturnTypeOfGetArrayValue( SelectionRequest $object ) {
		$array = $object->getArrayValue();
		$this->assertPrimitiveStructure( $array );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $object
	 */
	public function testComparableSelfIsEqual( SelectionRequest $object ) {
		$this->assertTrue( $object->equals( $object ), 'Description is equal to itself' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $object
	 */
	public function testComparableNotEqual( SelectionRequest $object ) {
		$this->assertFalse( $object->equals( '~[,,_,,]:3' ), 'Description not equal to string' );
		$this->assertFalse( $object->equals( new \stdClass() ), 'Description not equal to empty object' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $object
	 */
	public function testGetHashReturnType( SelectionRequest $object ) {
		$this->assertInternalType( 'string', $object->getHash() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SelectionRequest $object
	 */
	public function testGetHashStability( SelectionRequest $object ) {
		$this->assertEquals( $object->getHash(), $object->getHash() );
	}

}
