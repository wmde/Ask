<?php

namespace Ask\Tests\Phpunit\Language\Option;

use Ask\Language\Option\SortExpression;

/**
 * Base class for unit tests for the Ask\Language\Option\SortExpression deriving classes.
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class SortExpressionTest extends \Ask\Tests\Phpunit\AskTestCase {

	/**
	 * @since 1.0
	 *
	 * @return SortExpression[]
	 */
	protected abstract function getInstances();

	/**
	 * @since 1.0
	 *
	 * @return SortExpression[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SortExpression $expression
	 */
	public function testReturnValueOfGetDirection( SortExpression $expression ) {
		$direction = $expression->getDirection();

		$this->assertInternalType( 'string', $direction );
		$this->assertTrue(
			in_array( $direction, array( SortExpression::DIRECTION_ASCENDING, SortExpression::DIRECTION_DESCENDING ) ),
			'Sort direction is one of the known values'
		);
	}

}
