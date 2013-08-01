<?php

namespace Ask\Tests\Phpunit\Language;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Option\QueryOptions;
use Ask\Language\Query;
use Ask\Language\Selection\PropertySelection;
use DataValues\StringValue;

/**
 * @covers Ask\Language\Query
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryTest extends \Ask\Tests\Phpunit\AskTestCase {

	public function descriptionProvider() {
		$descriptions = array();

		$descriptions[] = new AnyValue();
		$descriptions[] = new Conjunction( array() );
		$descriptions[] = new Disjunction( array() );

		return $this->arrayWrap( $descriptions );
	}

	/**
	 * @dataProvider descriptionProvider
	 *
	 * @param Description $description
	 */
	public function testGetDescriptions( Description $description ) {
		$query = new Query( $description, array(), new QueryOptions( 100, 0 ) );

		$obtainedDescription = $query->getDescription();

		$this->assertInstanceOf( '\Ask\Language\Description\Description', $obtainedDescription );

		$this->assertEquals( $description, $obtainedDescription );
	}

	public function selectionRequestsProvider() {
		$requestsLists = array();

		$requestsLists[] = array(
			new PropertySelection( new StringValue( 'q42' ) ),
			new PropertySelection( new StringValue( '_geo' ) ),
		);

		return $this->arrayWrap( $requestsLists );
	}

	/**
	 * @dataProvider selectionRequestsProvider
	 *
	 * @param array $selectionRequests
	 */
	public function testGetSelectionRequests( array $selectionRequests ) {
		$query = new Query( new AnyValue(), $selectionRequests, new QueryOptions( 100, 0 ) );

		$obtainedRequests = $query->getSelectionRequests();

		$this->assertInternalType( 'array', $obtainedRequests );
		$this->assertContainsOnlyInstancesOf( '\Ask\Language\Selection\SelectionRequest', $obtainedRequests );

		$this->assertEquals( $selectionRequests, $obtainedRequests );
	}

	public function instanceProvider() {
		$instances = array();

		$instances[] = new Query(
			new AnyValue(),
			array(
				new PropertySelection( new StringValue( 'q42' ) ),
				new PropertySelection( new StringValue( '_geo' ) ),
			),
			new QueryOptions( 100, 0 )
		);

		return $this->arrayWrap( $instances );
	}

}
