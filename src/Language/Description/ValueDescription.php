<?php

namespace Ask\Language\Description;

use DataValues\DataValue;
use InvalidArgumentException;

/**
 * Description of one data value, or of a range of data values.
 *
 * Technically this usually corresponds to nominal predicates or to unary
 * concrete domain predicates in OWL which are parametrised by one constant
 * from the concrete domain.
 *
 * In RDF, concrete domain predicates that define ranges (like "greater or
 * equal to") are not directly available.
 *
 * Based on SMWValueDescription
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValueDescription extends Description implements \Ask\Immutable {

	// This list has values backwards compatible with SMW_CMP_.
	const COMP_EQUAL = 1;
	const COMP_LEQ = 2; // Less than or equal
	const COMP_GEQ = 3; // Greater than or equal
	const COMP_NEQ = 4; // Not equal
	const COMP_LIKE = 5;
	const COMP_NLIKE = 6; // Not like
	const COMP_LESS = 7; // Strictly less than
	const COMP_GREATER = 8; // Strictly greater than

	/**
	 * The value to compare to.
	 *
	 * @since 1.0
	 *
	 * @var DataValue
	 */
	protected $value;

	/**
	 * The comparator to use to determine if the value matches.
	 *
	 * @since 1.0
	 *
	 * @var int
	 */
	protected $comparator;

	/**
	 * @since 1.0
	 *
	 * @param DataValue $value
	 * @param int $comparator
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( DataValue $value, $comparator = self::COMP_EQUAL ) {
		$this->assertComparatorValidity( $comparator );

		$this->value = $value;
		$this->comparator = $comparator;
	}

	protected function assertComparatorValidity( $comparator ) {
		if ( !is_int( $comparator ) || $comparator < self::COMP_EQUAL || $comparator > self::COMP_GREATER ) {
			throw new InvalidArgumentException( 'Invalid comparator specified' );
		}
	}

	/**
	 * Returns the value to compare against.
	 *
	 * @since 1.0
	 *
	 * @return DataValue
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Returns the comparator to use when comparing against the value.
	 *
	 * @since 1.0
	 *
	 * @return int
	 */
	public function getComparator() {
		return $this->comparator;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getSize() {
		return 1;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getDepth() {
		return 0;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return 'valueDescription';
	}

	/**
	 * @see Comparable::equals
	 *
	 * @since 1.0
	 *
	 * @param mixed $mixed
	 *
	 * @return boolean
	 */
	public function equals( $mixed ) {
		return $mixed instanceof ValueDescription
			&& $this->comparator === $mixed->getComparator()
			&& $this->value->equals( $mixed->getValue() );
	}

	/**
	 * @see Hashable::getHash
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getHash() {
		return sha1( $this->getType() . $this->value->getHash() . $this->comparator );
	}

}
