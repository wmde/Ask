<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
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
class SelectionRequestDeserializer extends TypedObjectDeserializer {

	protected $dataValueFactory;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
	}

	/**
	 * @see TypedObjectDeserializer::getObjectType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getObjectType() {
		return 'selectionRequest';
	}

	/**
	 * @see TypedObjectDeserializer::getSubTypeKey
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getSubTypeKey() {
		return 'selectionRequestType';
	}

	/**
	 * @see TypedObjectDeserializer::getDeserializedValue
	 *
	 * @since 0.1
	 *
	 * @param string $sortExpressionType
	 * @param array $valueSerialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	protected function getDeserializedValue( $sortExpressionType, array $valueSerialization ) {
		switch ( $sortExpressionType ) {
			case 'property':
				return $this->newPropertySelectionRequest( $valueSerialization );
				break;
			case 'subject':
				return new SubjectSelection();
				break;
		}

		throw new InvalidAttributeException( 'selectionRequestType', $this );
	}

	protected function newPropertySelectionRequest( array $value ) {
		$this->requireAttribute( $value, 'property' );
		$this->assertAttributeIsArray( $value, 'property' );

		try {
			$propertyId = $this->dataValueFactory->newFromArray( $value['property'] );
		}
		catch ( InvalidArgumentException $ex ) {
			throw new DeserializationException( $this, '', $ex );
		}

		return new PropertySelection( $propertyId );
	}

}
