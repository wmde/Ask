<?php

namespace Ask\Deserializers\Exceptions;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class InvalidAttributeException extends DeserializationException {

	protected $attributeName;
	protected $attributeValue;

	/**
	 * @param string $attributeName
	 * @param mixed $attributeValue
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $attributeName, $attributeValue, $message = '', \Exception $previous = null ) {
		$this->attributeName = $attributeName;
		$this->attributeValue = $attributeValue;

		parent::__construct( $message, $previous );
	}

	/**
	 * @return string
	 */
	public function getAttributeName() {
		return $this->attributeName;
	}

	/**
	 * @return string
	 */
	public function getAttributeValue() {
		return $this->attributeValue;
	}

}
