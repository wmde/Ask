<?php

namespace Ask\Tests\Integration\Serializers;

use Ask\Deserializers\DescriptionDeserializer;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Ask\Serializers\DescriptionSerializer;
use DataValues\DataValueFactory;
use DataValues\StringValue;

/**
 * @file
 * @since 0.1
 *
 * @ingroup Ask
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionRoundtripTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider descriptionProvider
	 */
	public function testCanRoundtripDescriptionThroughSerialization( Description $description ) {
		$dataValueFactory = new DataValueFactory();
		$dataValueFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		$serializer = new DescriptionSerializer();
		$deserializer = new DescriptionDeserializer( $dataValueFactory );

		$serialization = $serializer->serialize( $description );
		$deserialization = $deserializer->deserialize( $serialization );

		$this->assertEquals( $description, $deserialization );
	}

	public function descriptionProvider() {
		$descriptions = array();

		$descriptions[] = new AnyValue();

		$descriptions[] = new Conjunction( array() );

		$descriptions[] = new Conjunction( array( new AnyValue() ) );

		$p123 = new StringValue( 'p123' );
		$p1337 = new StringValue( 'p1337' );

		$descriptions[] = new Disjunction( array(
			new AnyValue(),
			new Conjunction( array(
				new SomeProperty(
					$p123,
					new ValueDescription( $p1337 )
				),
				new ValueDescription( $p1337, ValueDescription::COMP_NLIKE )
			) ),
			new SomeProperty( $p1337, new AnyValue() ),
			new Disjunction( array() )
		) );

		$argLists = array();

		foreach ( $descriptions as $description ) {
			$argLists[] = array( $description );
		}

		return $argLists;
	}

}
