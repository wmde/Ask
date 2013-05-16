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
 * @since 0.1
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
	 * @since 0.1
	 *
	 * @var DataValue
	 */
	protected $property;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 *
	 * @param DataValue $propertyId
	 * @param string $direction
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( DataValue $propertyId, $direction ) {
		$this->property = $propertyId;

		if ( !is_string( $direction ) ) {
			throw new InvalidArgumentException( '$direction needs to be one of the direction constants' );
		}

		$this->direction = $direction;
	}

	/**
	 * Returns the property value to sort by.
	 *
	 * @since 0.1
	 *
	 * @return DataValue
	 */
	public function getPropertyId() {
		return $this->property;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getType() {
		return SortExpression::PROPERTY_VALUE;
	}

	/**
	 * @see ArrayValueProvider::getArrayValue
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getArrayValue() {
		return array(
			'property' => $this->property->toArray(),
		);
	}

}
