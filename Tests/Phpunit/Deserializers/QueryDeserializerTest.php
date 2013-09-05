<?php

namespace Ask\Tests\Phpunit\Serialization;

use Ask\Deserializers\DescriptionDeserializer;
use Ask\Deserializers\QueryDeserializer;
use Ask\Deserializers\QueryOptionsDeserializer;
use Ask\Deserializers\SortExpressionDeserializer;
use DataValues\DataValueFactory;
use Deserializers\DispatchingDeserializer;

/**
 * @covers Ask\Deserializers\QueryDeserializer
 *
 * @file
 * @since 1.0
 *
 * @ingroup Ask
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryDeserializerTest extends \PHPUnit_Framework_TestCase {

	protected function newQueryDeserializer() {
		$componentDeserializer = new DispatchingDeserializer();

		$componentDeserializer->addDeserializer( new QueryOptionsDeserializer( $componentDeserializer ) );

		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		$componentDeserializer->addDeserializer( new DescriptionDeserializer( $dvFactory ) );
		$componentDeserializer->addDeserializer( new SortExpressionDeserializer( $dvFactory ) );

		return new QueryDeserializer( $componentDeserializer );
	}

	/**
	 * @dataProvider invalidObjectTypeProvider
	 */
	public function testCannotDeserializeWithInvalidObjectType( $notAQuery ) {
		$serializer = $this->newQueryDeserializer();

		$this->assertFalse( $serializer->isDeserializerFor( $notAQuery ) );

		$this->setExpectedException( 'Deserializers\Exceptions\UnsupportedTypeException' );
		$serializer->deserialize( $notAQuery );
	}

	public function invalidObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'foobar',
		) );

		$argLists[] = array( array(
			'objectType' => 'QUERY',
		) );

		$argLists[] = array( array(
			'objectType' => null,
		) );

		$argLists[] = array( array(
			'objectType' => array(),
		) );

		$argLists[] = array( array(
			'objectType' => 42,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider missingObjectTypeProvider
	 */
	public function testCannotDeserilaizeWithoutObjectType( $notAQuery ) {
		$serializer = $this->newQueryDeserializer();

		$this->assertFalse( $serializer->isDeserializerFor( $notAQuery ) );

		$this->setExpectedException( 'Deserializers\Exceptions\MissingTypeException' );
		$serializer->deserialize( $notAQuery );
	}

	public function missingObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( array() );
		$argLists[] = array( 'foo bar' );

		$argLists[] = array( array(
			'ObjectType' => 'query',
		) );

		$argLists[] = array( array(
			'OBJECTTYPE' => 'query',
		) );

		return $argLists;
	}

	/**
	 * @dataProvider optionsWithMissingAttributeProvider
	 */
	public function testPropertySelectionRequiresAllAttributes( array $incompleteSerialization ) {
		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newQueryDeserializer()->deserialize( $incompleteSerialization );
	}

	public function optionsWithMissingAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'query',
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'options' => array(
				'limit' => 10,
				'offset' => 1,
				'sort' => array(
					'expressions' => array()
				)
			),
		) );

		$argLists[] = array( array(
			'objectType' => 'query',
			'options' => array(
				'limit' => 10,
				'offset' => 1,
				'sort' => array(
					'expressions' => array()
				)
			),
			'selectionRequests' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 'query',
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'selectionRequests' => array()
		) );

		return $argLists;
	}

	/**
	 * @dataProvider optionsWithInvalidAttributeProvider
	 */
	public function testPropertySelectionRequiresValidAttributes( array $invalidSerialization ) {
		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$this->newQueryDeserializer()->deserialize( $invalidSerialization );
	}

	public function optionsWithInvalidAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'query',
			'description' => 'hax',
			'options' => array(
				'limit' => 10,
				'offset' => 1,
				'sort' => array(
					'expressions' => array()
				)
			),
			'selectionRequests' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 'query',
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'options' => 'hax',
			'selectionRequests' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 'query',
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'options' => array(
				'limit' => 10,
				'offset' => 1,
				'sort' => array(
					'expressions' => array()
				)
			),
			'selectionRequests' => 'hax'
		) );

		return $argLists;
	}

}
