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
class SortExpressionDeserializer implements Deserializer {

	protected $dataValueFactory;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
	}

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserializedSortExpression( $serialization );
	}

	protected function assertCanDeserialize( $serialization ) {
		if ( !$this->hasObjectType( $serialization ) ) {
			throw new MissingTypeException( $this );
		}

		if ( !$this->hasCorrectObjectType( $serialization ) ) {
			throw new UnsupportedTypeException( $serialization['objectType'], $this );
		}
	}

	public function canDeserialize( $serialization ) {
		return $this->hasObjectType( $serialization ) && $this->hasCorrectObjectType( $serialization );
	}

	protected function hasObjectType( $serialization ) {
		return is_array( $serialization )
		&& array_key_exists( 'objectType', $serialization );
	}

	protected function hasCorrectObjectType( $serialization ) {
		return $serialization['objectType'] === 'sortExpression';
	}

	protected function getDeserializedSortExpression( array $serialization ) {
		$this->requireAttribute( $serialization, 'sortExpressionType' );
		$this->requireAttribute( $serialization, 'value' );
		$this->assertAttributeIsArray( $serialization, 'value' );

		if ( $serialization['sortExpressionType'] !== 'propertyValue' ) {
			throw new InvalidAttributeException( 'sortExpressionType', $this );
		}

		$value = $serialization['value'];

		$this->requireAttribute( $value, 'direction' );
		$this->requireAttribute( $value, 'property' );
		$this->assertAttributeIsArray( $value, 'property' );

		try {
			$expression = new PropertyValueSortExpression(
				$this->dataValueFactory->newFromArray( $value['property'] ),
				$value['direction']
			);
		}
		catch ( InvalidArgumentException $ex ) {
			throw new DeserializationException( $this, '', $ex );
		}

		return $expression;
	}

	protected function requireAttribute( array $array, $attributeName ) {
		if ( !array_key_exists( $attributeName, $array ) ) {
			throw new MissingAttributeException(
				$attributeName,
				$this
			);
		}
	}

	protected function assertAttributeIsArray( array $array, $attributeName ) {
		if ( !is_array( $array[$attributeName] ) ) {
			throw new InvalidAttributeException(
				$attributeName,
				$this
			);
		}
	}

}
