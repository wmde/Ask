<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\Description;

/**
 * Base class for unit tests for the Ask\Language\Description\Description implementing classes.
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class DescriptionTest extends \Ask\Tests\Phpunit\AskTestCase {

	/**
	 * @since 1.0
	 *
	 * @return Description[]
	 */
	protected abstract function getInstances();

	/**
	 * @since 1.0
	 *
	 * @return Description[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Description $description
	 */
	public function testReturnTypeOfGetSize( Description $description ) {
		$size = $description->getSize();

		$this->assertInternalType( 'integer', $size );
		$this->assertGreaterThanOrEqual( 0, $size );
		$this->assertEquals( $size, $description->getSize() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Description $description
	 */
	public function testReturnTypeOfGetDepth( Description $description ) {
		$depth = $description->getDepth();

		$this->assertInternalType( 'integer', $depth );
		$this->assertGreaterThanOrEqual( 0, $depth );
		$this->assertEquals( $depth, $description->getDepth() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Description $description
	 */
	public function testComparableSelfIsEqual( Description $description ) {
		$this->assertTrue( $description->equals( $description ), 'Description is equal to itself' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Description $description
	 */
	public function testComparableNotEqual( Description $description ) {
		$this->assertFalse( $description->equals( '~[,,_,,]:3' ), 'Description not equal to string' );
		$this->assertFalse( $description->equals( new \stdClass() ), 'Description not equal to empty object' );
		$this->assertFalse( $description->equals( new FooDescription() ), 'Description not equal to a FooDescription' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Description $description
	 */
	public function testGetHashReturnType( Description $description ) {
		$this->assertInternalType( 'string', $description->getHash() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Description $description
	 */
	public function testGetHashStability( Description $description ) {
		$this->assertEquals( $description->getHash(), $description->getHash() );
	}

}

class FooDescription extends \Ask\Language\Description\DescriptionCollection {

	public function __construct() {
		parent::__construct( array() );
	}

	public function getType() {
		return 'foo';
	}

	public function equals( $t ) {
		return false;
	}

}