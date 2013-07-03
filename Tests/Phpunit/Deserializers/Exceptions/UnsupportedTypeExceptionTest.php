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
		$unsupportedType = 'fooBarBaz';
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );

		$exception = new UnsupportedTypeException( $unsupportedType, $deserializer );

		$this->assertRequiredFieldsAreSet( $exception, $unsupportedType, $deserializer );
	}

	public function testConstructorWithAllArguments() {
		$unsupportedType = 'fooBarBaz';
		$deserializer = $this->getMock( 'Ask\Deserializers\Deserializer' );
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new UnsupportedTypeException( $unsupportedType, $deserializer, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $unsupportedType, $deserializer );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( UnsupportedTypeException $exception, $unsupportedType, $deserializer ) {
		$this->assertEquals( $unsupportedType, $exception->getUnsupportedType() );
		$this->assertEquals( $deserializer, $exception->getDeserializer() );
	}

}
