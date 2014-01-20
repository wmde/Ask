<?php

namespace Ask\Language\Description;

use DataValues\DataValue;
use InvalidArgumentException;

/**
 * Description of a set of instances that have an attribute with some value
 * that fits another (sub)description.
 *
 * Corresponds to existential quantification ("SomeValuesFrom" restriction) on
 * properties in OWL. In conjunctive queries (OWL) and SPARQL (RDF), it is
 * represented by using variables in the object part of such properties.
 *
 * Based on SMWSomeProperty
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SomeProperty extends Description implements \Ask\Immutable {

	/**
	 * The property that should be present.
	 *
	 * @since 1.0
	 *
	 * @var DataValue
	 */
	private $propertyId;

	/**
	 * The description the properties value should match.
	 *
	 * @since 1.0
	 *
	 * @var Description
	 */
	private $subDescription;

	/**
	 * If the property is a sub property or not.
	 *
	 * For instance in the Wikibase Claim context,
	 * a non-sub property would point to the property
	 * of the main snak, while a sub property would
	 * point to a qualifier.
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	private $isSubProperty;

	/**
	 * Cache for the hash.
	 *
	 * @since 1.0
	 *
	 * @var string|null
	 */
	private $hash;

	/**
	 * @since 1.0
	 *
	 * @param DataValue $propertyId
	 * @param Description $subDescription
	 * @param boolean $isSubProperty
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( DataValue $propertyId, Description $subDescription, $isSubProperty = false ) {
		$this->propertyId = $propertyId;
		$this->subDescription = $subDescription;

		if ( !is_bool( $isSubProperty ) ) {
			throw new InvalidArgumentException( '$isSubProperty must be of type boolean' );
		}

		$this->isSubProperty = $isSubProperty;
	}

	/**
	 * Returns the description.
	 *
	 * @since 1.0
	 *
	 * @return Description
	 */
	public function getSubDescription() {
		return $this->subDescription;
	}

	/**
	 * Returns the property.
	 *
	 * @since 1.0
	 *
	 * @return DataValue
	 */
	public function getPropertyId() {
		return $this->propertyId;
	}

	/**
	 * Returns if the property is a sub property.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isSubProperty() {
		return $this->isSubProperty;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getSize() {
		return $this->subDescription->getSize() + 1;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getDepth() {
		return $this->subDescription->getDepth() + 1;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return 'someProperty';
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
		return $mixed instanceof SomeProperty
			&& $this->isSubProperty === $mixed->isSubProperty()
			&& $this->propertyId->equals( $mixed->getPropertyId() )
			&& $this->subDescription->equals( $mixed->getSubDescription() );
	}

	/**
	 * @see Hashable::getHash
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getHash() {
		if ( $this->hash === null ) {
			$this->hash = sha1(
				$this->getType() .
				$this->propertyId->getHash() .
				$this->subDescription->getHash() .
				$this->isSubProperty
			);
		}

		return $this->hash;
	}

}
