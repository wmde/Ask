<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\ValueDescription;

/**
 * @covers Ask\Language\Description\ValueDescription
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
class ValueDescriptionTest extends DescriptionTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$values = array(
			new \DataValues\StringValue( 'ohi there' ),
			new \DataValues\NumberValue( 4.2 ),
			new \DataValues\MonolingualTextValue( 'en', 'ohi there' ),
		);

		$comparators = array(
			ValueDescription::COMP_EQUAL,
			ValueDescription::COMP_LEQ,
			ValueDescription::COMP_GEQ,
			ValueDescription::COMP_NEQ,
			ValueDescription::COMP_LIKE,
			ValueDescription::COMP_NLIKE,
			ValueDescription::COMP_LESS,
			ValueDescription::COMP_GRTR,
		);

		foreach ( $values as $value ) {
			foreach ( $comparators as $comparator ) {
				$instances[] = new ValueDescription( $value, $comparator );
			}
		}

		return $instances;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param ValueDescription $description
	 */
	public function testGetValue( ValueDescription $description ) {
		$value = $description->getValue();

		$this->assertInstanceOf( 'DataValues\DataValue', $value );

		$newInstance = new ValueDescription( $value );

		$this->assertTrue( $value->equals( $newInstance->getValue() ), 'Value is returned as it was passed to the constructor' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param ValueDescription $description
	 */
	public function testGetComparator( ValueDescription $description ) {
		$comparator = $description->getComparator();

		$this->assertInternalType( 'integer', $comparator );

		$newInstance = new ValueDescription( $description->getValue(), $comparator );

		$this->assertEquals( $comparator, $newInstance->getComparator(), 'Comparator is returned as it was passed to the constructor' );
	}

}
