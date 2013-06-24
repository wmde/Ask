<?php

namespace Ask\Tests\Integration\Serializers;

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
use Ask\Serializers\DispatchingSerializer;
use Ask\Serializers\DescriptionSerializer;
use Ask\Serializers\QueryOptionsSerializer;
use Ask\Serializers\QuerySerializer;
use Ask\Serializers\SelectionRequestSerializer;
use Ask\Serializers\SortExpressionSerializer;
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
				new PropertyValueSortExpression( $p42, SortExpression::ASCENDING )
			) )
		);

		return new Query( $description, $selectionRequests, $queryOptions );
	}

	protected function getExpectedSerialization( StringValue $p42, StringValue $p9001, StringValue $foo ) {
		return array(
			'description' => array(
				'type' => 'conjunction',
				'value' => array(
					'descriptions' => array(
						array(
							'type' => 'someproperty',
							'value' => array(
								'property' => $p42->toArray(),
								'description' => array(
									'type' => 'anyvalue',
									'value' => null
								),
								'issubproperty' => false
							),
						),
						array(
							'type' => 'someproperty',
							'value' => array(
								'property' => $p9001->toArray(),
								'description' => array(
									'type' => 'valuedescription',
									'value' => array(
										'value' => $foo->toArray(),
										'comparator' => 1
									)
								),
								'issubproperty' => false
							),
						)
					)
				)
			),
			'options' => array(
				'limit' => 100,
				'offset' => 42,
				'sort' => array(
					'expressions' => (object)array(
						array(
							'type' => 'PropertyValue',
							'value' => array(
								'property' => $p42->toArray(),
								'direction' => SortExpression::ASCENDING, // TODO: this should be a string
							)
						)
					),
				),
			),
			'selectionrequests' => (object)array(
				array(
					'type' => 'subject',
					'value' => null,
				),
				array(
					'type' => 'property',
					'value' => array(
						'property' => $p42->toArray(),
					),
				),
				array(
					'type' => 'property',
					'value' => array(
						'property' => $p9001->toArray(),
					),
				)
			),
		);
	}

	protected function getQuerySerializer() {
		$dispatchingSerializer = new DispatchingSerializer();

		$dispatchingSerializer->addSerializer( new DescriptionSerializer() );
		$dispatchingSerializer->addSerializer( new SelectionRequestSerializer() );
		$dispatchingSerializer->addSerializer( new QueryOptionsSerializer( $dispatchingSerializer ) );
		$dispatchingSerializer->addSerializer( new SortExpressionSerializer() );

		return new QuerySerializer( $dispatchingSerializer );
	}

}
