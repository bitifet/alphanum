#!/usr/bin/php
<?php
require_once (dirname (__FILE__) . '/../lib/alphanum.class.php');


$cmd = array_shift ($argv);

if (! count ($langspec = $argv)) {
	echo "SYNTAX:\n";
	echo "	{$cmd} <language_code> [language_code [...]]\n";
	echo "WHERE:\n";
	echo "	<language_code> Declaration of language codes which will be used.\n";
	die();
};

$x = new alphanum ($langspec);


while (! feof (STDIN)) {

	$row = trim (fgets (STDIN));

	if ($row == 'q') exit; // Alternative to '^D' when used interactively.

	// Parse row:/*{{{*/
	if (preg_match (
		'/^([^,]*),([^,]*),([^,]*)(?:,(.*))?$/',
		$row,
		$matches
	)) { 
		@ list ($foo, $func, $lang, $in, $out) = $matches;
	} else if (
		! strlen ($row) // Permit empty lines.
		|| $row[0] == '#' // Ignore comment lines.
	) {
		echo "{$row}\n";
		continue;
	} else {
		echo "# FORMAT ERROR: $row\n";
		continue;
	};/*}}}*/

	// Input parsing:/*{{{*/
	if (
		strlen ($out = trim (@ $out))
	) {
		echo "{$row}($out)\n";
		continue; // Preserve previous value.
	};
	strlen ($func = trim(@ $func)) || $func = @ $lastfunc; // Let to omit when same.
	strlen ($lang = trim(@ $lang)) || $lang = @ $lastlang; // Let to omit when same.
	strlen ($in = trim (@ $in)) || $in = @ $lastin; // Let to omit when same.
	$lastfunc = $func; $lastlang = $lang; $lastin = $in;
	/*}}}*/

	if (! in_array ($lang, $langspec)) {
		echo "# UNDECLARED_LANGUAGE_CODE ERROR: {$row}\n";
		continue;
	};

	if (in_array ($func, array ('i2a', 'f2a'))) {
		if (! is_numeric ($in)) {
			echo "# INPUT_DATA_TYPE ERROR: {$row}\n";
			continue;
		};
		if ('.' !== $dec = $x->get_rule ('@decimal', $lang, '.')) {
			$in = str_replace ('.', $dec, $in);
		};
	} else {
		echo "# UNKNOWN_FUNCTION ERROR: {$row}\n";
		continue;
	};


	$out = $x->$func($in, $lang);
	echo "{$func}, {$lang}, {$in}, {$out}\n";




};



?>
