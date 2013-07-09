<?php

namespace Ask\Serializers;

use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SelectionRequest;
use Ask\Language\Selection\SubjectSelection;
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
class SelectionRequestSerializer implements Serializer {

	public function serialize( $askObject ) {
		$this->assertCanSerialize( $askObject );
		return $this->getSerializedSelectionRequest( $askObject );
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->canSerialize( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject, $this );
		}
	}

	protected function getSerializedSelectionRequest( SelectionRequest $request ) {
		return array(
			'objectType' => 'selectionRequest',
			'selectionType' => $request->getType(),
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
			return null;
		}

		throw new UnsupportedObjectException( $request, $this );
	}

	public function canSerialize( $askObject ) {
		return $askObject instanceof SelectionRequest;
	}

}
