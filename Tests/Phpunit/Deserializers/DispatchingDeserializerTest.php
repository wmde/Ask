<?php

namespace Ask\Tests\Phpunit\Deserializers;

use Ask\Deserializers\DispatchingDeserializer;

/**
 * @covers Ask\Deserializers\DispatchingDeserializer
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
class DispatchingDeserializerTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstructWithNoDeserializers() {
		new DispatchingDeserializer( array() );
		$this->assertTrue( true );
	}

	public function testCannotConstructWithNonDeserializers() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new DispatchingDeserializer( array( 42, 'foobar' ) );
	}

	public function testCanDeserialize() {
		$subDeserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$subDeserializer->expects( $this->exactly( 4 ) )
			->method( 'canDeserialize' )
			->will( $this->returnCallback( function( $value ) {
				return $value > 9000;
			} ) );

		$serializer = new DispatchingDeserializer( array( $subDeserializer ) );

		$this->assertFalse( $serializer->canDeserialize( 0 ) );
		$this->assertFalse( $serializer->canDeserialize( 42 ) );
		$this->assertTrue( $serializer->canDeserialize( 9001 ) );
		$this->assertTrue( $serializer->canDeserialize( 31337 ) );
	}

	public function testDeserializeWithDeserializableValues() {
		$subDeserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$subDeserializer->expects( $this->any() )
			->method( 'canDeserialize' )
			->will( $this->returnValue( true ) );

		$subDeserializer->expects( $this->any() )
			->method( 'deserialize' )
			->will( $this->returnValue( 42 ) );

		$serializer = new DispatchingDeserializer( array( $subDeserializer ) );

		$this->assertEquals( 42, $serializer->deserialize( 'foo' ) );
		$this->assertEquals( 42, $serializer->deserialize( null ) );
	}

	public function testSerializeWithUnserializableValue() {
		$subDeserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$subDeserializer->expects( $this->once() )
			->method( 'canDeserialize' )
			->will( $this->returnValue( false ) );

		$serializer = new DispatchingDeSerializer( array( $subDeserializer ) );

		$this->setExpectedException( 'Ask\Deserializers\Exceptions\DeserializationException' );
		$serializer->deserialize( 0 );
	}

	public function testSerializeWithMultipleSubSerializers() {
		$subDeserializer0 = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$subDeserializer0->expects( $this->any() )
			->method( 'canDeserialize' )
			->will( $this->returnValue( true ) );

		$subDeserializer0->expects( $this->any() )
			->method( 'deserialize' )
			->will( $this->returnValue( 42 ) );

		$subDeserializer1 = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$subDeserializer1->expects( $this->any() )
			->method( 'canDeserialize' )
			->will( $this->returnValue( false ) );

		$subDeserializer2 = clone $subDeserializer1;

		$serializer = new DispatchingDeserializer( array( $subDeserializer1, $subDeserializer0, $subDeserializer2 ) );

		$this->assertEquals( 42, $serializer->deserialize( 'foo' ) );
	}

	public function testAddSerializer() {
		$deserializer = new DispatchingDeserializer( array() );

		$subDeserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$subDeserializer->expects( $this->any() )
			->method( 'canDeserialize' )
			->will( $this->returnValue( true ) );

		$subDeserializer->expects( $this->any() )
			->method( 'deserialize' )
			->will( $this->returnValue( 42 ) );

		$deserializer->addDeserializer( $subDeserializer );

		$this->assertEquals(
			42,
			$deserializer->deserialize( null )
		);
	}

}
