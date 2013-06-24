<?php

namespace Ask\Tests\Phpunit\Serializers;

use Ask\Serializers\DispatchingSerializer;

/**
 * @covers Ask\Serializers\DispatchingSerializer
 *
 * @file
 * @since 0.1
 *
 * @ingroup Ask
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DispatchingSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testConstructWithNoSerializers() {
		$serializer = new DispatchingSerializer( array() );

		$this->assertFalse( $serializer->canSerialize( 'foo' ) );
		$this->assertFalse( $serializer->canSerialize( null ) );

		$this->setExpectedException( 'Ask\Serializers\Exceptions\UnsupportedObjectException' );

		$serializer->serialize( 'foo' );
	}

	public function testConstructWithInvalidArgumentsCausesException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new DispatchingSerializer( array( new \stdClass() ) );
	}

	public function testCanSerialize() {
		$subSerializer = $this->getMock( 'Ask\Serializers\Serializer' );

		$subSerializer->expects( $this->exactly( 4 ) )
			->method( 'canSerialize' )
			->will( $this->returnCallback( function( $value ) {
				return $value > 9000;
			} ) );

		$serializer = new DispatchingSerializer( array( $subSerializer ) );

		$this->assertFalse( $serializer->canSerialize( 0 ) );
		$this->assertFalse( $serializer->canSerialize( 42 ) );
		$this->assertTrue( $serializer->canSerialize( 9001 ) );
		$this->assertTrue( $serializer->canSerialize( 31337 ) );
	}

	public function testSerializeWithSerializableValues() {
		$subSerializer = $this->getMock( 'Ask\Serializers\Serializer' );

		$subSerializer->expects( $this->any() )
			->method( 'canSerialize' )
			->will( $this->returnValue( true ) );

		$subSerializer->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 42 ) );

		$serializer = new DispatchingSerializer( array( $subSerializer ) );

		$this->assertEquals( 42, $serializer->serialize( 'foo' ) );
		$this->assertEquals( 42, $serializer->serialize( null ) );
	}

	public function testSerializeWithUnserializableValue() {
		$subSerializer = $this->getMock( 'Ask\Serializers\Serializer' );

		$subSerializer->expects( $this->once() )
			->method( 'canSerialize' )
			->will( $this->returnValue( false ) );

		$serializer = new DispatchingSerializer( array( $subSerializer ) );

		$this->setExpectedException( 'Ask\Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( 0 );
	}

	public function testSerializeWithMultipleSubSerializers() {
		$subSerializer0 = $this->getMock( 'Ask\Serializers\Serializer' );

		$subSerializer0->expects( $this->any() )
			->method( 'canSerialize' )
			->will( $this->returnValue( true ) );

		$subSerializer0->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 42 ) );

		$subSerializer1 = $this->getMock( 'Ask\Serializers\Serializer' );

		$subSerializer1->expects( $this->any() )
			->method( 'canSerialize' )
			->will( $this->returnValue( false ) );

		$subSerializer2 = clone $subSerializer1;

		$serializer = new DispatchingSerializer( array( $subSerializer1, $subSerializer0, $subSerializer2 ) );

		$this->assertEquals( 42, $serializer->serialize( 'foo' ) );
	}

	public function testAddSerializer() {
		$serializer = new DispatchingSerializer( array() );

		$subSerializer = $this->getMock( 'Ask\Serializers\Serializer' );

		$subSerializer->expects( $this->any() )
			->method( 'canSerialize' )
			->will( $this->returnValue( true ) );

		$subSerializer->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 42 ) );

		$serializer->addSerializer( $subSerializer );

		$this->assertEquals(
			42,
			$serializer->serialize( null )
		);
	}

}
