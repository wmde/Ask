<?php

namespace Ask\Language\Selection;

/**
 * Base class for selection requests.
 *
 * A print request specifies that a certain value should be displayed
 * and in what manner this display should happen.
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
abstract class SelectionRequest implements \Ask\Arrayable {

	const TYPE_PROP = 1;
	const TYPE_SUBJECT = 2;

	/**
	 * Returns the type of the selection request.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public abstract function getType();

	/**
	 * Returns the value in a format that contains only primitive values
	 * and arrays. This format is typically stable and easy to understand,
	 * and thus ideal for serialization such as json_encode.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public abstract function getArrayValue();

	/**
	 * @see \Ask\Arrayable::toArray
	 *
	 * This method has a more specific return format then Arrayable::toArray.
	 * The return value is always an array that holds a type key pointing
	 * to string type identifier (the same one as obtained via ->getType())
	 * and a value key pointing to a mixed (though simple) value.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public final function toArray() {
		return array(
			'type' => $this->getType(),
			'value' => $this->getArrayValue(),
		);
	}

}
