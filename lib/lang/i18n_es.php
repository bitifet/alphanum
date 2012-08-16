<?php

// Castellano:
// ==========

// Spain:
$r['es'] = array ( // Default / male:/*{{{*/

	'@label' => array (
		'es' => 'Castellano',
		'ca' => 'Castellà',
		'en' => 'Spanish',
		'de' => 'Spanisch',
	),

	'n0' => 'cero',
	'n1' => 'uno',
	'n2' => 'dos',
	'n3' => 'tres',
	'n4' => 'cuatro',
	'n5' => 'cinco',
	'n6' => 'seis',
	'n7' => 'siete',
	'n8' => 'ocho',
	'n9' => 'nueve',

	'n10' => 'diez',
	'n11' => 'once',
	'n12' => 'doce',
	'n13' => 'trece',
	'n14' => 'catorce',
	'n15' => 'quince',

	'n1x' => 'dieci',
		'r1x' => 'di?eci',

	'n20' => 'veinte',
	'n2x' => 'veinti',
	'n30' => 'treinta',
	'n3x' => 'treinta y ',
	'n40' => 'cuarenta',
		'r40' => 'cuarei?nta',
	'n4x' => 'cuarenta y ',
		'r4x' => 'cuarei?nta y ',
	'n50' => 'cincuenta',
	'n5x' => 'cincuenta y ',
	'n60' => 'sesenta',
	'n6x' => 'sesenta y ',
	'n70' => 'setenta',
	'n7x' => 'setenta y ',
	'n80' => 'ochenta',
	'n8x' => 'ochenta y ',
	'n90' => 'noventa',
	'n9x' => 'noventa y ',

	'n100' => 'cién',
		'r100' => 'ci[eé]n',
	'n1xx' => 'ciento ',
	'nx00' => 'cientos',
	'nxxx' => 'cientos ',
	'n0xx' => '',
	'n500' => 'quinientos',
	'n5xx' => 'quinientos ',
	'n700' => 'setecientos',
	'n7xx' => 'setecientos ',
	'n900' => 'novecientos',
	'n9xx' => 'novecientos ',

	'n1000' => 'mil',
	'n1xxx' => 'mil ',
	'nx000' => ' mil',
	'nxxxx' => ' mil ',
	'n0xxx' => '',

	'n1000000' => 'un millón',
		'r1000000' => 'un mill[oó]n',
	'n1xxxxxx' => 'un millón ',
		'r1xxxxxx' => 'un mill[oó]n ',
	'nx000000' => ' miliones',
	'nxxxxxxx' => ' miliones ',
	'n0xxxxxx' => '',

	/* Not used colloquially.
	'n1000000000' => 'un millardo',
	'n1xxxxxxxxx' => 'un millardo ',
	'nx000000000' => ' millardos',
	'nxxxxxxxxxx' => ' millardos ',
	'n0xxxxxxxxx' => '',
	 */

	'n1000000000000' => 'un billón',
		'r1000000000000' => 'un bill[oó]n',
	'n1xxxxxxxxxxxx' => 'un billón ',
		'r1xxxxxxxxxxxx' => 'un bill[oó]n ',
	'nx000000000000' => ' billones',
	'nxxxxxxxxxxxxx' => ' billones ',
	'n0xxxxxxxxxxxx' => '',

	'n1000000000000000000' => 'un trillón',
		'r1000000000000000000' => 'un trill[oó]n',
	'n1xxxxxxxxxxxxxxxxxx' => 'un trillón ',
		'r1xxxxxxxxxxxxxxxxxx' => 'un trill[oó]n ',
	'nx000000000000000000' => ' trillones',
	'nxxxxxxxxxxxxxxxxxxx' => ' trillones ',
	'n0xxxxxxxxxxxxxxxxxx' => '',

);/*}}}*/

$r['es_fem'] = array ( // Female variations:/*{{{*/

	'@label' => 'Femenino',
	'@import' => 'es',

	'n1' => 'una',

	'nx00' => 'cientas',
	'nxxx' => 'cientas ',
	'n0xx' => '',
	'n500' => 'quinientas',
	'n5xx' => 'quinientas ',
	'n700' => 'setecientas',
	'n7xx' => 'setecientas ',
	'n900' => 'novecientas',
	'n9xx' => 'novecientas ',

);/*}}}*/

return $r;
