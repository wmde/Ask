<?php

namespace Ask\Language\Option;

use InvalidArgumentException;

/**
 * A sort expression.
 *
 * @since 1.0
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