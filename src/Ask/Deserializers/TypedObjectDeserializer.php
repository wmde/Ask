<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Deserializers\Exceptions\MissingAttributeException;
use Ask\Deserializers\Exceptions\MissingTypeException;
use Ask\Deserializers\Exceptions\UnsupportedTypeException;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class TypedObjectDeserializer implements Deserializer {

	/**
	 * Returns the objectType supported by the implementation.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected abstract function getObjectType();

	/**
	 * Returns the name of the key used for the specific type of object.
	 * For instance "descriptionType" or "sortExpressionType".
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected abstract function getSubTypeKey();

	/**
	 * Deserializes the value serialization into an object.
	 *
	 * @since 0.1
	 *
	 * @param string $sortExpressionType
	 * @param array $valueSerialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	protected abstract function getDeserializedValue( $sortExpressionType, array $valueSerialization );

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserialization( $serialization );
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

	protected function hasCorrectObjectType( $serialization ) {
		return $serialization['objectType'] === $this->getObjectType();
	}

	protected function hasObjectType( $serialization ) {
		return is_array( $serialization )
			&& array_key_exists( 'objectType', $serialization );
	}

	protected function getDeserialization( array $serialization ) {
		$this->requireAttribute( $serialization, $this->getSubTypeKey() );
		$this->requireAttributes( $serialization, 'value' );
		$this->assertAttributeIsArray( $serialization, 'value' );

		$specificType = $serialization[$this->getSubTypeKey()];
		$valueSerialization = $serialization['value'];

		return $this->getDeserializedValue( $specificType, $valueSerialization );
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
