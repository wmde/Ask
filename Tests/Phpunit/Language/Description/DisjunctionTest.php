<?php

namespace Ask\Tests\Phpunit\Language\Description;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\DescriptionCollection;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\ValueDescription;
use DataValues\StringValue;

/**
 * @covers Ask\Language\Description\Disjunction
 * @covers Ask\Language\Description\DescriptionCollection
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
class DisjunctionTest extends DescriptionCollectionTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new Disjunction( array() );
		$instances[] = new Disjunction( array( new Conjunction( array() ) ) );
		$instances[] = new Disjunction( array( new Disjunction( array() ), new Disjunction( array() ) ) );
		$instances[] = new Disjunction( array( new AnyValue() ) );
		$instances[] = new Disjunction( array( new ValueDescription( new StringValue( 'ohi' ) ) ) );

		foreach ( $this->descriptionsProvider() as $argList ) {
			$instances[] = new Disjunction( $argList[0] );
		}

		return $instances;
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 1.0
	 *
	 * @param Disjunction $description
	 */
	public function testGetDescriptions( Disjunction $description ) {
		$descriptions = $description->getDescriptions();

		$this->assertInternalType( 'array', $descriptions );

		foreach ( $descriptions as $subInstance ) {
			$this->assertInstanceOf( 'Ask\Language\Description\Description', $subInstance );
		}

		$newInstance = new Disjunction( $descriptions );

		$this->assertEquals( $descriptions, $newInstance->getDescriptions(), 'Descriptions are returned as it was passed to the constructor' );
	}

	/**
	 * @see DescriptionCollectionTest::newFromDescriptions
	 *
	 * @param Description[] $descriptions
	 *
	 * @return DescriptionCollection
	 */
	protected function newFromDescriptions( array $descriptions ) {
		return new Disjunction( $descriptions );
	}

}
