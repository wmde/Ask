<?php

namespace Ask\Tests\Phpunit;

use Ask\AskFactory;
use Serializers\Serializer;

/**
 * @covers Ask\AskFactory
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
class AskFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanGetQuerySerializer() {
		$askFactory = new AskFactory();

		$querySerializer = $askFactory->newQuerySerializer();

		$query = $this->getMockBuilder( 'Ask\Language\Query' )
			->disableOriginalConstructor()->getMock();

		$this->assertSerializerThatCanSerializeObject( $querySerializer, $query );
	}

	protected function assertSerializerThatCanSerializeObject( Serializer $serializer, $object ) {
		$this->assertTrue( $serializer->canSerialize( $object ) );
	}

	public function testCanGetDescriptionSerializer() {
		$askFactory = new AskFactory();

		$serializer = $askFactory->newDescriptionSerializer();

		$object = $this->getMock( 'Ask\Language\Description\Description' );

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	public function testCanGetSelectionRequestSerializer() {
		$askFactory = new AskFactory();

		$serializer = $askFactory->newSelectionRequestSerializer();

		$object = $this->getMock( 'Ask\Language\Selection\SelectionRequest' );

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	public function testCanGetSortExpressionSerializer() {
		$askFactory = new AskFactory();

		$serializer = $askFactory->newSortExpressionSerializer();

		$object = $this->getMock( 'Ask\Language\Option\SortExpression' );

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

	public function testCanGetQueryOptionsSerializer() {
		$askFactory = new AskFactory();

		$serializer = $askFactory->newQueryOptionsSerializer();

		$object = $this->getMockBuilder( 'Ask\Language\Option\QueryOptions' )
			->disableOriginalConstructor()->getMock();

		$this->assertSerializerThatCanSerializeObject( $serializer, $object );
	}

}
