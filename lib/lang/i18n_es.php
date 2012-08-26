<?php
# vim configuration:
# vim:foldmethod=marker
#
# HINT: If you are using vim, foldmethod=marker is automatically enabled.
#     Use 'za' to expand/hide folds.
#     Type :help folding to learn more about vim folding.

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

	'@import' => array (
		'es_fem', // Usado para fracciones.
		'es_det', // Usado para múltiplos de miles, millones...
	),

	'@decimal' => ',',

	'@fractions' => array (
		' con ',
		1 => array (' décima',' décimas', 'es_fem'),
		2 => array (' centésima',' centésimas', 'es_fem'),
		3 => array (' milésima',' milésimas', 'es_fem'),
		6 => array (' millonésima',' millonésimas', 'es_fem'),
	),


	'n-' => 'menos ',
	'n.' => ' coma ',
	'n.0' => 'cero ',

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
	'nx000' => array (' mil', 'es_det'),
	'nxxxx' => array (' mil ', 'es_det'),
	'n0xxx' => '',

	'n1000000' => 'un millón',
		'r1000000' => 'un mill[oó]n',
	'n1xxxxxx' => 'un millón ',
		'r1xxxxxx' => 'un mill[oó]n ',
	'nx000000' => array (' miliones', 'es_det'),
	'nxxxxxxx' => array (' miliones ', 'es_det'),
	'n0xxxxxx' => '',

	/* Not used colloquially.
	'n1000000000' => 'un millardo',
	'n1xxxxxxxxx' => 'un millardo ',
	'nx000000000' => array (' millardos', 'es_det'),
	'nxxxxxxxxxx' => array (' millardos ', 'es_det'),
	'n0xxxxxxxxx' => '',
	 */

	'n1000000000000' => 'un billón',
		'r1000000000000' => 'un bill[oó]n',
	'n1xxxxxxxxxxxx' => 'un billón ',
		'r1xxxxxxxxxxxx' => 'un bill[oó]n ',
	'nx000000000000' => array (' billones', 'es_det'),
	'nxxxxxxxxxxxxx' => array (' billones ', 'es_det'),
	'n0xxxxxxxxxxxx' => '',

	'n1000000000000000000' => 'un trillón',
		'r1000000000000000000' => 'un trill[oó]n',
	'n1xxxxxxxxxxxxxxxxxx' => 'un trillón ',
		'r1xxxxxxxxxxxxxxxxxx' => 'un trill[oó]n ',
	'nx000000000000000000' => array (' trillones', 'es_det'),
	'nxxxxxxxxxxxxxxxxxxx' => array (' trillones ', 'es_det'),
	'n0xxxxxxxxxxxxxxxxxx' => '',

);/*}}}*/

$r['es_det'] = array (/*{{{*/
	'@label' => 'Determinante',
	'@import' => 'es',

	'n1'	=> 'un',
);/*}}}*/

