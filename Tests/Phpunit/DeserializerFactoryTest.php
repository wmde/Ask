<?php

namespace Ask\Tests\Phpunit;

use Ask\DeserializerFactory;
use Deserializers\Deserializer;

/**
 * @covers Ask\DeserializerFactory
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
class DeserializerFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanGetQueryDeserializer() {
		$dataValueFactory = $this->getMock('DataValues\DataValueFactory');
		$askFactory = new DeserializerFactory( $dataValueFactory );

		$deserializer = $askFactory->newQueryDeserializer();

		$object = array(
			'objectType' => 'query',
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'conjunction',
				'value' => array(
					'descriptions' => array()
				)
			),
			'options' => array(),
			'selectionRequests' => array(),
		);

		$this->assertDeserializerThatCanDeserializeObject( $deserializer, $object );
	}

	protected function assertDeserializerThatCanDeserializeObject( Deserializer $deserializer, $object ) {
		$this->assertTrue( $deserializer->isDeserializerFor( $object ) );
	}

	public function testCanGetDescriptionDeserializer() {
		$dataValueFactory = $this->getMock('DataValues\DataValueFactory');
		$askFactory = new DeserializerFactory( $dataValueFactory );

		$deserializer = $askFactory->newDescriptionDeserializer( $dataValueFactory );

		$object = array(
			'objectType' => 'description',
			'descriptionType' => 'anyValue',
			'value' => array()
		);

		$this->assertDeserializerThatCanDeserializeObject( $deserializer, $object );
	}

	public function testCanGetSelectionRequestDeserializer() {
		$dataValueFactory = $this->getMock('DataValues\DataValueFactory');
		$askFactory = new DeserializerFactory( $dataValueFactory );

		$deserializer = $askFactory->newSelectionRequestDeserializer( $dataValueFactory );

		$object = array(
			'objectType' => 'selectionRequest',
			'selectionRequestType' => 'subject',
			'value' => array(),
		);

		$this->assertDeserializerThatCanDeserializeObject( $deserializer, $object );
	}

	public function testCanGetSortExpressionDeserializer() {
		$dataValueFactory = $this->getMock('DataValues\DataValueFactory');
		$askFactory = new DeserializerFactory( $dataValueFactory );

		$deserializer = $askFactory->newSortExpressionDeserializer( $dataValueFactory );

		$object = array(
			'objectType' => 'sortExpression',
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		);

		$this->assertDeserializerThatCanDeserializeObject( $deserializer, $object );
	}

	public function testCanGetQueryOptionsDeserializer() {
		$dataValueFactory = $this->getMock('DataValues\DataValueFactory');
		$askFactory = new DeserializerFactory( $dataValueFactory );

		$deserializer = $askFactory->newQueryOptionsDeserializer( $dataValueFactory );

		$object = array(
			'objectType' => 'queryOptions',
			'limit' => 100,
			'offset' => 42,
			'sort' => array(
				'expressions' => array(),
			)
		);

		$this->assertDeserializerThatCanDeserializeObject( $deserializer, $object );
	}


}
