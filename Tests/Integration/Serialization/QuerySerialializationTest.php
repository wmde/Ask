<?php

namespace Ask\Tests\Integration\Serialization;

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
class QuerySerializationTest extends \PHPUnit_Framework_TestCase {

	public function testSerializeQuery() {
		$p42 = new StringValue( 'p42' );
		$p9001 = new StringValue( 'p9001' );
		$foo = new StringValue( 'foo' );

		$query = $this->getQueryToSerialize( $p42, $p9001, $foo );
		$expectedSerialization = $this->getExpectedSerialization( $p42, $p9001, $foo );

		$querySerialization = $this->getQuerySerializer()->serialize( $query );

		$this->assertEquals(
			$expectedSerialization,
			$querySerialization
		);
	}

	protected function getQueryToSerialize( StringValue $p42, StringValue $p9001, StringValue $foo ) {
		$description = new Conjunction( array(
			new SomeProperty( $p42, new AnyValue() ),
			new SomeProperty( $p9001, new ValueDescription( $foo ) ),
		) );

		$selectionRequests = array(
			new SubjectSelection(),
			new PropertySelection( $p42 ),
			new PropertySelection( $p9001 ),
		);

		$queryOptions = new QueryOptions(
			100,
			42,
			new SortOptions( array(
				new PropertyValueSortExpression( $p42, SortExpression::DIRECTION_ASCENDING )
			) )
		);

		return new Query( $description, $selectionRequests, $queryOptions );
	}

	protected function getExpectedSerialization( StringValue $p42, StringValue $p9001, StringValue $foo ) {
		return array(
			'objectType' => 'query',
			'description' => array(
				'objectType' => 'description',
				'descriptionType' => 'conjunction',
				'value' => array(
					'descriptions' => array(
						array(
							'objectType' => 'description',
							'descriptionType' => 'someProperty',
							'value' => array(
								'property' => $p42->toArray(),
								'description' => array(
									'objectType' => 'description',
									'descriptionType' => 'anyValue',
									'value' => array()
								),
								'isSubProperty' => false
							),
						),
						array(
							'objectType' => 'description',
							'descriptionType' => 'someProperty',
							'value' => array(
								'property' => $p9001->toArray(),
								'description' => array(
									'objectType' => 'description',
									'descriptionType' => 'valueDescription',
									'value' => array(
										'value' => $foo->toArray(),
										'comparator' => 'equal'
									)
								),
								'isSubProperty' => false
							),
						)
					)
				)
			),
			'options' => array(
				'objectType' => 'queryOptions',
				'limit' => 100,
				'offset' => 42,
				'sort' => array(
					'expressions' => array(
						array(
							'objectType' => 'sortExpression',
							'sortExpressionType' => 'propertyValue',
							'value' => array(
								'direction' => SortExpression::DIRECTION_ASCENDING, // TODO: this should be a string
								'property' => $p42->toArray(),
							)
						)
					),
				),
			),
			'selectionRequests' => array(
				array(
					'objectType' => 'selectionRequest',
					'selectionRequestType' => 'subject',
					'value' => array(),
				),
				array(
					'objectType' => 'selectionRequest',
					'selectionRequestType' => 'property',
					'value' => array(
						'property' => $p42->toArray(),
					),
				),
				array(
					'objectType' => 'selectionRequest',
					'selectionRequestType' => 'property',
					'value' => array(
						'property' => $p9001->toArray(),
					),
				)
			),
		);
	}

	protected function getQuerySerializer() {
		$askFactory = new SerializerFactory();
		return $askFactory->newQuerySerializer();
	}

}
