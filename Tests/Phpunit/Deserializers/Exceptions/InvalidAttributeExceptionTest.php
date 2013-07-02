<?php

namespace Ask\Tests\Phpunit\Deserializers\Exceptions;

use Ask\Deserializers\Exceptions\InvalidAttributeException;

/**
 * @covers Ask\Deserializers\Exceptions\InvalidAttributeException
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
class InvalidAttributeExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$attributeName = 'theGame';
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$exception = new InvalidAttributeException( $attributeName, $deserializer );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName, $deserializer );
	}

	public function testConstructorWithAllArguments() {
		$attributeName = 'theGame';
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new InvalidAttributeException( $attributeName, $deserializer, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName, $deserializer );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( InvalidAttributeException $exception, $attributeName, $deserializer ) {
		$this->assertEquals( $attributeName, $exception->getAttributeName() );
		$this->assertEquals( $deserializer, $exception->getDeserializer() );
	}

}
