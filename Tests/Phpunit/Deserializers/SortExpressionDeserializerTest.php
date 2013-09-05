<?php

namespace Ask\Tests\Phpunit\Deserializers;

use Ask\Deserializers\SortExpressionDeserializer;
use Ask\Language\Description\ValueDescription;
use Ask\Language\Option\SortExpression;
use DataTypes\DataTypeFactory;
use DataValues\DataValueFactory;
use DataValues\StringValue;

/**
 * @covers Ask\Deserializers\SortExpressionDeserializer
 * @covers Ask\Deserializers\Strategies\SortExpressionDeserializationStrategy
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
class SortExpressionDeserializerTest extends \PHPUnit_Framework_TestCase {

	protected function newSortExpressionDeserializer() {
		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		return new SortExpressionDeserializer( $dvFactory );
	}

	/**
	 * @dataProvider invalidObjectTypeProvider
	 */
	public function testCannotDeserializeWithInvalidObjectType( $notADescription ) {
		$serializer = $this->newSortExpressionDeserializer();

		$this->assertFalse( $serializer->isDeserializerFor( $notADescription ) );

		$this->setExpectedException( 'Deserializers\Exceptions\UnsupportedTypeException' );
		$serializer->deserialize( $notADescription );
	}

	public function invalidObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'foobar',
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 'DESCRIPTION',
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => null,
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => array(),
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 42,
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		return $argLists;
	}

	/**
	 * @dataProvider missingObjectTypeProvider
	 */
	public function testCannotDeserilaizeWithoutObjectType( $notASortExpression ) {
		$serializer = $this->newSortExpressionDeserializer();

		$this->assertFalse( $serializer->isDeserializerFor( $notASortExpression ) );

		$this->setExpectedException( 'Deserializers\Exceptions\MissingTypeException' );
		$serializer->deserialize( $notASortExpression );
	}

	public function missingObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( array() );
		$argLists[] = array( 'foo bar' );

		$argLists[] = array( array(
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'ObjectType' => 'sortExpression',
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'OBJECTTYPE' => 'sortExpression',
			'sortExpressionType' => 'propertyValue',
			'value' => array()
		) );

		return $argLists;
	}

	public function testCannotDeserilaizeWithUnknownSortExpressionType() {
		$notASortExpression = array(
			'objectType' => 'sortExpression',
			'sortExpressionType' => 'fooBar',
			'value' => array()
		);

		$this->setExpectedException( 'Deserializers\Exceptions\InvalidAttributeException' );
		$this->newSortExpressionDeserializer()->deserialize( $notASortExpression );
	}

	public function testCannotDeserilaizeWithoutSortExpressionType() {
		$notASortExpression = array(
			'objectType' => 'sortExpression',
			'value' => array()
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newSortExpressionDeserializer()->deserialize( $notASortExpression );
	}

	/**
	 * @dataProvider propertyExpressionWithMissingAttributeProvider
	 */
	public function testPropertyExpressionRequiresAllAttributes( array $invalidValue ) {
		$invalidExpression = array(
			'objectType' => 'sortExpression',
			'sortExpressionType' => 'propertyValue',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newSortExpressionDeserializer()->deserialize( $invalidExpression );
	}

	public function propertyExpressionWithMissingAttributeProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array( array(
		) );

		$argLists[] = array( array(
			'property' => $p1337->toArray(),
		) );

		$argLists[] = array( array(
			'direction' => SortExpression::DIRECTION_ASCENDING,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider propertyExpressionWithInvalidAttributeProvider
	 */
	public function testValueDescriptionRequiresValidAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'sortExpression',
			'sortExpressionType' => 'propertyValue',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$this->newSortExpressionDeserializer()->deserialize( $invalidDescription );
	}

	public function propertyExpressionWithInvalidAttributeProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array( array(
			'property' => $p1337->toArray(),
			'direction' => 'hax',
		) );

		$argLists[] = array( array(
			'property' => null,
			'direction' => SortExpression::DIRECTION_DESCENDING,
		) );

		return $argLists;
	}

}
