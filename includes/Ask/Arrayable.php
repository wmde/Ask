<?php

namespace Ask;

/**
 * Interface for objects that have a toArray method.
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
interface Arrayable {

	/**
	 * Returns a representation of the object in primitive form,
	 * using only primitive values and arrays. The return value
	 * is thus does not contain any objects and can be fed to
	 * json_encode and similar. The result should typically have
	 * an understandable and stable format.
	 *
	 * The returned value might contain an absolute or relative type
	 * identifier that can be used to construct an object from the
	 * return value.
	 *
	 * @since 0.1
	 *
	 * @return array|null|bool|int|float|string
	 */
	public function toArray();

};