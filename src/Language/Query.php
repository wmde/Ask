<?php

namespace Ask\Language;

use Ask\Language\Description\Description;
use Ask\Language\Option\QueryOptions;
use Ask\Language\Selection\SelectionRequest;

/**
 * Object representing a query definition.
 *
 * @since 1.0
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
	 * @since 1.0
	 *
	 * @var Description
	 */
	protected $description;

	/**
	 * The query's selection requests.
	 * These determine which information should be selected from the matching entities.
	 * It is conceptually similar to the SELECT clause in an SQL query.
	 *
	 * @since 1.0
	 *
	 * @var SelectionRequest[]
	 */
	protected $selectionRequests;

	/**
	 * The query's options.
	 *
	 * @since 1.0
	 *
	 * @var QueryOptions
	 */
	protected $options;

	/**
	 * @since 1.0
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
	 * @since 1.0
	 *
	 * @return Description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Returns the query's selection requests.
	 *
	 * @since 1.0
	 *
	 * @return SelectionRequest[]
	 */
	public function getSelectionRequests() {
		return $this->selectionRequests;
	}

	/**
	 * Returns the query's options.
	 *
	 * @since 1.0
	 *
	 * @return QueryOptions
	 */
	public function getOptions() {
		return $this->options;
	}

}
