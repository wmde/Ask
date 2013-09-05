<?php

namespace Ask\Tests\Phpunit\Serializers;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortExpression;
use Ask\Serializers\QueryOptionsSerializer;
use Ask\Serializers\SortExpressionSerializer;

/**
 * @covers Ask\Serializers\QueryOptionsSerializer
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
class QueryOptionsSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider queryOptionsProvider
	 */
	public function testSerializeQueryOptions( QueryOptions $options ) {
		$sortExpressionSerializer = new SortExpressionSerializer();
		$serializer = new QueryOptionsSerializer( $sortExpressionSerializer );
		$actualSerialization = $serializer->serialize( $options );

		$expectedSerialization = array(
			'objectType' => 'queryOptions',
			'limit' => $options->getLimit(),
			'offset' => $options->getOffset(),
			'sort' => array(
				'expressions' => array_map(
					function( SortExpression $expression ) use ( $sortExpressionSerializer ) {
						return $sortExpressionSerializer->serialize( $expression );
					},
					$options->getSort()->getExpressions()
				)
			)
		);

		$this->assertEquals( $expectedSerialization, $actualSerialization );
	}

	public function queryOptionsProvider() {
		$argLists = array();

		$argLists[] = array( new QueryOptions( 4, 2 ) );
		$argLists[] = array( new QueryOptions( 100, 0 ) );
		$argLists[] = array( new QueryOptions( 42, 42 ) );

		return $argLists;
	}

	/**
	 * @dataProvider nonDescriptionProvider
	 */
	public function testCannotSerializeNonDescriptions( $notSerializable ) {
		$serializer = $this->newQueryOptionsSerializer();

		$this->assertFalse( $serializer->isSerializerFor( $notSerializable ) );

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( $notSerializable );
	}

	protected function newQueryOptionsSerializer() {
		$sortExpressionSerializer = new SortExpressionSerializer();
		return new QueryOptionsSerializer( $sortExpressionSerializer );
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

}
