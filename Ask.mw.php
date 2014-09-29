<?php

/**
 * MediaWiki setup for the Ask extension.
 * The extension should be included via the main entry point, Ask.php.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$GLOBALS['wgExtensionCredits']['other'][] = array(
	'path' => __FILE__,
	'name' => 'Ask',
	'version' => Ask_VERSION,
	'author' => array(
		'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',

		// A big part of this library is conceptually based on code from Semantic MediaWiki 1.9 written by Markus
		'Markus Krötzsch',
	),
	'url' => 'https://github.com/wmde/Ask',
	'descriptionmsg' => 'ask-desc',
	'license-name' => 'GPL-2.0+'
);

$GLOBALS['wgMessagesDirs']['AskExtension'] = __DIR__ . '/i18n';
$GLOBALS['wgExtensionMessagesFiles']['AskExtension'] = __DIR__ . '/Ask.i18n.php';
