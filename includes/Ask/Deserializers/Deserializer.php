<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Deserializer {

	/**
	 * @since 0.1
	 *
	 * @param mixed $serialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function deserialize( $serialization );

	/**
	 * @since 0.1
	 *
	 * @param mixed $serialization
	 *
	 * @return boolean
	 */
	public function canDeserialize( $serialization );

}
