<?php

namespace Ask\Tests\Phpunit\Language;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Query;

/**
 * Unit tests for the Ask\Language\Query class.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
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

		$descriptions[] = new \Ask\Language\Description\AnyValue();
		$descriptions[] = new \Ask\Language\Description\Conjunction( array() );
		$descriptions[] = new \Ask\Language\Description\Disjunction( array() );

		return $this->arrayWrap( $descriptions );
	}

	/**
	 * @dataProvider descriptionProvider
	 *
	 * @param \Ask\Language\Description\Description $description
	 */
	public function testGetDescriptions( \Ask\Language\Description\Description $description ) {
		$query = new Query( $description, array(), new QueryOptions( 100, 0 ) );

		$obtainedDescription = $query->getDescription();

		$this->assertInstanceOf( '\Ask\Language\Description\Description', $obtainedDescription );

		$this->assertEquals( $description, $obtainedDescription );
	}

	public function selectionRequestsProvider() {
		$requestsLists = array();

		$requestsLists[] = array(
			new \Ask\Language\Selection\PropertySelection( new \DataValues\PropertyValue( 'q42' ) ),
			new \Ask\Language\Selection\PropertySelection( new \DataValues\PropertyValue( '_geo' ) ),
		);

		return $this->arrayWrap( $requestsLists );
	}

	/**
	 * @dataProvider selectionRequestsProvider
	 *
	 * @param array $selectionRequests
	 */
	public function testGetSelectionRequests( array $selectionRequests ) {
		$query = new Query( new \Ask\Language\Description\AnyValue(), $selectionRequests, new QueryOptions( 100, 0 ) );

		$obtainedRequests = $query->getSelectionRequests();

		$this->assertInternalType( 'array', $obtainedRequests );
		$this->assertContainsOnlyInstancesOf( '\Ask\Language\Selection\SelectionRequest', $obtainedRequests );

		$this->assertEquals( $selectionRequests, $obtainedRequests );
	}

	public function instanceProvider() {
		$instances = array();

		$instances[] = new Query(
			new \Ask\Language\Description\AnyValue(),
			array(
				new \Ask\Language\Selection\PropertySelection( new \DataValues\PropertyValue( 'q42' ) ),
				new \Ask\Language\Selection\PropertySelection( new \DataValues\PropertyValue( '_geo' ) ),
			),
			new QueryOptions( 100, 0 )
		);

		return $this->arrayWrap( $instances );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param Query $object
	 */
	public function testReturnTypeOfGetArrayValue( Query $object ) {
		$array = $object->getArrayValue();
		$this->assertPrimitiveStructure( $array );
	}

}
