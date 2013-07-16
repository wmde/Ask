<?php

namespace Ask;

use Ask\Deserializers\DescriptionDeserializer;
use Ask\Deserializers\QueryDeserializer;
use Ask\Deserializers\QueryOptionsDeserializer;
use Ask\Deserializers\SelectionRequestDeserializer;
use Ask\Deserializers\SortExpressionDeserializer;
use DataValues\DataValueFactory;
use Deserializers\Deserializer;
use Deserializers\DispatchingDeserializer;

/**
 * Factory for constructing Deserializer objects that can deserialize Ask language objects.
 * All external access to the deserializers should happen through this factory! (See README)
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Adam Shorland < adamshorland@gmail.com >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DeserializerFactory {

	protected $dataValueFactory;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
	}

	/**
	 * Returns a Deserializer that can serialize Query objects.
	 *
	 * @since 0.1
	 *
	 * @return Deserializer
	 */
	public function newQueryDeserializer() {
		$dispatchingDeserializer = new DispatchingDeserializer();

		$dispatchingDeserializer->addDeserializer( $this->newDescriptionDeserializer() );
		$dispatchingDeserializer->addDeserializer( $this->newSelectionRequestDeserializer() );
		$dispatchingDeserializer->addDeserializer( $this->newSortExpressionDeserializer() );
		$dispatchingDeserializer->addDeserializer( $this->newQueryOptionsDeserializer() );

		return new QueryDeserializer( $dispatchingDeserializer );
	}

	/**
	 * Returns a Deserializer that can serialize Description objects.
	 *
	 * @since 0.1
	 *
	 * @return Deserializer
	 */
	public function newDescriptionDeserializer() {
		return new DescriptionDeserializer( $this->dataValueFactory );
	}

	/**
	 * Returns a Deserializer that can serialize SelectionRequest objects.
	 *
	 * @since 0.1
	 *
	 * @return Deserializer
	 */
	public function newSelectionRequestDeserializer() {
		return new SelectionRequestDeserializer( $this->dataValueFactory );
	}

	/**
	 * Returns a Deserializer that can serialize SortExpression objects.
	 *
	 * @since 0.1
	 *
	 * @return Deserializer
	 */
	public function newSortExpressionDeserializer() {
		return new SortExpressionDeserializer( $this->dataValueFactory );
	}

	/**
	 * Returns a Deserializer that can serialize QueryOptions objects.
	 *
	 * @since 0.1
	 *
	 * @return Deserializer
	 */
	public function newQueryOptionsDeserializer() {
		return new QueryOptionsDeserializer( $this->newSortExpressionDeserializer() );
	}

}
