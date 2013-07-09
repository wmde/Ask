<?php

namespace Ask\Deserializers\Strategies;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Language\Description\ValueDescription;
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
class SortExpressionDeserializationStrategy extends TypedDeserializationStrategy {

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
		if ( $sortExpressionType !== 'propertyValue' ) {
			throw new InvalidAttributeException( 'sortExpressionType', $sortExpressionType );
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
			throw new DeserializationException( '', $ex );
		}

		return $expression;
	}

}
