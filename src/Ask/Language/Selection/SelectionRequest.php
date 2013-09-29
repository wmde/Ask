<?php

namespace Ask\Language\Selection;

/**
 * Base class for selection requests.
 *
 * A print request specifies that a certain value should be displayed
 * and in what manner this display should happen.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class SelectionRequest implements \Ask\Comparable, \Ask\Hashable, \Ask\Typeable {

	const TYPE_PROP = 'property';
	const TYPE_SUBJECT = 'subject';

}
