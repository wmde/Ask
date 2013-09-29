<?php

namespace Ask\Language\Option;

/**
 * Represents the options for a query.
 *
 * @since 1.0
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
