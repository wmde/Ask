<?php

namespace Ask\Serializers;

use Ask\Language\Query;
use Ask\Language\Selection\SelectionRequest;
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
class QuerySerializer implements Serializer {

	protected $componentSerializer;

	/**
	 * @param Serializer $componentSerializer
	 * This serializer needs to be able to serialize the various components that make up a Query.
	 */
	public function __construct( Serializer $componentSerializer ) {
		$this->componentSerializer = $componentSerializer;
	}

	public function serialize( $askObject ) {
		$this->assertCanSerialize( $askObject );

		return $this->getSerializedQuery( $askObject );
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->canSerialize( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject, $this );
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
			'description' => $this->componentSerializer->serialize( $query->getDescription() ),
			'options' => $this->componentSerializer->serialize( $query->getOptions() ),
			'selectionrequests' => (object)$selectionRequests,
		);
	}

}