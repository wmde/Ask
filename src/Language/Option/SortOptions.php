<?php

namespace Ask\Language\Option;

/**
 * Sorting options.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SortOptions implements \Ask\Immutable {

	/**
	 * The sort expressions that make up these sort options.
	 *
	 * @since 1.0
	 *
	 * @var SortExpression[]
	 */
	protected $expressions;

	/**
	 * @since 1.0
	 *
	 * @param SortExpression[] $expressions
	 */
	public function __construct( array $expressions ) {
		$this->expressions = $expressions;
	}

	/**
	 * Returns the sort expressions that make up these sort options.
	 *
	 * @since 1.0
	 *
	 * @return SortExpression[]
	 */
	public function getExpressions() {
		return $this->expressions;
	}

}
