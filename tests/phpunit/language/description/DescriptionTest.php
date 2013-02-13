<?php

namespace Ask\Tests\Language\Description;
use Ask\Language\Description\Description;

/**
 * Base class for unit tests for the Ask\Language\Description\Description implementing classes.
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
abstract class DescriptionTest extends \Ask\Tests\AskTestCase {

	/**
	 * @since 0.1
	 *
	 * @return Description[]
	 */
	protected abstract function getInstances();

	/**
	 * @since 0.1
	 *
	 * @return Description[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param Description $description
	 */
	public function testReturnTypeOfGetSize( Description $description ) {
		$size = $description->getSize();

		$this->assertInternalType( 'integer', $size );
		$this->assertGreaterThanOrEqual( 0, $size );
		$this->assertEquals( $size, $description->getSize() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param Description $description
	 */
	public function testReturnTypeOfGetDepth( Description $description ) {
		$depth = $description->getDepth();

		$this->assertInternalType( 'integer', $depth );
		$this->assertGreaterThanOrEqual( 0, $depth );
		$this->assertEquals( $depth, $description->getDepth() );
	}

}