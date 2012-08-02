#!/usr/bin/php
<?php

class alphanum {/*{{{*/

	private $r;
	private $lang;


	function __construct (/*{{{*/
		$lang = 'ca'
	) {

		$this->lang = $lang;

		// Catalan /*{{{*/
		$this->r['ca'] = array ( // Default / male:/*{{{*/
/*
			'n00' => '',
			'n000' => '',
			'n0000' => '',
			'n00000' => '',
			'n000000' => '',
			'n0000000' => '',
			'n00000000' => '',
 */

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
			'nx000000' => ' milions',
			'nxxxxxxx' => ' milions ',
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
		$this->r['ca_fem'] = array_merge ( // Female variations:/*{{{*/
			$this->r['ca'],
			array (
				'n1' => 'una',
				'n2' => 'dues',
			)
		);/*}}}*/
		/*}}}*/


	}/*}}}*/


	public function i2a (// Convert integer to string: /*{{{*/
		$i,
		$lang = null
	) {
		return $this->priv_i2a ($i, $lang); // Interface.
	}
	private function priv_i2a ( // Internal implementation:
		$i,
		$lang = null,
		$c = null // Carry (internal use only)
	) {

		is_null ($lang) && $lang = $this->lang;

		if (is_null ($c)) $i = preg_replace ('/^0+(\d+)$/', '\\1', $i);

		$a = ltrim($c, '0') . $i[0];
		////$a = $c . $i[0];
		$b = substr ($i, 1);
		$x = str_repeat ('x', strlen($b));
		$z = str_repeat ('0', strlen($b));
		$r = '';

		if (null !== $n = @ $this->r[$lang]["n{$a}{$b}"]) {			// 3
			$r = $n;
		} else if ( ! preg_match ('/[1-9]/', $b) && null !== $n = @ $this->r[$lang]["nx{$z}"]) {	// 30
			$r = $this->priv_i2a($a, $lang) . $n;
		} else if (null !== $n = @ $this->r[$lang]["n{$a}{$x}"]) {	// 37
			$r = $n . $this->priv_i2a($b, $lang);
		} else if (null !== $n = @ $this->r[$lang]["nx{$x}"]) {		// 77
			$r = $this->priv_i2a($a, $lang) . $n . $this->priv_i2a($b, $lang);
		} else if (strlen ($b)) {
			$r = $this->priv_i2a($b, $lang, $a);
		} else {
			$r = "[error:$i/$a/$b]";
		};

		return $r;

	}/*}}}*/

	public function a2i ( // Convert string to integer:/*{{{*/
		$i,
		$lang
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/

	public function sa2i ( // Search for any numeric (integer) data inside given string and convert to numeric digits:/*{{{*/
		$i,
		$lang
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/


		public function f2a ( // Convert float to string:/*{{{*/
		$i,
		$lang
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/

		public function a2f ( // Convert string to float:/*{{{*/
		$i,
		$lang
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/

	public function sa2f ( // Search for any numeric data (understandig floats) inside given string and convert to numeric digits:/*{{{*/
		$i,
		$lang
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/


};/*}}}*/


$x = new alphanum();


// Debugging stuff:
// ===============

// $n0 = Start:/*{{{*/
if (
	! is_numeric (@ $n0 = $argv[1])
) die (
	"Syntax: " . $argv[0] . " <start> [[end=start] inc=1]\n"
);
$n0 = abs(floor($n0));
/*}}}*/

// $n = Stop (defaults to start):/*{{{*/
((@ $n = $argv[2] + 0) > $n0) || $n = $n0;
$n = abs(floor($n));
/*}}}*/

// $n = Stop (defaults to start):/*{{{*/
((@ $inc = $argv[3] + 0) >= 1) || $inc = 1;
$inc = floor($inc);
/*}}}*/

$p = 1 + floor(log($n, 10)); // Needed padding width.



for (
	$i = $n0;
	$i <= $n;
	$i+= $inc
) echo sprintf("%{$p}s -> [%s]\n", $i, $x->i2a($i));
