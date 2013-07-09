<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\DescriptionCollection;
use Ask\Language\Description\ValueDescription;
use DataValues\NumberValue;
use DataValues\StringValue;

/**
 * Base class for unit tests for the Ask\Language\Description\DescriptionCollection deriving classes.
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
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class DescriptionCollectionTest extends DescriptionTest {

	public function descriptionsProvider() {
		$descriptionLists = array();

		$descriptionLists[] = array();

		$descriptionLists[] = array(
			new AnyValue(),
			new ValueDescription( new StringValue( 'nyan nyan' ) )
		);

		$descriptionList = array();
		$numbers = range( 0, 100 );
		shuffle( $numbers );

		foreach ( $numbers as $number ) {
			$descriptionList[] = new ValueDescription( new NumberValue( $number ) );
		}

		$descriptionLists[] = $descriptionList;

		return $this->arrayWrap( $descriptionLists );
	}

	/**
	 * @param Description[] $descriptions
	 *
	 * @return DescriptionCollection
	 */
	protected abstract function newFromDescriptions( array $descriptions );

	/**
	 * @dataProvider descriptionsProvider
	 *
	 * @param Description[] $descriptions
	 */
	public function testEqualsOrderInsensitivity( array $descriptions ) {
		$sameDescriptions = $descriptions;
		shuffle( $sameDescriptions );

		$description = $this->newFromDescriptions( $descriptions );
		$sameDescription = $this->newFromDescriptions( $sameDescriptions );

		$message = 'Two collection descriptions with same sub descriptions should be equal';

		$this->assertTrue( $description->equals( $sameDescription ), $message );
		$this->assertTrue( $sameDescription->equals( $description ), $message );
	}

	/**
	 * @dataProvider descriptionsProvider
	 *
	 * @param Description[] $descriptions
	 */
	public function testGetHashOrderInsensitivity( array $descriptions ) {
		$sameDescriptions = $descriptions;
		shuffle( $sameDescriptions );

		$description = $this->newFromDescriptions( $descriptions );
		$sameDescription = $this->newFromDescriptions( $sameDescriptions );

		$this->assertEquals( $description->getHash(), $sameDescription->getHash() );
	}

	/**
	 * @dataProvider descriptionsProvider
	 *
	 * @param Description[] $descriptions
	 */
	public function testDifferentSizeNotEquals( array $descriptions ) {
		$firstDescription = $this->newFromDescriptions( $descriptions );

		$descriptions[] = new AnyValue();

		$secondDescription = $this->newFromDescriptions( $descriptions );

		$this->assertFalse( $firstDescription->equals( $secondDescription ) );
	}

	public function testDifferentContainedDescriptionCausesInequality() {
		$firstDescription = $this->newFromDescriptions( array( new AnyValue() ) );
		$secondDescription = $this->newFromDescriptions( array( new Conjunction( array() ) ) );

		$this->assertFalse( $secondDescription->equals( $firstDescription ) );
	}

}
