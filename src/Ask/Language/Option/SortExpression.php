<?php

namespace Ask\Language\Option;

use InvalidArgumentException;

/**
 * A sort expression.
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
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class SortExpression implements \Ask\Immutable, \Ask\Typeable {

	const PROPERTY_VALUE = 'propertyValue';

	const DIRECTION_ASCENDING = 'asc';
	const DIRECTION_DESCENDING = 'desc';

	/**
	 * The sort direction.
	 * This is one of the SortExpression::DIRECTION_ constants.
	 *
	 * @var string|null
	 */
	protected $direction = null;

	/**
	 * Returns the sort direction.
	 * This is one of the SortExpression::DIRECTION_ constants.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getDirection() {
		assert( $this->direction !== null );
		return $this->direction;
	}

	protected function assertIsDirection( $direction ) {
		if ( !is_string( $direction ) || !in_array( $direction, array( self::DIRECTION_ASCENDING, self::DIRECTION_DESCENDING ) ) ) {
			throw new InvalidArgumentException( '$direction needs to be one of the direction constants' );
		}
	}

}