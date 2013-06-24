<?php

namespace Ask\Tests\Phpunit\Serializers;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Description;
use Ask\Language\Description\SomeProperty;
use Ask\Serializers\DescriptionSerializer;
use DataValues\StringValue;

/**
 * @covers Ask\Serializers\DescriptionSerializer
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
class DescriptionSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider nonDescriptionProvider
	 */
	public function testCannotSerializeNonDescriptions( $notADescription ) {
		$serializer = new DescriptionSerializer();

		$this->assertFalse( $serializer->canSerialize( $notADescription ) );

		$this->setExpectedException( 'Ask\Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( $notADescription );
	}

	public function nonDescriptionProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( 'foo bar' );
		$argLists[] = array( new \stdClass() );
		$argLists[] = array( array() );
		$argLists[] = array( 42 );

		return $argLists;
	}

	/**
	 * @dataProvider descriptionProvider
	 */
	public function testSerializeDescription( Description $description, $expectedSerialization ) {
		$serializer = new DescriptionSerializer();
		$actualSerialization = $serializer->serialize( $description );

		$this->assertEquals( $expectedSerialization, $actualSerialization );
	}

	public function descriptionProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array(
			new AnyValue(
			),
			array(
				'type' => 'anyvalue',
				'value' => null
			)
		);

		$argLists[] = array(
			new SomeProperty(
				$p1337,
				new AnyValue()
			),
			array(
				'type' => 'someproperty',
				'value' => array(
					'property' => $p1337->toArray(),
					'description' => array(
						'type' => 'anyvalue',
						'value' => null
					),
					'issubproperty' => false
				),
			)
		);

		return $argLists;
	}

}