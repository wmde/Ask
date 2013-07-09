<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Deserializers\Exceptions\MissingAttributeException;
use Ask\Deserializers\Exceptions\MissingTypeException;
use Ask\Deserializers\Exceptions\UnsupportedTypeException;
use Ask\Deserializers\Strategies\TypedDeserializationStrategy;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TypedObjectDeserializer implements Deserializer {

	protected $deserializationStrategy;
	protected $objectType;
	protected $subTypeKey;

	/**
	 * @param TypedDeserializationStrategy $deserializationStrategy
	 * @param string $objectType The objectType that is supported. For instance "description" or "selectionRequest".
	 * @param string $subTypeKey The name of the key used for the specific type of object. For instance "descriptionType" or "sortExpressionType".
	 */
	public function __construct( TypedDeserializationStrategy $deserializationStrategy, $objectType, $subTypeKey ) {
		$this->deserializationStrategy = $deserializationStrategy;
		$this->objectType = $objectType;
		$this->subTypeKey = $subTypeKey;
	}

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserialization( $serialization );
	}

	protected function assertCanDeserialize( $serialization ) {
		if ( !$this->hasObjectType( $serialization ) ) {
			throw new MissingTypeException();
		}

		if ( !$this->hasCorrectObjectType( $serialization ) ) {
			throw new UnsupportedTypeException( $serialization['objectType'] );
		}
	}

	public function canDeserialize( $serialization ) {
		return $this->hasObjectType( $serialization ) && $this->hasCorrectObjectType( $serialization );
	}

	protected function hasCorrectObjectType( $serialization ) {
		return $serialization['objectType'] === $this->objectType;
	}

	protected function hasObjectType( $serialization ) {
		return is_array( $serialization )
			&& array_key_exists( 'objectType', $serialization );
	}

	protected function getDeserialization( array $serialization ) {
		$this->requireAttribute( $serialization, $this->subTypeKey );
		$this->requireAttributes( $serialization, 'value' );
		$this->assertAttributeIsArray( $serialization, 'value' );

		$specificType = $serialization[$this->subTypeKey];
		$valueSerialization = $serialization['value'];

		return $this->deserializationStrategy->getDeserializedValue( $specificType, $valueSerialization );
	}

	protected function requireAttributes( array $array ) {
		$requiredAttributes = func_get_args();
		array_shift( $requiredAttributes );

		foreach ( $requiredAttributes as $attribute ) {
			$this->requireAttribute( $array, $attribute );
		}
	}

	protected function requireAttribute( array $array, $attributeName ) {
		if ( !array_key_exists( $attributeName, $array ) ) {
			throw new MissingAttributeException(
				$attributeName
			);
		}
	}

	protected function assertAttributeIsArray( array $array, $attributeName ) {
		if ( !is_array( $array[$attributeName] ) ) {
			throw new InvalidAttributeException(
				$attributeName
			);
		}
	}

}
