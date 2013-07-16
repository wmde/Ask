<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\SomeProperty;
use DataValues\StringValue;

/**
 * @covers Ask\Language\Description\SomeProperty
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
 * @since 1.0
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

		$instances[] = new SomeProperty( new StringValue( '_geo' ), new AnyValue() );
		$instances[] = new SomeProperty( new StringValue( 'p42' ), new Conjunction( array() ) );
		$instances[] = new SomeProperty( new StringValue( 'foo' ), new AnyValue(), true );
		$instances[] = new SomeProperty( new StringValue( '~=[,,_,,]:3' ), new AnyValue(), false );

		return $instances;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SomeProperty $description
	 */
	public function testGetDescription( SomeProperty $description ) {
		$subDescription = $description->getSubDescription();

		$this->assertInstanceOf( 'Ask\Language\Description\Description', $subDescription );

		$newInstance = new SomeProperty( $description->getPropertyId(), $subDescription );

		$this->assertEquals(
			$subDescription,
			$newInstance->getSubDescription(),
			'Description is returned as it was passed to the constructor'
		);
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SomeProperty $description
	 */
	public function testGetProperty( SomeProperty $description ) {
		$property = $description->getPropertyId();

		$this->assertInstanceOf( '\DataValues\DataValue', $property );

		$newInstance = new SomeProperty( $property, $description->getSubDescription() );

		$this->assertEquals(
			$property,
			$newInstance->getPropertyId(),
			'Property is returned as it was passed to the constructor'
		);
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param SomeProperty $description
	 */
	public function testIsSubProperty( SomeProperty $description ) {
		$isSubProperty = $description->isSubProperty();

		$this->assertInternalType( 'boolean', $isSubProperty );

		$newInstance = new SomeProperty( $description->getPropertyId(), $description->getSubDescription(), $isSubProperty );

		$this->assertEquals(
			$isSubProperty,
			$newInstance->isSubProperty(),
			'Is sub property is returned as it was passed to the constructor'
		);
	}

}
