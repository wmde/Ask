<?php

namespace Ask\Language\Description;

/**
 * Interface for query condition descriptions.
 *
 * Based on SMWDescription
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
interface Description {

	/**
	 * Returns the size of the description.
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getSize();

	/**
	 * Returns the depth of the description.
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getDepth();

	/**
	 * Returns if the condition consists out of a non-disjoint equality restriction on a value.
	 *
	 * Examples for true:
	 * - value needs to be 42
	 * - value a needs to be 42 and value b needs to be 'foobar'
	 * - value a needs to be 42 and value b needs to be < 100 or > 200
	 *
	 * Examples for false:
	 * - value needs to be > 100
	 * - value needs to be 'foo' or 'bar'
	 * - there needs to be a value
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	public function isSingleton();

}
