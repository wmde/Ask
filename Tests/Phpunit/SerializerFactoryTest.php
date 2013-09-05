<?php

namespace Ask\Tests\Phpunit;

use Ask\SerializerFactory;
use Serializers\Serializer;

/**
 * @covers Ask\SerializerFactory
 *
 * @file
 * @since 1.0
 *
 * @ingroup Ask
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Adam Shorland < adamshorland@gmail.com >
 */
class SerializerFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanGetQuerySerializer() {
		$askFactory = new SerializerFactory();

		$serializer = $askFactory->newQuerySerializer();

		$object = $this->getMockBuilder( 'Ask\Language\Query' )
			->disableOriginalConstructor()->getMock();

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	protected function assertSerializerThatCanSerializeObject( Serializer $serializer, $object ) {
		$this->assertTrue( $serializer->isSerializerFor( $object ) );
	}

	public function testCanGetDescriptionSerializer() {
		$askFactory = new SerializerFactory();

		$serializer = $askFactory->newDescriptionSerializer();

		$object = $this->getMock( 'Ask\Language\Description\Description' );

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	public function testCanGetSelectionRequestSerializer() {
		$askFactory = new SerializerFactory();

		$serializer = $askFactory->newSelectionRequestSerializer();

		$object = $this->getMock( 'Ask\Language\Selection\SelectionRequest' );

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	public function testCanGetSortExpressionSerializer() {
		$askFactory = new SerializerFactory();

		$serializer = $askFactory->newSortExpressionSerializer();

		$object = $this->getMock( 'Ask\Language\Option\SortExpression' );

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	public function testCanGetQueryOptionsSerializer() {
		$askFactory = new SerializerFactory();

		$serializer = $askFactory->newQueryOptionsSerializer();

		$object = $this->getMockBuilder( 'Ask\Language\Option\QueryOptions' )
			->disableOriginalConstructor()->getMock();

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}


}
