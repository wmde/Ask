<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\ValueDescription;
use DataValues\NumberValue;
use DataValues\StringValue;

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
			new StringValue( 'ohi there' ),
			new NumberValue( 4.2 ),
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

	/**
	 * @dataProvider invalidComparatorProvider
	 */
	public function testCannotConstructWithInvalidComparator( $invalidComparator ) {
		$this->setExpectedException( 'InvalidArgumentException' );
		new ValueDescription( new StringValue( 'foo' ), $invalidComparator );
	}

	public function invalidComparatorProvider() {
		return array(
			array( null ),
			array( array() ),
			array( 4.2 ),
			array( true ),
			array( 'foo' ),
			array( '' ),
		);
	}

}
