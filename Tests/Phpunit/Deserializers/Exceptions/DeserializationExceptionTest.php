<?php

namespace Ask\Tests\Phpunit\Deserializers\Exceptions;

use Ask\Deserializers\Exceptions\DeserializationException;

/**
 * @covers Ask\Deserializers\Exceptions\DeserializationException
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
class DeserializationExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$exception = new DeserializationException( $deserializer );

		$this->assertRequiredFieldsAreSet( $exception, $deserializer );
	}

	public function testConstructorWithAllArguments() {
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new DeserializationException( $deserializer, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $deserializer );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( DeserializationException $exception, $deserializer ) {
		$this->assertEquals( $deserializer, $exception->getDeserializer() );
	}

}
