<?php

namespace Ask\Language\Description;

/**
 * Base class for query condition descriptions.
 *
 * Based on SMWDescription
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class Description implements \Ask\Comparable, \Ask\Hashable, \Ask\Typeable {

	/**
	 * Returns the size of the description.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public abstract function getSize();

	/**
	 * Returns the depth of the description.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public abstract function getDepth();

}
