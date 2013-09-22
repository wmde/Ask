<?php

namespace Ask\Tests\Phpunit\Deserializers;

use Ask\Deserializers\DescriptionDeserializer;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Description;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use DataTypes\DataTypeFactory;
use DataValues\DataValueFactory;
use DataValues\StringValue;

/**
 * @covers Ask\Deserializers\DescriptionDeserializer
 * @covers Ask\Deserializers\Strategies\DescriptionDeserializationStrategy
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
class DescriptionDeserializerTest extends \PHPUnit_Framework_TestCase {

	protected function newDescriptionDeserializer() {
		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		return new DescriptionDeserializer( $dvFactory );
	}

	/**
	 * @dataProvider invalidObjectTypeProvider
	 */
	public function testCannotDeserializeWithInvalidObjectType( $notADescription ) {
		$serializer = $this->newDescriptionDeserializer();

		$this->assertFalse( $serializer->isDeserializerFor( $notADescription ) );

		$this->setExpectedException( 'Deserializers\Exceptions\UnsupportedTypeException' );
		$serializer->deserialize( $notADescription );
	}

	public function invalidObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'objectType' => 'foobar',
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 'DESCRIPTION',
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => null,
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => array(),
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'objectType' => 42,
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		return $argLists;
	}

	/**
	 * @dataProvider missingObjectTypeProvider
	 */
	public function testCannotDeserilaizeWithoutObjectType( $notADescription ) {
		$serializer = $this->newDescriptionDeserializer();

		$this->assertFalse( $serializer->isDeserializerFor( $notADescription ) );

		$this->setExpectedException( 'Deserializers\Exceptions\MissingTypeException' );
		$serializer->deserialize( $notADescription );
	}

	public function missingObjectTypeProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( array() );
		$argLists[] = array( 'foo bar' );

		$argLists[] = array( array(
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'ObjectType' => 'description',
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		$argLists[] = array( array(
			'OBJECTTYPE' => 'description',
			'descriptionType' => 'anyValue',
			'value' => array()
		) );

		return $argLists;
	}

	public function testCannotDeserilaizeWithUnknownDescriptionType() {
		$notADescription = array(
			'objectType' => 'description',
			'descriptionType' => 'fooBar',
			'value' => array()
		);

		$this->setExpectedException( 'Deserializers\Exceptions\InvalidAttributeException' );
		$this->newDescriptionDeserializer()->deserialize( $notADescription );
	}

	public function testCannotDeserilaizeWithoutDescriptionType() {
		$notADescription = array(
			'objectType' => 'description',
			'value' => array()
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newDescriptionDeserializer()->deserialize( $notADescription );
	}

	/**
	 * @dataProvider somePropertyWithMissingAttributeProvider
	 */
	public function testSomePropertyRequiresAllAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'description',
			'descriptionType' => 'someProperty',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newDescriptionDeserializer()->deserialize( $invalidDescription );
	}

	public function somePropertyWithMissingAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
		) );

		$argLists[] = array( array(
			'property' => 'foo',
			'isSubProperty' => true,
		) );

		$argLists[] = array( array(
			'property' => 'foo',
			'description' => array(),
		) );

		$argLists[] = array( array(
			'description' => array(),
			'isSubProperty' => true,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider somePropertyWithInvalidAttributeProvider
	 */
	public function testSomePropertyRequiresValidAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'description',
			'descriptionType' => 'someProperty',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$this->newDescriptionDeserializer()->deserialize( $invalidDescription );
	}

	public function somePropertyWithInvalidAttributeProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array( array(
			'property' => $p1337->toArray(),
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'isSubProperty' => 42,
		) );

		$argLists[] = array( array(
			'property' => null,
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'isSubProperty' => true,
		) );

		$argLists[] = array( array(
			'property' => array( 'foo' => 'bar' ),
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			),
			'isSubProperty' => true,
		) );

		$argLists[] = array( array(
			'property' => $p1337->toArray(),
			'description' => array(
			),
			'isSubProperty' => true,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider valueDescriptionWithMissingAttributeProvider
	 */
	public function testValueDescriptionRequiresAllAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'description',
			'descriptionType' => 'valueDescription',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newDescriptionDeserializer()->deserialize( $invalidDescription );
	}

	public function valueDescriptionWithMissingAttributeProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array( array(
		) );

		$argLists[] = array( array(
			'value' => $p1337->toArray(),
		) );

		$argLists[] = array( array(
			'comparator' => ValueDescription::COMP_EQUAL,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider valueDescriptionWithInvalidAttributeProvider
	 */
	public function testValueDescriptionRequiresValidAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'description',
			'descriptionType' => 'valueDescription',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$this->newDescriptionDeserializer()->deserialize( $invalidDescription );
	}

	public function valueDescriptionWithInvalidAttributeProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array( array(
			'value' => $p1337->toArray(),
			'comparator' => 'hax',
		) );

		$argLists[] = array( array(
			'value' => null,
			'comparator' => ValueDescription::COMP_EQUAL,
		) );

		$argLists[] = array( array(
			'value' => array(),
			'comparator' => ValueDescription::COMP_EQUAL,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider conjunctionWithMissingAttributeProvider
	 */
	public function testConjunctionRequiresAllAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'description',
			'descriptionType' => 'conjunction',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\MissingAttributeException' );
		$this->newDescriptionDeserializer()->deserialize( $invalidDescription );
	}

	public function conjunctionWithMissingAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
		) );

		return $argLists;
	}

	/**
	 * @dataProvider conjunctionWithInvalidAttributeProvider
	 */
	public function testConjunctionRequiresValidAttributes( array $invalidValue ) {
		$invalidDescription = array(
			'objectType' => 'description',
			'descriptionType' => 'conjunction',
			'value' => $invalidValue,
		);

		$this->setExpectedException( 'Deserializers\Exceptions\DeserializationException' );
		$this->newDescriptionDeserializer()->deserialize( $invalidDescription );
	}

	public function conjunctionWithInvalidAttributeProvider() {
		$argLists = array();

		$argLists[] = array( array(
			'descriptions' => null,
		) );

		$argLists[] = array( array(
			'descriptions' => array( null ),
		) );

		$argLists[] = array( array(
			'descriptions' => array( 42 ),
		) );

		$argLists[] = array( array(
			'descriptions' => 42,
		) );

		return $argLists;
	}

	/**
	 * @dataProvider descriptionProvider
	 */
	public function testSerializeDescription( Description $expectedDescription, $serialization ) {
		$actualDescription = $this->newDescriptionDeserializer()->deserialize( $serialization );

		$this->assertEquals( $expectedDescription, $actualDescription );
	}

	public function descriptionProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array(
			new AnyValue(
			),
			array(
				'objectType' => 'description',
				'descriptionType' => 'anyValue',
				'value' => array()
			)
		);

		$argLists[] = array(
			new SomeProperty(
				$p1337,
				new AnyValue()
			),
			array(
				'objectType' => 'description',
				'descriptionType' => 'someProperty',
				'value' => array(
					'property' => $p1337->toArray(),
					'description' => array(
						'objectType' => 'description',
						'descriptionType' => 'anyValue',
						'value' => array()
					),
					'isSubProperty' => false
				),
			)
		);

		return $argLists;
	}

}
