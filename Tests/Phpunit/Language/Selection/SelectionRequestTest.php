<?php

namespace Ask\Tests\Phpunit\Language\Selection;

use Ask\Language\Selection\SelectionRequest;

/**
 * Base class for unit tests for the Ask\Language\Selection\Selection implementing classes.
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class SelectionRequestTest extends \Ask\Tests\Phpunit\AskTestCase {

	/**
	 * @since 1.0
	 *
	 * @return SelectionRequest[]
	 */
	protected abstract function getInstances();

	/**
	 * @since 1.0
	 *
	 * @return SelectionRequest[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SelectionRequest $request
	 */
	public function testReturnTypeOfGetType( SelectionRequest $request ) {
		$this->assertInternalType( 'string', $request->getType() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SelectionRequest $object
	 */
	public function testComparableSelfIsEqual( SelectionRequest $object ) {
		$this->assertTrue( $object->equals( $object ), 'Description is equal to itself' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
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
	 * @since 1.0
	 *
	 * @param SelectionRequest $object
	 */
	public function testGetHashReturnType( SelectionRequest $object ) {
		$this->assertInternalType( 'string', $object->getHash() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SelectionRequest $object
	 */
	public function testGetHashStability( SelectionRequest $object ) {
		$this->assertEquals( $object->getHash(), $object->getHash() );
	}

}
