<?php

/**
 * MediaWiki setup for the Ask extension.
 * The extension should be included via the main entry point, Ask.php.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

global $wgExtensionCredits, $wgExtensionMessagesFiles, $wgAutoloadClasses, $wgHooks;

$wgExtensionCredits['other'][] = include( __DIR__ . '/Ask.credits.php' );

$wgExtensionMessagesFiles['AskExtension'] = __DIR__ . '/Ask.i18n.php';

// Autoloading
foreach ( include( __DIR__ . '/Ask.classes.php' ) as $class => $file ) {
	if ( !array_key_exists( $class, $GLOBALS['wgAutoloadLocalClasses'] ) ) {
		$wgAutoloadClasses[$class] = __DIR__ . '/' . $file;
	}
}

/**
 * Hook to add PHPUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
 *
 * @since 0.1
 *
 * @param array $files
 *
 * @return boolean
 */
$wgHooks['UnitTestsList'][]	= function( array &$files ) {
	// @codeCoverageIgnoreStart
	global $wgAutoloadClasses;

	$wgAutoloadClasses['Ask\Tests\AskTestCase']
		= __DIR__ . '/tests/phpunit/AskTestCase.php';

	$wgAutoloadClasses['Ask\Tests\Language\Description\DescriptionTest']
		= __DIR__ . '/tests/phpunit/language/description/DescriptionTest.php';

	$wgAutoloadClasses['Ask\Tests\Language\PrintRequest\PrintRequestTest']
		= __DIR__ . '/tests/phpunit/language/printrequest/PrintRequestTest.php';

	$testFiles = array(
		'language/description/AnyValue',
		'language/description/Conjunction',
		'language/description/SomeProperty',
		'language/description/Disjunction',
		'language/description/ValueDescription',

		'language/printrequest/PropertyPrintRequest',
		'language/printrequest/ThisPrintRequest',
	);

	foreach ( $testFiles as $file ) {
		$files[] = __DIR__ . '/tests/phpunit/' . $file . 'Test.php';
	}

	return true;
	// @codeCoverageIgnoreEnd
};
