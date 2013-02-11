<?php

namespace Ask\Tests\Language\PrintRequest;
use Ask\Language\PrintRequest\PrintRequest;

/**
 * Base class for unit tests for the Ask\Language\PrintRequest\PrintRequest implementing classes.
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
abstract class PrintRequestTest extends \Ask\Tests\AskTestCase {

	/**
	 * @since 0.1
	 *
	 * @return PrintRequest[]
	 */
	protected abstract function getInstances();

	/**
	 * @since 0.1
	 *
	 * @return PrintRequest[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param PrintRequest $request
	 */
	public function testReturnTypeOfGetLabel( PrintRequest $request ) {
		$labels = $request->getLabels();

		$this->assertInternalType( 'array', $labels );
		$this->assertContainsOnly( 'string', $labels );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param PrintRequest $request
	 */
	public function testReturnTypeOfGetType( PrintRequest $request ) {
		$this->assertInternalType( 'integer', $request->getType() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param PrintRequest $request
	 */
	public function testReturnTypeOfGetOptions( PrintRequest $request ) {
		$options = $request->getOptions();

		$this->assertInternalType( 'array', $options );
		$this->assertContainsOnly( 'string', $options );
	}

}
