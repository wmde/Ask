<?php

namespace Ask\Deserializers\Strategies;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Language\Description\ValueDescription;
use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SubjectSelection;
use DataValues\DataValueFactory;
use InvalidArgumentException;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
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
	 * @since 0.1
	 *
	 * @param string $sortExpressionType
	 * @param array $valueSerialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function getDeserializedValue( $sortExpressionType, array $valueSerialization ) {
		switch ( $sortExpressionType ) {
			case 'property':
				return $this->newPropertySelectionRequest( $valueSerialization );
				break;
			case 'subject':
				return new SubjectSelection();
				break;
		}

		throw new InvalidAttributeException( 'selectionRequestType', $sortExpressionType );
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
