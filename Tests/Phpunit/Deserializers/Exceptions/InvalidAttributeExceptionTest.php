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

		$exception = new InvalidAttributeException( $attributeName );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName );
	}

	public function testConstructorWithAllArguments() {
		$attributeName = 'theGame';
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new InvalidAttributeException( $attributeName, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( InvalidAttributeException $exception, $attributeName ) {
		$this->assertEquals( $attributeName, $exception->getAttributeName() );
	}

}
