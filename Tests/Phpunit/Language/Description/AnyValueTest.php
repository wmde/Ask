<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\AnyValue;

/**
 * @covers Ask\Language\Description\AnyValue
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @group Ask
 * @group AskDescription
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class AnyValueTest extends DescriptionTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new AnyValue();

		return $instances;
	}

}
