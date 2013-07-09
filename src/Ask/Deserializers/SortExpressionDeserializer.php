<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Deserializers\Exceptions\MissingAttributeException;
use Ask\Deserializers\Exceptions\MissingTypeException;
use Ask\Deserializers\Exceptions\UnsupportedTypeException;
use Ask\Language\Option\PropertyValueSortExpression;
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
class SortExpressionDeserializer extends TypedObjectDeserializer {

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
		return 'sortExpression';
	}

	/**
	 * @see TypedObjectDeserializer::getSubTypeKey
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getSubTypeKey() {
		return 'sortExpressionType';
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
		if ( $sortExpressionType !== 'propertyValue' ) {
			throw new InvalidAttributeException( 'sortExpressionType', $this );
		}

		$this->requireAttribute( $valueSerialization, 'direction' );
		$this->requireAttribute( $valueSerialization, 'property' );
		$this->assertAttributeIsArray( $valueSerialization, 'property' );

		try {
			$expression = new PropertyValueSortExpression(
				$this->dataValueFactory->newFromArray( $valueSerialization['property'] ),
				$valueSerialization['direction']
			);
		}
		catch ( InvalidArgumentException $ex ) {
			throw new DeserializationException( $this, '', $ex );
		}

		return $expression;
	}

}
