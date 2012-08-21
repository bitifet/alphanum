#!/usr/bin/php
<?php
# vim configuration:
# vim:foldmethod=marker
#
# HINT: If you are using vim, foldmethod=marker is automatically enabled.
#     Use 'za' to expand/hide folds.
#     Type :help folding to learn more about vim folding.

require_once (dirname(__FILE__) . '/../lib/alphanum.class.php');



// $n0 = Start:/*{{{*/
if (
	! is_numeric (@ $n0 = $argv[2])
) die (
	"Syntax: " . $argv[0] . " <lang_code> <start> [[end=start] inc=1]\n"
);
/*}}}*/

$x = new alphanum(
	$argv[1],
	false // Disable cache for debugging.
);

// $n = Stop (defaults to start):/*{{{*/
((@ $n = $argv[3] + 0) > $n0) || $n = $n0;
/*}}}*/

// $n = Stop (defaults to start):/*{{{*/
((@ $inc = $argv[4] + 0) >= 1) || $inc = 1;
/*}}}*/

$p = 1 + floor(log($n, 10)); // Needed padding width.


if (
	$n0 == $n
	&& ($n0 >= 100000000000000)
) {
	// Let to test big numbers individually (alphanum doesn't threat floats propperly)
	echo "{$argv[2]} -> [" . $x->f2a($argv[2]) . "]\n";
} else for (
	$i = $n0;
	$i <= $n;
	$i+= $inc
) echo sprintf("%{$p}s -> [%s]\n", $i, $x->f2a($i));
