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
 * @since 1.0
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

		$this->assertFalse( $serializer->isSerializerFor( $notADescription ) );

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
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
