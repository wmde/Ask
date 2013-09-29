<?php

namespace Ask\Language\Selection;

/**
 * Selection request that specifies the subject (as in SPO) should be obtained.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SubjectSelection extends SelectionRequest implements \Ask\Immutable {

	/**
	 * @see Typeable::getType
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return SelectionRequest::TYPE_SUBJECT;
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
		return $mixed instanceof SubjectSelection;
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
