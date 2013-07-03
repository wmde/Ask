<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Deserializers\Exceptions\MissingAttributeException;
use Ask\Deserializers\Exceptions\MissingTypeException;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Ask\Deserializers\Exceptions\UnsupportedTypeException;
use DataValues\DataValueFactory;

/**
 * TODO: split individual description handling to own classes to we can use
 * polymorphic dispatch and not have this big OCP violation.
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionDeserializer implements Deserializer {

	protected $dataValueFactory;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
	}

	public function deserialize( $serialization ) {
		$this->assertCanDeserialize( $serialization );
		return $this->getDeserializedDescription( $serialization );
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
		return $serialization['objectType'] === 'description';
	}

	protected function hasObjectType( $serialization ) {
		return is_array( $serialization )
			&& array_key_exists( 'objectType', $serialization );
	}

	protected function getDeserializedDescription( array $serialization ) {
		if ( !array_key_exists( 'descriptionType', $serialization ) ) {
			throw new MissingAttributeException(
				'descriptionType',
				$this
			);
		}

		$this->requireAttribute( $serialization, 'descriptionType' );
		$this->requireAttribute( $serialization, 'value' );
		$this->assertAttributeIsArray( $serialization, 'value' );

		$descriptionType = $serialization['descriptionType'];
		$descriptionValue = $serialization['value'];

		return $this->getDeserializedValue( $descriptionType, $descriptionValue );
	}

	protected function requireAttribute( array $array, $attributeName ) {
		if ( !array_key_exists( $attributeName, $array ) ) {
			throw new MissingAttributeException(
				$attributeName,
				$this
			);
		}
	}

	protected function requireAttributes( array $array ) {
		$requiredAttributes = func_get_args();
		array_shift( $requiredAttributes );

		foreach ( $requiredAttributes as $attribute ) {
			$this->requireAttribute( $array, $attribute );
		}
	}

	protected function getDeserializedValue( $descriptionType, $descriptionValue ) {
		if ( $descriptionType === 'anyValue' ) {
			return new AnyValue();
		}

		if ( $descriptionType === 'someProperty' ) {
			return $this->newSomeProperty( $descriptionValue );
		}

		if ( $descriptionType === 'valueDescription' ) {
			return $this->newValueDescription( $descriptionValue );
		}

		if ( $descriptionType === 'conjunction' ) {
			return $this->newConjunction( $descriptionValue );
		}

		if ( $descriptionType === 'disjunction' ) {
			return $this->newDisjunction( $descriptionValue );
		}

		throw new InvalidAttributeException(
			'descriptionType',
			$this,
			'The provided descriptionType is not supported by this deserializer'
		);
	}

	protected function assertAttributeIsArray( array $array, $attributeName ) {
		if ( !is_array( $array[$attributeName] ) ) {
			throw new InvalidAttributeException(
				$attributeName,
				$this
			);
		}
	}

	protected function newSomeProperty( array $descriptionValue ) {
		$this->requireAttributes( $descriptionValue, 'property', 'description', 'isSubProperty' );
		$this->assertAttributeIsArray( $descriptionValue, 'property' );

		try {
			$someProperty = new SomeProperty(
				$this->dataValueFactory->newFromArray( $descriptionValue['property'] ),
				$this->deserialize( $descriptionValue['description'] ),
				$descriptionValue['isSubProperty']
			);
		}
		catch ( \InvalidArgumentException $ex ) {
			throw new DeserializationException( $this, '', $ex );
		}

		return $someProperty;
	}

	protected function newValueDescription( array $descriptionValue ) {
		$this->requireAttributes( $descriptionValue, 'value', 'comparator' );
		$this->assertAttributeIsArray( $descriptionValue, 'value' );

		try {
			$valueDescription = new ValueDescription(
				$this->dataValueFactory->newFromArray( $descriptionValue['value'] ),
				$descriptionValue['comparator']
			);
		}
		catch ( \InvalidArgumentException $ex ) {
			throw new DeserializationException( $this, '', $ex );
		}

		return $valueDescription;
	}

	protected function newConjunction( array $descriptionValue ) {
		$this->requireAttribute( $descriptionValue, 'descriptions' );
		$this->assertAttributeIsArray( $descriptionValue, 'descriptions' );

		return new Conjunction(
			$this->deserializeDescriptions( $descriptionValue['descriptions'] )
		);
	}

	protected function newDisjunction( array $descriptionValue ) {
		$this->requireAttribute( $descriptionValue, 'descriptions' );
		$this->assertAttributeIsArray( $descriptionValue, 'descriptions' );

		return new Disjunction(
			$this->deserializeDescriptions( $descriptionValue['descriptions'] )
		);
	}

	/**
	 * @param array $descriptionSerializations
	 *
	 * @return Description[]
	 */
	protected function deserializeDescriptions( array $descriptionSerializations ) {
		$descriptions = array();

		foreach ( $descriptionSerializations as $serialization ) {
			$descriptions[] = $this->deserialize( $serialization );
		}

		return $descriptions;
	}

}
