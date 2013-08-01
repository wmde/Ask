<?php

namespace Ask\Tests\Phpunit\Language\Selection;

use Ask\Language\Selection\SubjectSelection;

/**
 * @covers Ask\Language\Selection\SubjectSelection
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
class SubjectSelectionTest extends SelectionRequestTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new SubjectSelection();

		return $instances;
	}

}
