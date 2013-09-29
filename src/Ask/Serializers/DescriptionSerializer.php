<?php

namespace Ask\Serializers;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Description;
use Ask\Language\Description\DescriptionCollection;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionSerializer implements Serializer {

	public function serialize( $object ) {
		$this->assertCanSerialize( $object );
		return $this->getSerializedDescription( $object );
	}

	protected function getSerializedDescription( Description $description ) {
		return array(
			'objectType' => 'description',
			'descriptionType' => $description->getType(),
			'value' => $this->getDescriptionValueSerialization( $description ),
		);
	}

	protected function getDescriptionValueSerialization( Description $description ) {
		if ( $description instanceof AnyValue ) {
			return array();
		}

		if ( $description instanceof SomeProperty ) {
			return array(
				'property' => $description->getPropertyId()->toArray(),
				'description' => $this->serialize( $description->getSubDescription() ),
				'isSubProperty' => $description->isSubProperty(),
			);
		}

		if ( $description instanceof ValueDescription ) {
			return array(
				'value' => $description->getValue()->toArray(),
				'comparator' => $this->getStringForComparator( $description->getComparator() ),
			);
		}

		if ( $description instanceof DescriptionCollection ) {
			$serializationMethod = array( $this, 'serialize' );

			return array(
				'descriptions' => array_map(
					function( Description $description ) use ( $serializationMethod ) {
						return call_user_func( $serializationMethod, $description );
					},
					$description->getDescriptions()
				)
			);
		}

		throw new UnsupportedObjectException( $description );
	}

	protected function getStringForComparator( $comparator ) {
		$comparatorStrings = array(
			ValueDescription::COMP_EQUAL => 'equal',
			ValueDescription::COMP_LEQ => 'leq',
			ValueDescription::COMP_GEQ => 'geq',
			ValueDescription::COMP_NEQ => 'neq',
			ValueDescription::COMP_LIKE => 'like',
			ValueDescription::COMP_NLIKE => 'nlike',
			ValueDescription::COMP_LESS => 'less',
			ValueDescription::COMP_GREATER => 'greater'
		);

		return $comparatorStrings[$comparator];
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->isSerializerFor( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject );
		}
	}

	public function isSerializerFor( $askObject ) {
		return $askObject instanceof Description;
	}

}
