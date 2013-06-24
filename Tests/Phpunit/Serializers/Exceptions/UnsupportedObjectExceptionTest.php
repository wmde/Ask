<?php

namespace Ask\Tests\Phpunit\Serializers\Exceptions;

use Ask\Serializers\Exceptions\UnsupportedObjectException;

/**
 * @covers Ask\Serializers\Exceptions\UnsupportedObjectException
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
class UnsupportedObjectExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$object = (object)array( 'the' => 'game' );
		$serializer = $this->getMock( 'Ask\Serializers\Serializer' );

		$exception = new UnsupportedObjectException( $object, $serializer );

		$this->assertRequiredFieldsAreSet( $exception, $object, $serializer );
	}

	public function testConstructorWithAllArguments() {
		$object = (object)array( 'the' => 'game' );
		$serializer = $this->getMock( 'Ask\Serializers\Serializer' );
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new UnsupportedObjectException( $object, $serializer, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $object, $serializer );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( UnsupportedObjectException $exception, $object, $serializer ) {
		$this->assertEquals( $object, $exception->getUnsupportedObject() );
		$this->assertEquals( $serializer, $exception->getSerializer() );
	}

}
