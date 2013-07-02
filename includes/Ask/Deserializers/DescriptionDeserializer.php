<?php

namespace Ask\Deserializers;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Ask\Deserializers\Exceptions\UnsupportedTypeException;
use DataValues\DataValueFactory;

/**
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
		if ( !$this->canDeserialize( $serialization ) ) {
			throw new UnsupportedTypeException( $serialization['objectType'], $this );
		}
	}

	public function canDeserialize( $askObject ) {
		return $askObject['objectType'] === 'description'; // TODO: check element existence
	}

	protected function getDeserializedDescription( array $serialization ) {
		$descriptionType = $serialization['descriptionType'];
		$descriptionValue = $serialization['value'];

		if ( $descriptionType === 'anyValue' ) {
			return new AnyValue();
		}

		if ( $descriptionType === 'someProperty' ) {
			return new SomeProperty(
				$this->dataValueFactory->newFromArray( $descriptionValue['property'] ),
				$this->deserialize( $descriptionValue['description'] ),
				$descriptionValue['isSubProperty']
			);
		}

		if ( $descriptionType === 'valueDescription' ) {
			return new ValueDescription(
				$this->dataValueFactory->newFromArray( $descriptionValue['value'] ),
				$descriptionValue['comparator']
			);
		}

		if ( $descriptionType === 'conjunction' ) {
			return new Conjunction(
				$this->deserializeDescriptions( $descriptionValue['descriptions'] )
			);
		}

		if ( $descriptionType === 'disjunction' ) {
			return new Disjunction(
				$this->deserializeDescriptions( $descriptionValue['descriptions'] )
			);
		}

		// TODO: handle desc type unknown
		// TODO: validate elements are there
		// TODO: validate element types
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
