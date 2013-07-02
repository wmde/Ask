<?php

namespace Ask\Tests\Phpunit\Deserializers;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Description;
use Ask\Language\Description\SomeProperty;
use Ask\Deserializers\DescriptionDeserializer;
use DataTypes\DataTypeFactory;
use DataValues\DataValueFactory;
use DataValues\StringValue;

/**
 * @covers Ask\Deserializers\DescriptionDeserializer
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
class DescriptionDeserializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider nonDescriptionProvider
	 */
	public function testCannotSerializeNonDescriptions( $notADescription ) {
		$serializer = $this->newDescriptionDeserializer();

		$this->assertFalse( $serializer->canDeserialize( $notADescription ) );

		$this->setExpectedException( 'Ask\Deserializers\Exceptions\UnsupportedTypeException' );
		$serializer->deserialize( $notADescription );
	}

	protected function newDescriptionDeserializer() {
		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		return new DescriptionDeserializer( $dvFactory );
	}

	public function nonDescriptionProvider() {
		$argLists = array();

//		$argLists[] = array( null );
//		$argLists[] = array( array() );
//		$argLists[] = array( 'foo bar' );
//
//		$argLists[] = array( array(
//			'descriptionType' => 'anyValue',
//			'value' => null
//		) );

		$argLists[] = array( array(
			'objectType' => 'foobar',
			'descriptionType' => 'anyValue',
			'value' => null
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
				'value' => null
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
						'value' => null
					),
					'isSubProperty' => false
				),
			)
		);

		return $argLists;
	}

}
