<?php

namespace Ask;

/**
 * Interface for objects that have a getType method.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Typeable {

	/**
	 * Returns a type identifier for the object.
	 * This identifier does not have to be globally unique,
	 * though is expected to be unique for objects of the same type.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType();

}