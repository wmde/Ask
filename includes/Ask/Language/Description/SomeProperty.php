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
final class SomeProperty extends Description implements \Ask\Immutable {

	/**
	 * The property that should be present.
	 *
	 * @since 0.1
	 *
	 * @var DataValue
	 */
	private $propertyId;

	/**
	 * The description the properties value should match.
	 *
	 * @since 0.1
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
	 * @since 0.1
	 *
	 * @var boolean
	 */
	private $isSubProperty;

	/**
	 * Cache for the hash.
	 *
	 * @since 0.1
	 *
	 * @var string|null
	 */
	private $hash;

	/**
	 * Constructor.
	 *
	 * @since 0.1
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
	 * @since 0.1
	 *
	 * @return Description
	 */
	public function getSubDescription() {
		return $this->subDescription;
	}

	/**
	 * Returns the property.
	 *
	 * @since 0.1
	 *
	 * @return DataValue
	 */
	public function getPropertyId() {
		return $this->propertyId;
	}

	/**
	 * Returns if the property is a sub property.
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	public function isSubProperty() {
		return $this->isSubProperty;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getSize() {
		return $this->subDescription->getSize() + 1;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getDepth() {
		return $this->subDescription->getDepth() + 1;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getType() {
		return 'someproperty';
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return array|null|bool|int|float|string
	 */
	public function getArrayValue() {
		return array(
			'property' => $this->propertyId->toArray(),
			'description' => $this->subDescription->toArray(),
			'issubproperty' => $this->isSubProperty
		);
	}

	/**
	 * @see Comparable::equals
	 *
	 * @since 0.1
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
	 * @since 0.1
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
