<?php

namespace Ask\Tests\Language\Description;
use Ask\Language\Description\Disjunction;

/**
 * Unit tests for the Ask\Language\Description\Union class.
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
 * @group AskDescription
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DisjunctionTest extends DescriptionTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new Disjunction( array() );
		$instances[] = new Disjunction( array( new \Ask\Language\Description\Conjunction( array() ) ) );
		$instances[] = new Disjunction( array( new Disjunction( array() ), new Disjunction( array() ) ) );
		$instances[] = new Disjunction( array( new \Ask\Language\Description\AnyValue() ) );
		$instances[] = new Disjunction( array( new \Ask\Language\Description\ValueDescription( new \DataValues\StringValue( 'ohi' ) ) ) );

		return $instances;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param Disjunction $description
	 */
	public function testGetDescriptions( Disjunction $description ) {
		$descriptions = $description->getDescriptions();

		$this->assertInternalType( 'array', $descriptions );

		foreach ( $descriptions as $subInstance ) {
			$this->assertInstanceOf( 'Ask\Language\Description\Description', $subInstance );
		}

		$newInstance = new Disjunction( $descriptions );

		$this->assertEquals( $descriptions, $newInstance->getDescriptions(), 'Descriptions are returned as it was passed to the constructor' );
	}

}
