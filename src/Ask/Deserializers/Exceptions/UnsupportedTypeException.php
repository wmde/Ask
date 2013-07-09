<?php

namespace Ask\Deserializers\Exceptions;

use Ask\Deserializers\Deserializer;

/**
 * Indicates the objectType specified in the serialization is not supported by a deserializer.
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UnsupportedTypeException extends DeserializationException {

	protected $unsupportedType;

	/**
	 * @param mixed $unsupportedType
	 * @param Deserializer $deserializer
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $unsupportedType, Deserializer $deserializer, $message = '', \Exception $previous = null ) {
		$this->unsupportedType = $unsupportedType;

		parent::__construct( $deserializer, $message, $previous );
	}

	/**
	 * @return mixed
	 */
	public function getUnsupportedType() {
		return $this->unsupportedType;
	}

}
