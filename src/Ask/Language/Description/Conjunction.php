<?php

namespace Ask\Language\Description;

/**
 * Description of a collection of many descriptions, all of which
 * must be satisfied (AND, conjunction).
 *
 * Corresponds to conjunction in OWL and SPARQL. Not available in RDFS.
 *
 * Based on SMWConjunction
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class Conjunction extends DescriptionCollection {

	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return 'conjunction';
	}

}