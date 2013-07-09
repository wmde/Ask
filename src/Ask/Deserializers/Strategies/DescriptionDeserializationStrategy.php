<?php

namespace Ask\Deserializers\Strategies;

use Ask\Deserializers\Deserializer;
use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Exceptions\InvalidAttributeException;
use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
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
class DescriptionDeserializationStrategy extends TypedDeserializationStrategy {

	protected $dataValueFactory;
	protected $descriptionDeserializer;

	public function __construct( DataValueFactory $dataValueFactory, Deserializer $descriptionDeserializer ) {
		$this->dataValueFactory = $dataValueFactory;
		$this->descriptionDeserializer = $descriptionDeserializer;
	}

	/**
	 * @see TypedDeserializationStrategy::getDeserializedValue
	 *
	 * @since 0.1
	 *
	 * @param string $descriptionType
	 * @param array $descriptionValue
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function getDeserializedValue( $descriptionType, array $descriptionValue ) {
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
			$descriptionType,
			'The provided descriptionType is not supported by this deserializer'
		);
	}

	protected function newSomeProperty( array $descriptionValue ) {
		$this->requireAttributes( $descriptionValue, 'property', 'description', 'isSubProperty' );
		$this->assertAttributeIsArray( $descriptionValue, 'property' );

		try {
			$someProperty = new SomeProperty(
				$this->dataValueFactory->newFromArray( $descriptionValue['property'] ),
				$this->descriptionDeserializer->deserialize( $descriptionValue['description'] ),
				$descriptionValue['isSubProperty']
			);
		}
		catch ( \InvalidArgumentException $ex ) {
			throw new DeserializationException( '', $ex );
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
			throw new DeserializationException( '', $ex );
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
			$descriptions[] = $this->descriptionDeserializer->deserialize( $serialization );
		}

		return $descriptions;
	}

}
