<?php

namespace Ask\Language\Description;

/**
 * A description that matches any object.
 *
 * Corresponds to owl:thing, the class of all abstract objects.
 *
 * Based on SMWThingDescription
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class AnyValue extends Description implements \Ask\Immutable {

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getSize() {
		return 0;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getDepth() {
		return 0;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return 'anyValue';
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
		return $mixed instanceof AnyValue;
	}

	/**
	 * @see Hashable::getHash
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getHash() {
		return sha1( $this->getType() );
	}

}
