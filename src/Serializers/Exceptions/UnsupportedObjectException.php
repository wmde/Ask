<?php

namespace Serializers\Exceptions;

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
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $unsupportedObject, $message = '', \Exception $previous = null ) {
		$this->unsupportedObject = $unsupportedObject;

		parent::__construct( $message, $previous );
	}

	/**
	 * @return mixed
	 */
	public function getUnsupportedObject() {
		return $this->unsupportedObject;
	}

}
