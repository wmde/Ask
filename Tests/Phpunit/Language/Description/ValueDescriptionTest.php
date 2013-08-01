<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\ValueDescription;

/**
 * @covers Ask\Language\Description\ValueDescription
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
class ValueDescriptionTest extends DescriptionTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$values = array(
			new \DataValues\StringValue( 'ohi there' ),
			new \DataValues\NumberValue( 4.2 ),
			new \DataValues\MonolingualTextValue( 'en', 'ohi there' ),
		);

		$comparators = array(
			ValueDescription::COMP_EQUAL,
			ValueDescription::COMP_LEQ,
			ValueDescription::COMP_GEQ,
			ValueDescription::COMP_NEQ,
			ValueDescription::COMP_LIKE,
			ValueDescription::COMP_NLIKE,
			ValueDescription::COMP_LESS,
			ValueDescription::COMP_GREATER,
		);

		foreach ( $values as $value ) {
			foreach ( $comparators as $comparator ) {
				$instances[] = new ValueDescription( $value, $comparator );
			}
		}

		return $instances;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param ValueDescription $description
	 */
	public function testGetValue( ValueDescription $description ) {
		$value = $description->getValue();

		$this->assertInstanceOf( 'DataValues\DataValue', $value );

		$newInstance = new ValueDescription( $value );

		$this->assertTrue( $value->equals( $newInstance->getValue() ), 'Value is returned as it was passed to the constructor' );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param ValueDescription $description
	 */
	public function testGetComparator( ValueDescription $description ) {
		$comparator = $description->getComparator();

		$this->assertInternalType( 'integer', $comparator );

		$newInstance = new ValueDescription( $description->getValue(), $comparator );

		$this->assertEquals( $comparator, $newInstance->getComparator(), 'Comparator is returned as it was passed to the constructor' );
	}

}
