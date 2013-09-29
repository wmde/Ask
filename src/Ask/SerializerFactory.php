<?php

namespace Ask;

use Ask\Serializers\DescriptionSerializer;
use Ask\Serializers\QueryOptionsSerializer;
use Ask\Serializers\QuerySerializer;
use Ask\Serializers\SelectionRequestSerializer;
use Ask\Serializers\SortExpressionSerializer;
use Serializers\DispatchingSerializer;
use Serializers\Serializer;

/**
 * Factory for constructing Serializer objects that can serialize Ask language objects.
 * All external access to the serializers should happen through this factory! (See README)
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Adam Shorland < adamshorland@gmail.com >
 */
class SerializerFactory {

	/**
	 * Returns a Serializer that can serialize Query objects.
	 *
	 * @since 1.0
	 *
	 * @return Serializer
	 */
	public function newQuerySerializer() {
		$dispatchingSerializer = new DispatchingSerializer();

		$dispatchingSerializer->addSerializer( $this->newDescriptionSerializer() );
		$dispatchingSerializer->addSerializer( $this->newSelectionRequestSerializer() );
		$dispatchingSerializer->addSerializer( $this->newQueryOptionsSerializer() );

		return new QuerySerializer( $dispatchingSerializer );
	}

	/**
	 * Returns a Serializer that can serialize Description objects.
	 *
	 * @since 1.0
	 *
	 * @return Serializer
	 */
	public function newDescriptionSerializer() {
		return new DescriptionSerializer();
	}

	/**
	 * Returns a Serializer that can serialize SelectionRequest objects.
	 *
	 * @since 1.0
	 *
	 * @return Serializer
	 */
	public function newSelectionRequestSerializer() {
		return new SelectionRequestSerializer();
	}

	/**
	 * Returns a Serializer that can serialize SortExpression objects.
	 *
	 * @since 1.0
	 *
	 * @return Serializer
	 */
	public function newSortExpressionSerializer() {
		return new SortExpressionSerializer();
	}

	/**
	 * Returns a Serializer that can serialize QueryOptions objects.
	 *
	 * @since 1.0
	 *
	 * @return Serializer
	 */
	public function newQueryOptionsSerializer() {
		return new QueryOptionsSerializer( $this->newSortExpressionSerializer() );
	}

}
