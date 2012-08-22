<?php
# vim configuration:
# vim:foldmethod=marker
#
# HINT: If you are using vim, foldmethod=marker is automatically enabled.
#     Use 'za' to expand/hide folds.
#     Type :help folding to learn more about vim folding.

// Catalan:
// =======

// Spain:
$r['ca'] = array ( // Default / male:/*{{{*/

	'@label' => array (
		'ca' => 'Català',
		'en' => 'Catalan',
		'es' => 'Catalán',
		'de' => 'Katalanisch',
	),
	'$units' => 'ca',

	'@import' => 'ca_fem', // Usat per fraccions.

	'@decimal' => '.',

	'@fractions' => array (
		' amb ',
		1 => array (' dècima', ' dècimes', 'ca_fem'),
		2 => array (' centèssima', ' centèssimes', 'ca_fem'),
		3 => array (' milèssima', ' milèssimes', 'ca_fem'),
		6 => array (' milionèssima', ' milionèssimes', 'ca_fem'),
	),


	'n-' => 'menys ',
	'n.' => ' coma ',
	'n.0' => 'zero ',

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

	'n100' => array ('cent', '$units'),
	'n1xx' => array ('cent ', '$units'),
	'nx00' => array ('-cents', '$units'),
	'nxxx' => array ('-cents ', '$units'),
	'n0xx' => '',

	'n1000' => 'mil',
	'n1xxx' => 'mil ',
	'nx000' => array (' mil', '$units'),
	'nxxxx' => array (' mil ', '$units'),
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
	'nx000000000000' => array (' bilions', 'ca'),
	'nxxxxxxxxxxxxx' => array (' bilions ', 'ca'),
	'n0xxxxxxxxxxxx' => '',

	'n1000000000000000000' => 'un trilió',
	'n1xxxxxxxxxxxxxxxxxx' => 'un trilió ',
	'nx000000000000000000' => array (' trilions', 'ca'),
	'nxxxxxxxxxxxxxxxxxxx' => array (' trilions ', 'ca'),
	'n0xxxxxxxxxxxxxxxxxx' => '',

);/*}}}*/


$r['ca_fem'] = array ( // Female variation:/*{{{*/

	'@label' => 'femení',
	'@import' => 'ca',
	'$units' => 'ca_fem',

	'n1' => 'una',
	'n2' => 'dues',

	'nx00' => array ('-centes', 'ca'),
	'nxxx' => array ('-centes ', 'ca'),

	'n2000' => 'dos mil',
	'n2xxx' => 'dos mil ',

);/*}}}*/


$r['ca_ord'] = array ( // Ordinal (male) variation:/*{{{*/

	'@label' => 'ordinals',
	'@import' => 'ca',

	'n1' => 'primer',
	'n2' => 'segon',
	'n3' => 'tercer',
	'n4' => 'quart',
	'n5' => 'cinquè',
	'n6' => 'sisè',
	'n7' => 'setè',
	'n8' => 'vuitè',
	'n9' => 'novè',

	'n10' => 'desè',
	'n11' => 'onzè',
	'n12' => 'dotzè',
	'n13' => 'tretzè',
	'n14' => 'catorzè',
	'n15' => 'quinzè',
	'n16' => 'setzè',
	'n17' => 'dissetè',
	'n18' => 'divuitè',
	'n19' => 'dinovè',
	'n20' => 'vintè',

	'n_1' => 'unè',
	'n_2' => 'dosè',
	'n_3' => 'tresé',
	'n_4' => 'quatrè',

);/*}}}*/


$r['ca_ord_fem'] = array ( // Ordinal (male) variation:/*{{{*/

	'@label' => 'ordinals femenins',
	'@import' => array (
		'ca_fem',
		'ca'
	),

	'n1' => 'primera',
	'n2' => 'segona',
	'n3' => 'tercera',
	'n4' => 'quarta',
	'n5' => 'cinquena',
	'n6' => 'sisena',
	'n7' => 'setena',
	'n8' => 'vuitena',
	'n9' => 'novena',

	'n10' => 'desena',
	'n11' => 'onzena',
	'n12' => 'dotzena',
	'n13' => 'tretzena',
	'n14' => 'catorzena',
	'n15' => 'quinzena',
	'n16' => 'setzena',
	'n17' => 'dissetena',
	'n18' => 'divuitena',
	'n19' => 'dinovena',
	'n20' => 'vintena',

	'n_1' => 'unena',
	'n_2' => 'dosena',
	'n_3' => 'tresena',
	'n_4' => 'quatrena',

);/*}}}*/

return $r;
