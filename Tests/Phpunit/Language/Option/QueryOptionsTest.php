<?php

namespace Ask\Tests\Phpunit\Language\Option;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortOptions;
use Ask\Tests\Phpunit\AskTestCase;

/**
 * @covers Ask\Language\Option\QueryOptions
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
class QueryOptionsTest extends AskTestCase {

	/**
	 * @since 1.0
	 *
	 * @return QueryOptions[]
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new QueryOptions(
			100,
			0
		);

		$instances[] = new QueryOptions(
			5,
			100
		);

		$instances[] = new QueryOptions(
			9000,
			42,
			new SortOptions( array() )
		);

		return $instances;
	}

	/**
	 * @since 1.0
	 *
	 * @return QueryOptions[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider constructorArgumentProvider
	 */
	public function testConstructSetsFields( $limit, $offset, SortOptions $sort ) {
		$queryOptions = new QueryOptions( $limit, $offset, $sort );

		$this->assertEquals( $limit, $queryOptions->getLimit() );
		$this->assertEquals( $offset, $queryOptions->getOffset() );
		$this->assertEquals( $sort, $queryOptions->getSort() );
	}

	public function constructorArgumentProvider() {
		$argLists = array();

		$argLists[] = array( 1, 2, new SortOptions( array() ) );

		$argLists[] = array( 100, 0, new SortOptions( array() ) );

		return $argLists;
	}

}
