<?php

namespace Ask\Deserializers;

use Ask\Language\Query;
use Deserializers\Deserializer;
use Deserializers\TypedObjectDeserializer;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryDeserializer extends TypedObjectDeserializer {

	protected $componentDeserializer;

	public function __construct( Deserializer $componentDeserializer ) {
		$this->componentDeserializer = $componentDeserializer;

		parent::__construct( 'query' );
	}

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserialization( $serialization );
	}

	protected function getDeserialization( array $serialization ) {
		$this->requireAttributes( $serialization, 'description', 'options', 'selectionRequests' );

		$this->assertAttributeIsArray( $serialization, 'selectionRequests' );

		$selectionRequests = array();

		foreach ( $serialization['selectionRequests'] as $selectionRequestSerialization ) {
			$selectionRequests[] = $this->componentDeserializer->deserialize( $selectionRequestSerialization );
		}

		return new Query(
			$this->componentDeserializer->deserialize( $serialization['description'] ),
			$selectionRequests,
			$this->componentDeserializer->deserialize( $serialization['options'] )
		);
	}

}
