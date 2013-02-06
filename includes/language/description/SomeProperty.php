<?php

namespace Ask\Language\Description;

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
class SomeProperty implements Description {

	/**
	 * @since 0.1
	 *
	 * @var TODO
	 */
	protected $property;

	/**
	 * @since 0.1
	 *
	 * @var Description
	 */
	protected $description;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 *
	 * @param TODO $property
	 * @param Description $description
	 */
	public function __construct( $property, Description $description ) {
		$this->property = $property;
		$this->description = $description;
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
	 * @return TODO
	 */
	public function getProperty() {
		return $this->property;
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

}