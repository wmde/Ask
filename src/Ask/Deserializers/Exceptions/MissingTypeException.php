<?php

namespace Ask\Deserializers\Exceptions;

use Ask\Deserializers\Deserializer;

/**
 * Indicates the objectType key is missing in the serialization.
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MissingTypeException extends DeserializationException {

	protected $unsupportedType;

	/**
	 * @param Deserializer $deserializer
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( Deserializer $deserializer, $message = '', \Exception $previous = null ) {
		parent::__construct( $deserializer, $message, $previous );
	}

}
