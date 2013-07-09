<?php

namespace Ask\Tests\Phpunit\Deserializers;

use Ask\Deserializers\QueryOptionsDeserializer;
use Ask\Deserializers\SortExpressionDeserializer;
use DataValues\DataValueFactory;

/**
 * @covers Ask\Deserializers\QueryOptionsDeserializer
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
class QueryOptionsDeserializerTest extends \PHPUnit_Framework_TestCase {

	protected function newQueryOptionsDeserializer() {
		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		$sortExpressionSerializer = new SortExpressionDeserializer( $dvFactory );

		return new QueryOptionsDeserializer( $sortExpressionSerializer );
	}

	/**
	 * @dataProvider invalidObjectTypeProvider
	 */
	public function testCannotDeserializeWithInvalidObjectType( $notQueryOptions ) {
		$serializer = $this->newQueryOptionsDeserializer();

		$this->assertFalse( $serializer->canDeserialize( $notQueryOptions ) );

		$this->setExpectedException( 'Ask\Deserializers\Exceptions\UnsupportedTypeException' );
		$serializer->deserialize( $notQueryOptions );
	}

	public function invalidObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'foobar',
			'limit' => 10,
			'offset' => 0,
			'sort' => array(
				'expressions' => array()
			)
		) );

		$argLists[] = array( array(
			'objectType' => 'QUERYOPTIONS',
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
	public function testCannotDeserilaizeWithoutObjectType( $notQueryOptions ) {
		$serializer = $this->newQueryOptionsDeserializer();

		$this->assertFalse( $serializer->canDeserialize( $notQueryOptions ) );

		$this->setExpectedException( 'Ask\Deserializers\Exceptions\MissingTypeException' );
		$serializer->deserialize( $notQueryOptions );
	}

	public function missingObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( array() );
		$argLists[] = array( 'foo bar' );

		$argLists[] = array( array(
			'limit' => 10,
			'offset' => 0,
			'sort' => array(
				'expressions' => array()
			)
		) );

		$argLists[] = array( array(
			'ObjectType' => 'sortExpression',
		) );

		$argLists[] = array( array(
			'OBJECTTYPE' => 'sortExpression',
		) );

		return $argLists;
	}

	/**
	 * @dataProvider optionsWithMissingAttributeProvider
	 */
	public function testPropertySelectionRequiresAllAttributes( array $incompleteSerialization ) {
		$this->setExpectedException( 'Ask\Deserializers\Exceptions\MissingAttributeException' );
		$this->newQueryOptionsDeserializer()->deserialize( $incompleteSerialization );
	}



	public function optionsWithMissingAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'queryOptions',
			'offset' => 0,
			'sort' => array(
				'expressions' => array()
			)
		) );

		$argLists[] = array( array(
			'objectType' => 'queryOptions',
			'limit' => 10,
			'sort' => array(
				'expressions' => array()
			)
		) );

		$argLists[] = array( array(
			'objectType' => 'queryOptions',
			'limit' => 10,
			'offset' => 0,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider optionsWithInvalidAttributeProvider
	 */
	public function testPropertySelectionRequiresValidAttributes( array $invalidSerialization ) {
		$this->setExpectedException( 'Ask\Deserializers\Exceptions\DeserializationException' );
		$this->newQueryOptionsDeserializer()->deserialize( $invalidSerialization );
	}

	public function optionsWithInvalidAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'queryOptions',
			'limit' => 'hax',
			'offset' => 0,
			'sort' => array(
				'expressions' => array()
			)
		) );

		$argLists[] = array( array(
			'objectType' => 'queryOptions',
			'limit' => 10,
			'offset' => 'hax',
			'sort' => array(
				'expressions' => array()
			)
		) );

		$argLists[] = array( array(
			'objectType' => 'queryOptions',
			'limit' => 10,
			'offset' => 0,
			'sort' => 'hax'
		) );

		return $argLists;
	}

}
