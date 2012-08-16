<?php

// Catalan:
// =======

// Spain:
$r['ca'] = array ( // Default / male:/*{{{*/

	'@label' => array (
		'ca' => 'Català',
		'en' => 'Catalan',
		'es' => 'Catalán',
		'de' => 'Katalanisch',
	)

	'n0' => 'zero',
	'n1' => 'un',
	'n2' => 'dos',
	'n3' => 'tres',
	'n4' => 'quatre',
	'n5' => 'cinc',
	'n6' => 'sis',
	'n7' => 'set',
	'n8' => 'vuit',
	'n9' => 'nou',

	'n10' => 'deu',
	'n11' => 'onze',
	'n12' => 'dotze',
	'n13' => 'tretze',
	'n14' => 'catorze',
	'n15' => 'quinze',
	'n16' => 'setze',
	'n17' => 'disset',
		'r17' => 'd[ie]ss?et',

	'n1x' => 'di',
		'r1x' => 'd[ie]',

	'n20' => 'vint',
	'n2x' => 'vint-i-',
	'n30' => 'trenta',
	'n3x' => 'trenta-',
	'n40' => 'quaranta',
		'r40' => '(?:qua|cua|co)ranta',
	'n4x' => 'quaranta-',
		'r4x' => '(?:qua|cua|co)ranta-',
	'n50' => 'cinquanta',
		'r50' => 'cin[qc]uanta',
	'n5x' => 'cinquanta-',
		'r5x' => 'cin[qc]uanta-',
	'n60' => 'seixanta',
		'r60' => '(?:sei|xei|xe|xi)xanta',
	'n6x' => 'seixanta-',
		'r6x' => '(?:sei|xei|xe|xi)xanta-',
	'n70' => 'setanta',
	'n7x' => 'setanta-',
	'n80' => 'vuitanta',
	'n8x' => 'vuitanta-',
	'n90' => 'noranta',
	'n9x' => 'noranta-',

	'n100' => 'cent',
	'n1xx' => 'cent ',
	'nx00' => '-cents',
	'nxxx' => '-cents ',
	'n0xx' => '',

	'n1000' => 'mil',
	'n1xxx' => 'mil ',
	'nx000' => ' mil',
	'nxxxx' => ' mil ',
	'n0xxx' => '',

	'n1000000' => 'un milió',
	'n1xxxxxx' => 'un milió ',
	'nx000000' => array (' milions', 'ca'),
	'nxxxxxxx' => array (' milions ', 'ca'),
	'n0xxxxxx' => '',

	/* Not used colloquially.
	'n1000000000' => 'un miliard',
	'n1xxxxxxxxx' => 'un miliard ',
	'nx000000000' => ' miliards',
	'nxxxxxxxxxx' => ' miliards ',
	'n0xxxxxxxxx' => '',
	 */

	'n1000000000000' => 'un bilió',
	'n1xxxxxxxxxxxx' => 'un bilió ',
	'nx000000000000' => ' bilions',
	'nxxxxxxxxxxxxx' => ' bilions ',
	'n0xxxxxxxxxxxx' => '',

	'n1000000000000000000' => 'un trilió',
	'n1xxxxxxxxxxxxxxxxxx' => 'un trilió ',
	'nx000000000000000000' => ' trilions',
	'nxxxxxxxxxxxxxxxxxxx' => ' trilions ',
	'n0xxxxxxxxxxxxxxxxxx' => '',

);/*}}}*/


$r['ca_fem'] = array ( // Female variations:/*{{{*/

	'@label' => 'femení',
	'@import' => 'ca',

	'n1' => 'una',
	'n2' => 'dues',

	'nx00' => array ('-centes', 'ca'),
	'nxxx' => array ('-centes ', 'ca'),

	'n2000' => 'dos mil',
	'n2xxx' => 'dos mil ',

);/*}}}*/

return $r;
