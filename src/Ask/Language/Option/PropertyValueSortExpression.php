<?php

namespace Ask\Language\Option;

use DataValues\DataValue;
use InvalidArgumentException;

/**
 * A sort expression consisting out of a single PropertyValue.
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
class PropertyValueSortExpression extends SortExpression {

	/**
	 * The property value to sort by.
	 *
	 * @since 1.0
	 *
	 * @var DataValue
	 */
	protected $property;

	/**
	 * @since 1.0
	 *
	 * @param DataValue $propertyId
	 * @param string $direction One of the SortExpression::DIRECTION_ constants
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( DataValue $propertyId, $direction ) {
		$this->property = $propertyId;

		$this->assertIsDirection( $direction );

		$this->direction = $direction;
	}

	/**
	 * Returns the property value to sort by.
	 *
	 * @since 1.0
	 *
	 * @return DataValue
	 */
	public function getPropertyId() {
		return $this->property;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return SortExpression::PROPERTY_VALUE;
	}

}
