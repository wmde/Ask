<?php

namespace Ask\Serializers;

use Ask\Language\Query;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @since 1.0
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QuerySerializer implements Serializer {

	protected $componentSerializer;

	/**
	 * @param Serializer $componentSerializer
	 * This serializer needs to be able to serialize the various components that make up a Query.
	 */
	public function __construct( Serializer $componentSerializer ) {
		$this->componentSerializer = $componentSerializer;
	}

	public function serialize( $object ) {
		$this->assertCanSerialize( $object );

		return $this->getSerializedQuery( $object );
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->canSerialize( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject );
		}
	}

	public function canSerialize( $askObject ) {
		return $askObject instanceof Query;
	}

	protected function getSerializedQuery( Query $query ) {
		$selectionRequests = array();

		foreach ( $query->getSelectionRequests() as $selectionRequest ) {
			$selectionRequests[] = $this->componentSerializer->serialize( $selectionRequest );
		}

		return array(
			'objectType' => 'query',
			'description' => $this->componentSerializer->serialize( $query->getDescription() ),
			'options' => $this->componentSerializer->serialize( $query->getOptions() ),
			'selectionRequests' => $selectionRequests,
		);
	}

}
