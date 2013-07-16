<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Strategies\SortExpressionDeserializationStrategy;
use DataValues\DataValueFactory;
use Deserializers\Deserializer;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\StrategicDeserializer;

/**
 * @since 1.0
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SortExpressionDeserializer implements Deserializer {

	protected $dataValueFactory;
	protected $deserializer;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
		$this->deserializer = $this->newDeserializer();
	}

	protected function newDeserializer() {
		return new StrategicDeserializer(
			new SortExpressionDeserializationStrategy( $this->dataValueFactory ),
			'sortExpression',
			'sortExpressionType'
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
	 * @see Deserializer::canDeserialize
	 *
	 * @since 1.0
	 *
	 * @param mixed $serialization
	 *
	 * @return boolean
	 */
	public function canDeserialize( $serialization ) {
		return $this->deserializer->canDeserialize( $serialization );
	}

}
