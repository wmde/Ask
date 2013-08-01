<?php

namespace Ask\Tests\Phpunit\Language\Option;

use Ask\Language\Option\PropertyValueSortExpression;
use Ask\Language\Option\SortExpression;
use Ask\Language\Option\SortOptions;
use Ask\Tests\Phpunit\AskTestCase;
use DataValues\StringValue;

/**
 * @covers Ask\Language\Option\SortOptions
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @group Ask
 * @group AskOption
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SortOptionsTest extends AskTestCase {

	/**
	 * @dataProvider sortExpressionListProvider
	 */
	public function testGetExpressions( array $expressions ) {
		$options = new SortOptions( $expressions );

		$this->assertEquals( $expressions, $options->getExpressions() );
	}

	public function sortExpressionListProvider() {
		$argLists = array();

		$argLists[] = array( array() );

		$argLists[] = array( array(
			new PropertyValueSortExpression(
				new StringValue( 'foo' ),
				SortExpression::DIRECTION_ASCENDING
			)
		) );

		$argLists[] = array( array(
			new PropertyValueSortExpression(
				new StringValue( 'foo' ),
				SortExpression::DIRECTION_ASCENDING
			),
			new PropertyValueSortExpression(
				new StringValue( 'bar' ),
				SortExpression::DIRECTION_DESCENDING
			),
		) );

		return $argLists;
	}

}
