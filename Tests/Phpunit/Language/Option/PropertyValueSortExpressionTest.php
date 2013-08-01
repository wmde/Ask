<?php

namespace Ask\Tests\Phpunit\Language\Option;

use Ask\Language\Option\PropertyValueSortExpression;
use Ask\Language\Option\SortExpression;
use DataValues\StringValue;

/**
 * @covers Ask\Language\Option\PropertyValueSortExpression
 * @covers Ask\Language\Option\SortExpression
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
class PropertyValueSortExpressionTest extends SortExpressionTest {

	public function testCanConstruct() {
		new PropertyValueSortExpression(
			new StringValue( 'foo' ),
			SortExpression::DIRECTION_ASCENDING
		);

		$this->assertTrue( true );
	}

	public function testGetPropertyId() {
		$propertyId = new StringValue( 'foo' );

		$sortExpression = new PropertyValueSortExpression(
			$propertyId,
			SortExpression::DIRECTION_ASCENDING
		);

		$this->assertEquals( $propertyId, $sortExpression->getPropertyId() );
	}

	/**
	 * @see SortExpressionTest::getInstances
	 *
	 * @since 1.0
	 *
	 * @return SortExpression[]
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new PropertyValueSortExpression(
			new StringValue( 'foo' ),
			SortExpression::DIRECTION_ASCENDING
		);

		$instances[] = new PropertyValueSortExpression(
			new StringValue( 'foo' ),
			SortExpression::DIRECTION_DESCENDING
		);

		return $instances;
	}

	/**
	 * @dataProvider invalidSortDirectionProvider
	 */
	public function testCannotConstructWithInvalidSortDirection( $invalidSortDirection ) {
		$this->setExpectedException( 'InvalidArgumentException' );

		new PropertyValueSortExpression(
			new StringValue( 'foo' ),
			$invalidSortDirection
		);
	}

	public function invalidSortDirectionProvider() {
		return array(
			array( null ),
			array( array() ),
			array( true ),
			array( 4.2 ),
			array( 'foo' ),
		);
	}

}
