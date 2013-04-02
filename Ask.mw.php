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
	$wgAutoloadClasses[$class] = __DIR__ . '/' . $file;
}

if ( defined( 'MW_PHPUNIT_TEST' ) ) {
	foreach ( include( __DIR__ . '/Tests/AskTestClasses.php' ) as $class => $file ) {
		$wgAutoloadClasses[$class] = __DIR__ . '/../' . $file;
	}
}

/**
 * Hook to add PHPUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
 *
 * TODO: register the Tests directory itself so this list does not need to be maintained
 *
 * @since 0.1
 *
 * @param array $files
 *
 * @return boolean
 */
$wgHooks['UnitTestsList'][]	= function( array &$files ) {
	// @codeCoverageIgnoreStart
	$testFiles = array(
		'Language/Description/AnyValue',
		'Language/Description/Conjunction',
		'Language/Description/SomeProperty',
		'Language/Description/Disjunction',
		'Language/Description/ValueDescription',

		'Language/Option/PropertyValueSortExpression',
		'Language/Option/QueryOptions',
		'Language/Option/SortOptions',

		'Language/Selection/PropertySelection',
		'Language/Selection/SubjectSelection',

		'Language/Query',
	);

	foreach ( $testFiles as $file ) {
		$files[] = __DIR__ . '/Tests/Phpunit/' . $file . 'Test.php';
	}

	return true;
	// @codeCoverageIgnoreEnd
};
