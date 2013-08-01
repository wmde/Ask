<?php

namespace Ask\Tests\Phpunit\Language\Selection;

use Ask\Language\Selection\PropertySelection;
use DataValues\StringValue;

/**
 * @covers Ask\Language\Selection\PropertySelection
 *
 * @since 1.0
 *
 * @file
 * @ingroup AskTests
 *
 * @group Ask
 * @group AskSelection
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class PropertySelectionTest extends SelectionRequestTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new PropertySelection(
			new StringValue( 'p42' )
		);

		$instances[] = new PropertySelection(
			new StringValue( '_geo' )
		);

		return $instances;
	}

}
