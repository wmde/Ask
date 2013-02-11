<?php

/**
 * Class registration file for the Ask library.
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
return array(

	'Ask\Immutable' => 'includes/Immutable.php',

	'Ask\Language\Description\AnyValue' => 'includes/language/description/AnyValue.php',
	'Ask\Language\Description\Conjunction' => 'includes/language/description/Conjunction.php',
	'Ask\Language\Description\Description' => 'includes/language/description/Description.php',
	'Ask\Language\Description\DescriptionCollection' => 'includes/language/description/DescriptionCollection.php',
	'Ask\Language\Description\Disjunction' => 'includes/language/description/Disjunction.php',
	'Ask\Language\Description\SomeProperty' => 'includes/language/description/SomeProperty.php',
	'Ask\Language\Description\ValueDescription' => 'includes/language/description/ValueDescription.php',

	'Ask\Language\PrintRequest\PrintRequest' => 'includes/language/printrequest/PrintRequest.php',
	'Ask\Language\PrintRequest\PropertyPrintRequest' => 'includes/language/printrequest/PropertyPrintRequest.php',
	'Ask\Language\PrintRequest\ThisPrintRequest' => 'includes/language/printrequest/ThisPrintRequest.php',

);
