<?php

namespace Ask\Tests\Language\Description;
use Ask\Language\Description\SomeProperty;
use DataValues\PropertyValue;

/**
 * Unit tests for the Ask\Language\Description\SomeProperty class.
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
class SomePropertyTest extends DescriptionTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new SomeProperty( new PropertyValue( '_geo' ), new \Ask\Language\Description\AnyValue() );
		$instances[] = new SomeProperty( new PropertyValue( 'p42' ), new \Ask\Language\Description\Conjunction( array() ) );

		return $instances;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SomeProperty $description
	 */
	public function testGetDescription( SomeProperty $description ) {
		$subDescription = $description->getDescription();

		$this->assertInstanceOf( 'Ask\Language\Description\Description', $subDescription );

		$newInstance = new SomeProperty( $description->getProperty(), $subDescription );

		$this->assertEquals( $subDescription, $newInstance->getDescription(), 'Description is returned as it was passed to the constructor' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param SomeProperty $description
	 */
	public function testGetProperty( SomeProperty $description ) {
		$property = $description->getProperty();

		$this->assertInstanceOf( '\DataValues\PropertyValue', $property );

		$newInstance = new SomeProperty( $property, $description->getDescription() );

		$this->assertEquals( $property, $newInstance->getProperty(), 'Property is returned as it was passed to the constructor' );
	}

}