$r['es_fem'] = array ( // Female variations:/*{{{*/

	'@label' => 'Femenino',
	'@import' => array (
		'es',
	),

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


$r['es_ord'] = array ( // Ordinal (male) variation:/*{{{*/

	'@label' => 'ordinales',
	'@import' => 'es',

	'n1' => 'primero',
	'n2' => 'segundo',
	'n3' => 'tercero',
	'n4' => 'cuarto',
	'n5' => 'quinto',
	'n6' => 'sexto',
	'n7' => 'séptimo',
	'n8' => 'octavo',
	'n9' => 'noveno',

	'n11' => 'undécimo',
	'n12' => 'duodécimo',

	'n13' => false,
	'n14' => false,
	'n15' => false,

	'n10' => 'décimo',
	'n1x' => 'decimo ',
	'n20' => 'vigésimo',
	'n2x' => 'vigésimo ',
	'n30' => 'trigésimo',
	'n3x' => 'trigésimo ',
	'n40' => 'cuadragésimo',
	'n4x' => 'cuadragésimo ',
	'n50' => 'quincuagésimo',
	'n5x' => 'quincuagésimo ',
	'n60' => 'sexagésimo',
	'n6x' => 'sexagésimo ',
	'n70' => 'septuagésimo',
	'n7x' => 'septuagésimo ',
	'n80' => 'octogésimo',
	'n8x' => 'octogésimo ',
	'n90' => 'nonagésimo',
	'n9x' => 'nonagésimo ',

	'n100' => 'centésimo',
	'n1xx' => 'centésimo ',
	'n200' => 'duocentésimo',
	'n2xx' => 'duocentésimo ',
	'n300' => 'tricentésimo',
	'n3xx' => 'tricentésimo ',
	'n400' => 'cadrigentésimo',
	'n4xx' => 'cadrigentésimo ',
	'n500' => 'quingentésimo',
	'n5xx' => 'quingentésimo ',
	'n600' => 'sexcentésimo',
	'n6xx' => 'sexcentésimo ',
	'n700' => 'septigentésimo',
	'n7xx' => 'septigentésimo ',
	'n800' => 'octigentésimo',
	'n8xx' => 'octigentésimo ',
	'n900' => 'nonigentésimo',
	'n9xx' => 'nonigentésimo ',


	'n1000' => 'milésimo',
	'n1xxx' => 'milésimo ',
	'nxxxx' => array ('milésimo ', 'es'),
	'n1000000' => 'millonésimo',
	'n1xxxxxx' => 'millonésimo ',
	'nxxxxxxx' => array ('millonésimo ', 'es'),


);/*}}}*/

$r['es_ord_fem'] = array ( // Ordinal (male) variation:/*{{{*/

	'@label' => 'ordinales femeninos',
	'@import' => array (
		'es_fem',
		'es'
	),

	'n1' => 'primera',
	'n2' => 'segunda',
	'n3' => 'tercera',
	'n4' => 'cuarta',
	'n5' => 'quinta',
	'n6' => 'sexta',
	'n7' => 'séptima',
	'n8' => 'octava',
	'n9' => 'novena',

	'n11' => 'undécima',
	'n12' => 'duodécima',

	'n13' => false,
	'n14' => false,
	'n15' => false,

	'n10' => 'décima',
	'n1x' => 'decima ',
	'n20' => 'vigésima',
	'n2x' => 'vigésima ',
	'n30' => 'trigésima',
	'n3x' => 'trigésima ',
	'n40' => 'cuadragésima',
	'n4x' => 'cuadragésima ',
	'n50' => 'quincuagésima',
	'n5x' => 'quincuagésima ',
	'n60' => 'sexagésima',
	'n6x' => 'sexagésima ',
	'n70' => 'septuagésima',
	'n7x' => 'septuagésima ',
	'n80' => 'octogésima',
	'n8x' => 'octogésima ',
	'n90' => 'nonagésima',
	'n9x' => 'nonagésima ',

	'n100' => 'centésima',
	'n1xx' => 'centésima ',
	'n200' => 'duocentésima',
	'n2xx' => 'duocentésima ',
	'n300' => 'tricentésima',
	'n3xx' => 'tricentésima ',
	'n400' => 'cadrigentésima',
	'n4xx' => 'cadrigentésima ',
	'n500' => 'quingentésima',
	'n5xx' => 'quingentésima ',
	'n600' => 'sexcentésima',
	'n6xx' => 'sexcentésima ',
	'n700' => 'septigentésima',
	'n7xx' => 'septigentésima ',
	'n800' => 'octigentésima',
	'n8xx' => 'octigentésima ',
	'n900' => 'nonigentésima',
	'n9xx' => 'nonigentésima ',

	'n1000' => 'milésima',
	'n1xxx' => 'milésima ',
	'nxxxx' => array ('milésima ', 'es'),
	'n1000000' => 'millonésima',
	'n1xxxxxx' => 'millonésima ',
	'nxxxxxxx' => array ('millonésima ', 'es'),

);/*}}}*/

return $r;
