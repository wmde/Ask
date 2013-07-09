<?php

namespace Ask\Deserializers\Exceptions;

use Ask\Deserializers\Deserializer;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DeserializationException extends \RuntimeException {

	protected $deserializer;

	public function __construct( Deserializer $deserializer, $message = '', \Exception $previous = null ) {
		$this->deserializer = $deserializer;

		parent::__construct( $message, 0, $previous );
	}

	/**
	 * @return Deserializer
	 */
	public function getDeserializer() {
		return $this->deserializer;
	}

}
