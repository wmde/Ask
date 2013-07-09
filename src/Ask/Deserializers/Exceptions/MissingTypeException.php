<?php

namespace Ask\Deserializers\Exceptions;

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
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $message = '', \Exception $previous = null ) {
		parent::__construct( $message, $previous );
	}

}
