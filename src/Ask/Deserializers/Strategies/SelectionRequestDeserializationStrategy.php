<?php

namespace Ask\Deserializers\Strategies;

use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SubjectSelection;
use DataValues\DataValueFactory;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\Exceptions\InvalidAttributeException;
use Deserializers\TypedDeserializationStrategy;
use InvalidArgumentException;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SelectionRequestDeserializationStrategy extends TypedDeserializationStrategy {

	protected $dataValueFactory;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
	}

	/**
	 * @see TypedDeserializationStrategy::getDeserializedValue
	 *
	 * @since 1.0
	 *
	 * @param string $selectionRequestType
	 * @param array $valueSerialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function getDeserializedValue( $selectionRequestType, array $valueSerialization ) {
		switch ( $selectionRequestType ) {
			case 'property':
				return $this->newPropertySelectionRequest( $valueSerialization );
				break;
			case 'subject':
				return new SubjectSelection();
				break;
		}

		throw new InvalidAttributeException( 'selectionRequestType', $selectionRequestType );
	}

	protected function newPropertySelectionRequest( array $value ) {
		$this->requireAttribute( $value, 'property' );
		$this->assertAttributeIsArray( $value, 'property' );

		try {
			$propertyId = $this->dataValueFactory->newFromArray( $value['property'] );
		}
		catch ( InvalidArgumentException $ex ) {
			throw new DeserializationException( '', $ex );
		}

		return new PropertySelection( $propertyId );
	}

}
