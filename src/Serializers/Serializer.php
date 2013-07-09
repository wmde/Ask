<?php

namespace Serializers;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Serializer {

	/**
	 * @since 0.1
	 *
	 * @param mixed $askObject
	 *
	 * @return array|int|string|bool|float A possibly nested structure consisting of only arrays and scalar values
	 */
	public function serialize( $askObject );

	/**
	 * @since 0.1
	 *
	 * @param mixed $askObject
	 *
	 * @return boolean
	 */
	public function canSerialize( $askObject );

}
