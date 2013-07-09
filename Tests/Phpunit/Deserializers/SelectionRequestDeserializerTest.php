<?php

namespace Ask\Tests\Phpunit\Deserializers;

use Ask\Deserializers\SelectionRequestDeserializer;
use DataValues\DataValueFactory;

/**
 * @covers Ask\Deserializers\SelectionRequestDeserializer
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
class SelectionRequestDeserializerTest extends \PHPUnit_Framework_TestCase {

	protected function newSelectionRequestDeserializer() {
		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		return new SelectionRequestDeserializer( $dvFactory );
	}

	/**
	 * @dataProvider invalidObjectTypeProvider
	 */
	public function testCannotDeserializeWithInvalidObjectType( $notASelectionRequest ) {
		$serializer = $this->newSelectionRequestDeserializer();

		$this->assertFalse( $serializer->canDeserialize( $notASelectionRequest ) );

		$this->setExpectedException( 'Deserializers\Exceptions\UnsupportedTypeException' );
		$serializer->deserialize( $notASelectionRequest );
	}

	public function invalidObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'foobar',
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 'DESCRIPTION',
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => null,
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => array(),
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 42,
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		return $argLists;
	}

	/**
	 * @dataProvider missingObjectTypeProvider
	 */
	public function testCannotDeserilaizeWithoutObjectType( $notASelectionRequest ) {
		$serializer = $this->newSelectionRequestDeserializer();

		$this->assertFalse( $serializer->canDeserialize( $notASelectionRequest ) );

		$this->setExpectedException( 'Deserializers\Exceptions\MissingTypeException' );
		$serializer->deserialize( $notASelectionRequest );
	}

	public function missingObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( array() );
		$argLists[] = array( 'foo bar' );

		$argLists[] = array( array(
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		$argLists[] = array( array(
			'ObjectType' => 'sortExpression',
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		$argLists[] = array( array(
			'OBJECTTYPE' => 'sortExpression',
			'selectionRequestType' => 'property',
			'value' => array()
		) );

		return $argLists;
	}

	public function testCannotDeserilaizeWithUnknownDescriptionType() {
		$notASelectionRequest = array(
			'objectType' => 'selectionRequest',
			'selectionRequestType' => 'fooBar',
			'value' => array()
		);

		$this->setExpectedException( 'Deserializers\Exceptions\InvalidAttributeException' );
		$this->newSelectionRequestDeserializer()->deserialize( $notASelectionRequest );
	}

	public function testCannotDeserilaizeWithoutDescriptionType() {
		$notASortExpression = array(
			'objectType' => 'selectionRequest',
			'value' => array()
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newSelectionRequestDeserializer()->deserialize( $notASortExpression );
	}

	/**
	 * @dataProvider propertySelectionWithMissingAttributeProvider
	 */
	public function testPropertySelectionRequiresAllAttributes( array $invalidValue ) {
		$invalidSelectionRequest = $this->newPropertySelectionSerializationFromValue( $invalidValue );
		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newSelectionRequestDeserializer()->deserialize( $invalidSelectionRequest );
	}

	protected function newPropertySelectionSerializationFromValue( $value ) {
		return array(
			'objectType' => 'selectionRequest',
			'selectionRequestType' => 'property',
			'value' => $value,
		);
	}

	public function propertySelectionWithMissingAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
		) );

		return $argLists;
	}

	/**
	 * @dataProvider propertySelectionWithInvalidAttributeProvider
	 */
	public function testPropertySelectionRequiresValidAttributes( array $invalidValue ) {
		$invalidSelectionRequest = $this->newPropertySelectionSerializationFromValue( $invalidValue );
		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$this->newSelectionRequestDeserializer()->deserialize( $invalidSelectionRequest );
	}

	public function propertySelectionWithInvalidAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'property' => array(),
		) );

		$argLists[] = array( array(
			'property' => null,
		) );

		$argLists[] = array( array(
			'property' => 42,
		) );

		$argLists[] = array( array(
			'property' => array( 42 ),
		) );

		return $argLists;
	}

}
