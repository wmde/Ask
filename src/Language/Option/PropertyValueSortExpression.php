<?php

namespace Ask\Language\Option;

use DataValues\DataValue;
use InvalidArgumentException;

/**
 * A sort expression consisting out of a single PropertyValue.
 *
 * @since 1.0
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
