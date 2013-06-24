<?php

namespace Ask\Serializers;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortExpression;
use Ask\Serializers\Exceptions\UnsupportedObjectException;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryOptionsSerializer implements Serializer {

	protected $componentSerializer;

	/**
	 * @param Serializer $componentSerializer
	 * This serializer needs to be able to serialize the various components that make up a QueryOptions object.
	 */
	public function __construct( Serializer $componentSerializer ) {
		$this->componentSerializer = $componentSerializer;
	}

	public function serialize( $askObject ) {
		$this->assertCanSerialize( $askObject );
		return $this->getSerializedOptions( $askObject );
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->canSerialize( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject, $this );
		}
	}

	protected function getSerializedOptions( QueryOptions $options ) {
		$expressionSerializer = $this->componentSerializer;

		return array(
			'limit' => $options->getLimit(),
			'offset' => $options->getOffset(),

			// TODO: create a dedicated serializer for sort options
			'sort' => array(
				'expressions' => (object)array_map(
					function( SortExpression $expression ) use ( $expressionSerializer ) {
						return $expressionSerializer->serialize( $expression );
					},
					$options->getSort()->getExpressions()
				)
			),
		);
	}

	public function canSerialize( $askObject ) {
		return $askObject instanceof QueryOptions;
	}

}
