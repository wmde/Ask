<?php

namespace Ask\Language\Description;

use DataValues\PropertyValue;
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
	 * @var PropertyValue
	 */
	private $property;

	/**
	 * The description the properties value should match.
	 *
	 * @since 0.1
	 *
	 * @var Description
	 */
	private $description;

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
	 * @param PropertyValue $property
	 * @param Description $description
	 * @param boolean $isSubProperty
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( PropertyValue $property, Description $description, $isSubProperty = false ) {
		$this->property = $property;
		$this->description = $description;

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
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Returns the property.
	 *
	 * @since 0.1
	 *
	 * @return PropertyValue
	 */
	public function getProperty() {
		return $this->property;
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
		return $this->description->getSize() + 1;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getDepth() {
		return $this->description->getDepth() + 1;
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
			'property' => $this->property->toArray(),
			'description' => $this->description->toArray(),
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
			&& $this->property->equals( $mixed->getProperty() )
			&& $this->description->equals( $mixed->getDescription() );
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
				$this->property->getHash() .
				$this->description->getHash() .
				$this->isSubProperty
			);
		}

		return $this->hash;
	}

}
