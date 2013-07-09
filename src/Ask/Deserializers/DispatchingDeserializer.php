<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
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
class DispatchingDeserializer implements Deserializer {

	/**
	 * @var Deserializer[]
	 */
	protected $deserializers;

	/**
	 * @param Deserializer[] $deserializers
	 */
	public function __construct( array $deserializers = array() ) {
		$this->assertAreDeserializers( $deserializers );
		$this->deserializers = $deserializers;
	}

	protected function assertAreDeserializers( array $deserializers ) {
		foreach ( $deserializers as $deserializer ) {
			if ( !is_object( $deserializer ) || !( $deserializer instanceof Deserializer ) ) {
				throw new InvalidArgumentException( 'All $deserializers need to implement the Deserializer interface' );
			}
		}
	}

	public function deserialize( $serialization ) {
		foreach ( $this->deserializers as $deserializer ) {
			if ( $deserializer->canDeserialize( $serialization ) ) {
				return $deserializer->deserialize( $serialization );
			}
		}

		throw new DeserializationException(
			'None of the deserializers can deserialize the provided serialization'
		);
	}

	public function canDeserialize( $serialization ) {
		foreach ( $this->deserializers as $deserializer ) {
			if ( $deserializer->canDeserialize( $serialization ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @since 0.1
	 *
	 * @param Deserializer $serializer
	 */
	public function addDeserializer( Deserializer $serializer ) {
		$this->deserializers[] = $serializer;
	}

}
