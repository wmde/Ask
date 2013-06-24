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
abstract class SerializationException extends \RuntimeException {

	protected $serializer;

	public function __construct( Serializer $serializer, $message = '', \Exception $previous = null ) {
		$this->serializer = $serializer;

		parent::__construct( $message, 0, $previous );
	}

	/**
	 * @return Serializer
	 */
	public function getSerializer() {
		return $this->serializer;
	}

}
