<?php

namespace Ask\Tests\Integration\Serialization;

use Ask\DeserializerFactory;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Ask\Language\Option\PropertyValueSortExpression;
use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortExpression;
use Ask\Language\Option\SortOptions;
use Ask\Language\Query;
use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SubjectSelection;
use Ask\SerializerFactory;
use DataValues\DataValueFactory;
use DataValues\StringValue;

/**
 * @file
 * @since 1.0
 *
 * @ingroup Ask
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryRoundtripTest extends \PHPUnit_Framework_TestCase {

	protected function newQueryDeserializer() {
		$dvFactory = new DataValueFactory();
		$dvFactory->registerDataValue( 'string', 'DataValues\StringValue' );

		$deserializerFactory = new DeserializerFactory( $dvFactory );

		return $deserializerFactory->newQueryDeserializer();
	}

	protected function newQuerySerializer() {
		$serializerFactory = new SerializerFactory();
		return $serializerFactory->newQuerySerializer();
	}

	/**
	 * @dataProvider queryProvider
	 * @param Query $query
	 */
	public function testCanRoundtripQueryThroughSerialization( Query $query ) {
		$serialization = $this->newQuerySerializer()->serialize( $query );
		$deserialization = $this->newQueryDeserializer()->deserialize( $serialization );

		$this->assertEquals( $query, $deserialization );
	}

	public function queryProvider() {
		$p42 = new StringValue( 'p42' );
		$p9001 = new StringValue( 'p9001' );
		$foo = new StringValue( 'foo' );

		$argLists = array();

		$argLists[] = array( new Query(
			new AnyValue(),
			array(
			),
			new QueryOptions(
				10,
				0
			)
		) );

		$argLists[] = array( new Query(
			new Conjunction( array(
				new SomeProperty( $p42, new AnyValue() ),
				new SomeProperty( $p9001, new ValueDescription( $foo ) ),
			) ),
			array(
				new SubjectSelection(),
				new PropertySelection( $p42 ),
				new PropertySelection( $p9001 ),
			),
			new QueryOptions(
				100,
				42,
				new SortOptions( array(
					new PropertyValueSortExpression( $p42, SortExpression::DIRECTION_ASCENDING )
				) )
			)
		) );

		return $argLists;
	}

}
