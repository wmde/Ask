<?php

namespace Ask\Serializers;

use Ask\Serializers\Exceptions\UnsupportedObjectException;
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
class DispatchingSerializer implements Serializer {

	/**
	 * @var Serializer[]
	 */
	protected $serializers;

	public function __construct( array $serializers = array() ) {
		$this->assertAreSerializers( $serializers );
		$this->serializers = $serializers;
	}

	protected function assertAreSerializers( array $serializers ) {
		foreach ( $serializers as $serializer ) {
			if ( !( $serializer instanceof Serializer ) ) {
				throw new InvalidArgumentException( 'Got an object that is not an instance of Ask\Serializers\Serializer' );
			}
		}
	}

	public function serialize( $askObject ) {
		foreach ( $this->serializers as $serializer ) {
			if ( $serializer->canSerialize( $askObject ) ) {
				return $serializer->serialize( $askObject );
			}
		}

		throw new UnsupportedObjectException( $askObject, $this );
	}

	public function canSerialize( $askObject ) {
		foreach ( $this->serializers as $serializer ) {
			if ( $serializer->canSerialize( $askObject ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @since 0.1
	 *
	 * @param Serializer $serializer
	 */
	public function addSerializer( Serializer $serializer ) {
		$this->serializers[] = $serializer;
	}

}
