<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Strategies\SelectionRequestDeserializationStrategy;
use DataValues\DataValueFactory;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\StrategicDeserializer;
use Deserializers\TypedObjectDeserializer;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SelectionRequestDeserializer extends TypedObjectDeserializer {

	protected $dataValueFactory;
	protected $deserializer;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
		$this->deserializer = $this->newDeserializer();
	}

	protected function newDeserializer() {
		return new StrategicDeserializer(
			new SelectionRequestDeserializationStrategy(
				$this->dataValueFactory,
				$this
			),
			'selectionRequest',
			'selectionRequestType'
		);
	}

	/**
	 * @see Deserializer::deserialize
	 *
	 * @since 1.0
	 *
	 * @param mixed $serialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function deserialize( $serialization ) {
		return $this->deserializer->deserialize( $serialization );
	}

	/**
	 * @see Deserializer::isDeserializerFor
	 *
	 * @since 1.0
	 *
	 * @param mixed $serialization
	 *
	 * @return boolean
	 */
	public function isDeserializerFor( $serialization ) {
		return $this->deserializer->isDeserializerFor( $serialization );
	}

}
