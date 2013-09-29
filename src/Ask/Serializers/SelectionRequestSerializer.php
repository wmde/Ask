<?php

namespace Ask\Serializers;

use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SelectionRequest;
use Ask\Language\Selection\SubjectSelection;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SelectionRequestSerializer implements Serializer {

	public function serialize( $object ) {
		$this->assertCanSerialize( $object );
		return $this->getSerializedSelectionRequest( $object );
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->isSerializerFor( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject );
		}
	}

	protected function getSerializedSelectionRequest( SelectionRequest $request ) {
		return array(
			'objectType' => 'selectionRequest',
			'selectionRequestType' => $request->getType(),
			'value' => $this->getValueSerialization( $request ),
		);
	}

	protected function getValueSerialization( SelectionRequest $request ) {
		if ( $request instanceof PropertySelection ) {
			return array(
				'property' => $request->getPropertyId()->toArray()
			);
		}

		if ( $request instanceof SubjectSelection ) {
			return array();
		}

		throw new UnsupportedObjectException( $request );
	}

	public function isSerializerFor( $askObject ) {
		return $askObject instanceof SelectionRequest;
	}

}
