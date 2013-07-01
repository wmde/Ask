<?php

namespace Ask\Tests\Phpunit\Deserializers\Exceptions;

use Ask\Deserializers\Exceptions\UnsupportedTypeException;

/**
 * @covers Ask\Deserializers\Exceptions\UnsupportedTypeException
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
class UnsupportedTypeExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$serialization = array( 'the' => 'game' );
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$exception = new UnsupportedTypeException( $serialization, $deserializer );

		$this->assertRequiredFieldsAreSet( $exception, $serialization, $deserializer );
	}

	public function testConstructorWithAllArguments() {
		$serialization = array( 'the' => 'game' );
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new UnsupportedTypeException( $serialization, $deserializer, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $serialization, $deserializer );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( UnsupportedTypeException $exception, $object, $deserializer ) {
		$this->assertEquals( $object, $exception->getUnsupportedType() );
		$this->assertEquals( $deserializer, $exception->getDeserializer() );
	}

}
