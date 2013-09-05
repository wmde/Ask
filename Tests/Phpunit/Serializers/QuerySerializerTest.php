<?php

namespace Ask\Tests\Phpunit\Serializers;

use Ask\Language\Option\QueryOptions;
use Ask\Serializers\QuerySerializer;

/**
 * @covers Ask\Serializers\QuerySerializer
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
class QuerySerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerializeQuery() {
		$description = $this->getMock( 'Ask\Language\Description\Description' );

		$query = $this->getMockBuilder( 'Ask\Language\Query' )
			->disableOriginalConstructor()->getMock();

		$query->expects( $this->once() )
			->method( 'getDescription' )
			->will( $this->returnValue( $description ) );

		$query->expects( $this->once() )
			->method( 'getSelectionRequests' )
			->will( $this->returnValue( array() ) );

		$query->expects( $this->once() )
			->method( 'getOptions' )
			->will( $this->returnValue( new QueryOptions( 100, 0 ) ) );

		$dispatchingSerializer = $this->getMock( 'Serializers\Serializer' );

		$dispatchingSerializer->expects( $this->any() )
			->method( 'serialize' )
			->will( $this->returnValue( 'foo bar baz' ) );

		$serializer = new QuerySerializer( $dispatchingSerializer );
		$actualSerialization = $serializer->serialize( $query );

		$expectedSerialization = array(
			'objectType' => 'query',
			'description' => 'foo bar baz',
			'options' => 'foo bar baz',
			'selectionRequests' => array(),
		);

		$this->assertEquals( $expectedSerialization, $actualSerialization );
	}

	/**
	 * @dataProvider nonQueryProvider
	 */
	public function testCannotSerializeNonQueries( $notAQuery ) {
		$dispatchingSerializer = $this->getMock( 'Serializers\Serializer' );
		$serializer = new QuerySerializer( $dispatchingSerializer );

		$this->assertFalse( $serializer->isSerializerFor( $notAQuery ) );

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( $notAQuery );
	}

	public function nonQueryProvider() {
		$argLists = array();

		$argLists[] = array( null );
		$argLists[] = array( 'foo bar' );
		$argLists[] = array( new \stdClass() );
		$argLists[] = array( array() );
		$argLists[] = array( 42 );

		return $argLists;
	}

}
