<?php

namespace Ask\Tests\Phpunit\Serializers;

use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SelectionRequest;
use Ask\Language\Selection\SubjectSelection;
use Ask\Serializers\SelectionRequestSerializer;
use DataValues\StringValue;

/**
 * @covers Ask\Serializers\SelectionRequestSerializer
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
class SelectionRequestSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testConstructWithNoSerializers() {
		$serializer = new SelectionRequestSerializer();

		$this->assertFalse( $serializer->canSerialize( 'foo' ) );
		$this->assertFalse( $serializer->canSerialize( null ) );

		$this->setExpectedException( 'Ask\Serializers\Exceptions\UnsupportedObjectException' );

		$serializer->serialize( 'foo' );
	}

	/**
	 * @dataProvider selectionRequestProvider
	 */
	public function testSerializeQueryOptions( SelectionRequest $options, $expectedSerialization ) {
		$serializer = new SelectionRequestSerializer();
		$actualSerialization = $serializer->serialize( $options );

		$this->assertEquals( $expectedSerialization, $actualSerialization );
	}

	public function selectionRequestProvider() {
		$argLists = array();

		$argLists[] = array(
			new SubjectSelection(),
			array(
				'objectType' => 'selectionRequest',
				'selectionType' => 'subject',
				'value' => null,
			)
		);

		$stringValue = new StringValue( 'foo' );

		$argLists[] = array(
			new PropertySelection( $stringValue ),
			array(
				'objectType' => 'selectionRequest',
				'selectionType' => 'property',
				'value' => array(
					'property' => $stringValue->toArray(),
				),
			)
		);

		return $argLists;
	}

}
