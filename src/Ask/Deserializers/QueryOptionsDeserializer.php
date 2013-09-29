<?php

namespace Ask\Deserializers;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortOptions;
use Deserializers\Deserializer;
use Deserializers\TypedObjectDeserializer;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryOptionsDeserializer extends TypedObjectDeserializer {

	protected $sortExpressionDeserializer;

	public function __construct( Deserializer $sortExpressionDeserializer ) {
		$this->sortExpressionDeserializer = $sortExpressionDeserializer;

		parent::__construct( 'queryOptions' );
	}

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserialization( $serialization );
	}

	protected function getDeserialization( array $serialization ) {
		$this->requireAttributes( $serialization, 'limit', 'offset', 'sort' );
		$this->assertAttributeIsArray( $serialization, 'sort' );
		$this->assertAttributeInternalType( $serialization, 'limit', 'integer' );
		$this->assertAttributeInternalType( $serialization, 'offset', 'integer' );

		$this->requireAttribute( $serialization['sort'], 'expressions' );
		$this->assertAttributeIsArray( $serialization['sort'], 'expressions' );

		$sortExpressions = array();

		foreach ( $serialization['sort']['expressions'] as $sortExpressionSerialization ) {
			$sortExpressions[] = $this->sortExpressionDeserializer->deserialize( $sortExpressionSerialization );
		}

		return new QueryOptions(
			$serialization['limit'],
			$serialization['offset'],
			new SortOptions( $sortExpressions )
		);
	}

}
