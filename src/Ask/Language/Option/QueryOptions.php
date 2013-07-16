<?php

namespace Ask\Language\Option;

/**
 * Represents the options for a query.
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
 * @since 1.0
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryOptions implements \Ask\Immutable {

	/**
	 * The query limit. At most this many results will be selected.
	 *
	 * @since 1.0
	 *
	 * @var int
	 */
	protected $limit;

	/**
	 * The query offset. The first this many matching results will be skipped.
	 *
	 * @since 1.0
	 *
	 * @var int
	 */
	protected $offset;

	/**
	 * The query sort.
	 *
	 * @since 1.0
	 *
	 * @var SortOptions
	 */
	protected $sort;

	/**
	 * @since 1.0
	 *
	 * @param int $limit
	 * @param int $offset
	 * @param SortOptions|null $sort
	 */
	public function __construct( $limit, $offset, SortOptions $sort = null ) {
		$this->limit = $limit;
		$this->offset = $offset;
		$this->sort = $sort === null ? new SortOptions( array() ) : $sort;
	}

	/**
	 * Returns the query limit.
	 *
	 * @since 1.0
	 *
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Returns the query offset.
	 *
	 * @since 1.0
	 *
	 * @return int
	 */
	public function getOffset() {
		return $this->offset;
	}

	/**
	 * Returns the query sort options.
	 *
	 * @since 1.0
	 *
	 * @return SortOptions
	 */
	public function getSort() {
		return $this->sort;
	}

}
