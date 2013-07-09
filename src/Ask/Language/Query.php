<?php

namespace Ask\Language;

use Ask\Language\Description\Description;
use Ask\Language\Option\QueryOptions;
use Ask\Language\Selection\SelectionRequest;

/**
 * Object representing a query definition.
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
class Query implements \Ask\Immutable {

	const OPT_LIMIT = 'limit';
	const OPT_OFFSET = 'offset';
	const OPT_SORT = 'sort';

	/**
	 * The query's description.
	 * This is the selection criterion of the query that determines which entities match.
	 * It is conceptually similar to the WHERE clause in an SQL query.
	 *
	 * @since 0.1
	 *
	 * @var Description
	 */
	protected $description;

	/**
	 * The query's selection requests.
	 * These determine which information should be selected from the matching entities.
	 * It is conceptually similar to the SELECT clause in an SQL query.
	 *
	 * @since 0.1
	 *
	 * @var SelectionRequest[]
	 */
	protected $selectionRequests;

	/**
	 * The query's options.
	 *
	 * @since 0.1
	 *
	 * @var QueryOptions
	 */
	protected $options;

	/**
	 * @since 0.1
	 *
	 * @param Description $description
	 * @param SelectionRequest[] $selectionRequests
	 * @param QueryOptions $options
	 */
	public function __construct( Description $description, array $selectionRequests, QueryOptions $options ) {
		$this->description = $description;
		$this->selectionRequests = $selectionRequests;
		$this->options = $options;
	}

	/**
	 * Returns the query description.
	 *
	 * @since 0.1
	 *
	 * @return Description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Returns the query's selection requests.
	 *
	 * @since 0.1
	 *
	 * @return SelectionRequest[]
	 */
	public function getSelectionRequests() {
		return $this->selectionRequests;
	}

	/**
	 * Returns the query's options.
	 *
	 * @since 0.1
	 *
	 * @return QueryOptions
	 */
	public function getOptions() {
		return $this->options;
	}

}
