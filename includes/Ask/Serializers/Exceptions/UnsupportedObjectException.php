<?php

namespace Ask\Serializers\Exceptions;

use Ask\Serializers\Serializer;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UnsupportedObjectException extends SerializationException {

	protected $unsupportedObject;

	/**
	 * @param mixed $unsupportedObject
	 * @param Serializer $serializer
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $unsupportedObject, Serializer $serializer, $message = '', \Exception $previous = null ) {
		$this->unsupportedObject = $unsupportedObject;

		parent::__construct( $serializer, $message, $previous );
	}

	/**
	 * @return mixed
	 */
	public function getUnsupportedObject() {
		return $this->unsupportedObject;
	}

}
