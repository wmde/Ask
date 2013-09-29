<?php

namespace Ask\Language\Description;

use Ask\Hashable;

/**
 * Description of a collection of many descriptions.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class DescriptionCollection extends Description implements \Ask\Immutable {

	/**
	 * The descriptions that make up this collection of descriptions.
	 *
	 * @since 1.0
	 *
	 * @var Description[]
	 */
	private $descriptions;

	/**
	 * Cache for the hash.
	 *
	 * @since 1.0
	 *
	 * @var string|null
	 */
	private $hash;

	/**
	 * @since 1.0
	 *
	 * @param Description[] $descriptions
	 */
	public function __construct( array $descriptions ) {
		$this->descriptions = $descriptions;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getSize() {
		$size = 0;

		foreach ( $this->descriptions as $description ) {
			$size += $description->getSize();
		}

		assert( $size >= 0 );

		return $size;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getDepth() {
		$depth = 0;

		foreach ( $this->descriptions as $description ) {
			$depth = max( $depth, $description->getDepth() );
		}

		assert( $depth >= 0 );

		return $depth;
	}

	/**
	 * Returns the descriptions that make up this collection of descriptions.
	 *
	 * @since 1.0
	 *
	 * @return Description[]
	 */
	public function getDescriptions() {
		return $this->descriptions;
	}

	/**
	 * @see Comparable::equals
	 *
	 * Note: it is possible this method provides false negatives due to
	 * equivalent expressions being expressed in different structures.
	 * This is however likely not important.
	 *
	 * @since 1.0
	 *
	 * @param mixed $mixed
	 *
	 * @return boolean
	 */
	public function equals( $mixed ) {
		if ( !is_object( $mixed )
			|| ( get_class( $mixed ) !== get_called_class() ) ) {
			return false;
		}

		$descriptions = $this->descriptions;
		$moreDescriptions = $mixed->getDescriptions();

		if ( count( $descriptions ) !== count( $moreDescriptions ) ) {
			return false;
		}

		$this->sortCollection( $descriptions );
		$this->sortCollection( $moreDescriptions );
		reset( $moreDescriptions );

		foreach ( $descriptions as $description ) {
			if ( !$description->equals( current( $moreDescriptions ) ) ) {
				return false;
			}

			next( $moreDescriptions );
		}

		return true;
	}

	/**
	 * @see Hashable::getHash
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getHash() {
		if ( $this->hash === null ) {
			$this->sortCollection( $this->descriptions );

			$this->hash = sha1(
				$this->getType() .
				implode(
					'|',
					array_map(
						function( Hashable $hashable ) {
							return $hashable->getHash();
						},
						$this->descriptions
					)
				)
			);
		}

		return $this->hash;
	}

	/**
	 * Does an associative sort that works for Hashable objects.
	 *
	 * @since 1.0
	 *
	 * @param Hashable[] $array
	 */
	final protected function sortCollection( array &$array ) {
		usort(
			$array,
			function ( Hashable $a, Hashable $b ) {
				return $a->getHash() > $b->getHash() ? 1 : -1;
			}
		);
	}

}
