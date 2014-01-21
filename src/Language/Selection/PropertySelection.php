<?php

namespace Ask\Language\Selection;

use DataValues\DataValue;

/**
 * Selection request specifying that the values for a property should be obtained.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class PropertySelection extends SelectionRequest implements \Ask\Immutable {

	/**
	 * The property for which to select values.
	 *
	 * @since 1.0
	 *
	 * @var DataValue
	 */
	protected $propertyId;

	/**
	 * @since 1.0
	 *
	 * @param DataValue $propertyId
	 */
	public function __construct( DataValue $propertyId ) {
		$this->propertyId = $propertyId;
	}

	/**
	 * @see Typeable::getType
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return SelectionRequest::TYPE_PROP;
	}

	/**
	 * Returns the print request's property.
	 *
	 * @since 1.0
	 *
	 * @return DataValue
	 */
	public function getPropertyId() {
		return $this->propertyId;
	}

	/**
	 * @see Comparable::equals
	 *
	 * @since 1.0
	 *
	 * @param mixed $mixed
	 *
	 * @return boolean
	 */
	public function equals( $mixed ) {
		return $mixed instanceof PropertySelection
			&& $this->propertyId->equals( $mixed->getPropertyId() );
	}

	/**
	 * @see Hashable::getHash
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getHash() {
		return sha1( $this->getType() . $this->propertyId->getHash() );
	}

}
