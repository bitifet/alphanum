<?php
# vim configuration:
# vim:foldmethod=marker
#
# HINT: If you are using vim, foldmethod=marker is automatically enabled.
#     Use 'za' to expand/hide folds.
#     Type :help folding to learn more about vim folding.


class alphanum {

	private $r;
	private $lang;


	private function check_lang_rules (/*{{{*/
		& $r,
		$lang
	) {

		if (
			// (Seems) correctly specified:
			@ is_array ($r['@fractions'])
		) {
			// Sort and sanityze:
			ksort ($r['@fractions']); // Important.
			foreach ( // Let to specify single number only for general use:/*{{{*/
				$r['@fractions']
				as $k => $v
			) if (
				$k != 0 // Alternative decimal part separator.
			) is_array ($v) || $r['@fractions'][$k] = array ($v, $v);/*}}}*/
		} else if (
			// Garbage:
			isset ($r['@fractions'])
		) throw new Exception (
			"ALPHANUM: Malformed @fractions specification for {$lang}"
		);


	} /*}}}*/

	private function load_lang_rules (/*{{{*/
		& $ruledata,
		$lang
	) {

		if (isset ($ruledata[$lang])) return false; // Prevent from infinite loop.
		$ruledata[$lang] = array(); // Initialyze to avoid infinite loop on (permitted) cyclic dependencys.

		// Split language code from its variation if any specified:/*{{{*/
		@ list ($lc, $var) = explode ('_', $lang, 2);
		/*}}}*/

		// Load language module performing minimum consistency tests:/*{{{*/
		if (
			! is_array ( $r = @ include ($f = "lang/i18n_{$lang}.php"))
			&& ! is_array ( $r = @ include ($f = "lang/i18n_{$lc}.php"))
		) throw new Exception ("ALPHANUM: Failed to load language {$lc}.");
		/*}}}*/

		// Check for specified variation:/*{{{*/
		if (
			strlen ($var)
			&& ! @ is_array ($r["{$lc}_{$var}"])
		) throw new Exception ("ALPHANUM: {$f} doesn't contain rules for {$lc}_{$var} variation.");
		/*}}}*/

		// Load dependencys if any:/*{{{*/
		if (
			! is_array (@ $r[$lang]['@import'])
		) {
			if (strlen (@ $r[$lang]['@import'])) {
				$r[$lang]['@import'] = array ($r[$lang]['@import']); // Let string for single dependency.
			} else {
				$r[$lang]['@import'] = array();
			};
		};


		foreach (
			$r[$lang]['@import'] as $dep
		) if (
			strlen ($dep = trim($dep)) // Ignore empty strings:
			&& $dep != $lang // Redundant, but avoid unuseful function call.
		) $this->load_lang_rules ($ruledata, $dep);


		// Prepend itself:
		array_unshift ($r[$lang]['@import'], "{$lang}");

		/*}}}*/

		// Check for minimal defaults:
		$this->check_lang_rules($r[$lang], $lang);

		// Load language:
		$ruledata[$lang] = $r[$lang];

	}/*}}}*/

	function __construct (/*{{{*/
		$lang = array ('en'), // Language definitions to load.
		$usecache = true
	) {

		// Select first language as default:/*{{{*/
		is_array ($lang) || $lang = array ($lang); // Accept string for single lang. specification.
		if ( ! strlen (
			@ $this->lang = $lang[0]
		)) throw new Exception ('ALPHANUM: Constructor requires at least one language specification.');
		/*}}}*/

		// Build unique language-set id:/*{{{*/
		sort ($lang); // Ensure same order to avoid cache duplications.
		$full_lang = implode ('+', $lang);
		/*}}}*/

		// Try to fetch language data from cache:/*{{{*/
		$usecache && @ $this->r = unserialize (file_get_contents ($cachef = dirname (__FILE__) . "/cache/i18n_{$full_lang}.cache"));
		/*}}}*/

		// Language data processing and caching:/*{{{*/
		if (
			// Not already cached.
			! is_array ($this->r)
		) {

			// Initialyze and set miscellaneous default parameters/*{{{*/
			$this->r = array(
				'_default_' => array (
					'@decimal' => '.',
					'n.' => '[comma]',
					'n-' => '[minus]',
				)
			);/*}}}*/

			foreach (
				$lang
				as $lc
			) $this->load_lang_rules ($this->r, $lc);

			// Save to cache (if enabled):/*{{{*/
			if (
				$usecache && (@ false === file_put_contents ($cachef, serialize ($this->r)))
			) throw new Exception ("ALPHANUM: Cannot write to cache file: {$cachef}");
			/*}}}*/

		};
		/*}}}*/

	}/*}}}*/


	public function get_rule ( // Return requested rule untouched:/*{{{*/
		$rule, // Usually '@' rules which has variable structure.
		$lang,
		$default = null
	) {
		if (! is_array (@ $this->r[$lang]['@import'])) return null;
		foreach (
			$this->r[$lang]['@import']
			as $ilang
		) if (
			isset ($this->r[$ilang][$rule])
		) {
			if (is_null ($this->r[$ilang][$rule])) break; // Expicit null breaks inherition.
			return $this->r[$ilang][$rule];
		};

		// Return default value:/*{{{*/
		if (is_null (
			// From _default_ specification...
			$r = @ $this->r['_default_'][$rule] // Return default value if defined.
		)) {
			// ...or by parameter specification.
			$r = $default;
		};
		return $r;
		/*}}}*/

	}/*}}}*/

	private function rulable ( // Check for and apply indirections:/*{{{*/
		$rule,
		$lang
	) {

		if (
			in_array (@ $rule[0], array ('$', '@')) // User variable or formal parameter.
		) {
			$rule = $this->get_rule ($rule, $lang);
		};
		return $rule;
	}/*}}}*/

	private function apply_rule ( // Search for and apply translation rule:/*{{{*/
		& $n,
		$lang,
		$rule
	) {

		$lang0 = $lang;

		// Build uncompound alternative for compound patterns:
		$uncompound = $rule[1] == '_' ? $rule[0] . substr ($rule, 2) : false;

		foreach (
			$this->r[$lang]['@import']
			as $ilang
		) {
			$ilang = $this->rulable($ilang, $lang);
			if (
				isset ($this->r[$ilang][$usedrule = $rule])
				|| $uncompound && isset ($this->r[$ilang][$usedrule = $uncompound])
			) {
				$n = $this->r[$ilang][$usedrule];
				if (is_null ($this->r[$ilang][$usedrule])) break; // Explicit null breaks inherition.
				if (is_array ($n)) list ($n, $lang) = $n; // Let to specify partial variation change.
				return $this->rulable ($lang, $lang0);
			};
		};

		if (
			isset ($this->r['_default_'][$rule])
			|| $uncompound && isset ($this->r['_default_'][$usedrule = $uncompound])
		) { // Use default value if defined:
			$n = @ $this->r['_default_'][$usedrule];
			if (is_array ($n)) list ($n, $lang) = $n; // Let to specify partial variation change.
			return $lang;
		} else { // Return boolean false if no default value:
			return false;
		};
	}/*}}}*/


	public function i2a ( // Convert integer to string: /*{{{*/
		$i,
		$lang = null
	) {
		// Interface:
		$i = preg_replace ('/^0+(\d+)$/', '\\1', $i);
		return $this->priv_i2a ($i, $lang);
	}
	private function priv_i2a ( // Internal implementation:
		$i, // Integer input.
		$lang = null,
		$carry = null // Left carry (internal use only)
		// 
		// Positional - recursive integer to text translation function.
		// To understand this algoritm you must take in mind below digits structure (without spaces):
		//
		// 	[Carried dígits] [Left-most digit] [Rest of digits]
		//
		// 	WHERE:
		//
		// 		Left-most digit: The (1) digit which is being considered (current position).
		//
		// 		Carried digits: Left-most digits which couldn't build matching pattern in previous recursion.
		// 			They are automatically concatenated with Left-most digit in {$a} (number's left side considered from current position.
		//
		// 		Rest of digits: Digits to be tested with number's left side ($a) for:
		// 			* Full match: Exists exact 'n{$a}{$b}' (or 'n_{$a}{$x}') pattern.
		// 			* 0-match: Exists 'n{$a}{$z}' pattern where $z is $b-length pattern of '0's.
		// 			* x-match: Exists 'n{$a}{$x}' pattern where $z is $b-length pattern of 'x's.

	) {
		///$i .= ''; // Cast to string.

		// Misc initializations:
		is_null ($lang) && $lang = $this->lang;
		$r = '';

		// Separate first digit plus right carry if any ($a) from the rest ($b):
		$c = $i[0] == '_' ? '_' : ''; $i = ltrim ($i, '_'); // Capture compound flag.
		$a = ltrim($carry, '0') . $i[0]; // [Non-Zero carried digits]+[Input's left-most digit]
		$b = substr ($i, 1); // [Input without left-most digit]

		// Build $b-width 'x' and '0' patterns:
		$x = str_repeat ('x', strlen($b)); // b-width 'x' pattern.
		$z = str_repeat ('0', strlen($b)); // b-width '0' pattern.


		// Recursively iterate thought many patterns:
		// =========================================

		if ( // Full match "{$a}{$b}": (1, 4, or 1428 if necessary; also compound _1, _3, _234...)/*{{{*/
			$this->apply_rule ($n, $lang, "n{$c}{$a}{$b}")
		) {
			$r = $n;
		} /*}}}*/

		else if ( // Only '0's at right side ("a b": 1 0, 3 00, 2 7000...)/*{{{*/
			! preg_match ('/[1-9]/', $b)
			&& $this->apply_rule ($n, $lang, "nx{$z}")
		) {
			$r = $this->priv_i2a($a, $lang) . $n;
		} /*}}}*/

		else if ( // Non '00...' right side (3 7, 2 343, 34 300...)/*{{{*/
			$this->apply_rule ($n, $lang, "n{$c}{$a}{$x}")
		) {
			$r = $n . $this->priv_i2a("_{$b}", $lang); // Prepend '_' to select compound version if any...
		} /*}}}*/

		else if ( // Reversed-speaking "{$a}xxx" patterns (English 1 7: 'Seven' + 'teen')./*{{{*//*{{{*/
			$this->apply_rule ($n, $lang, "n{$c}{$x}{$a}")
		) {
			$r = $this->priv_i2a($b, $lang) . $n;
		} /*}}}*//*}}}*/

		else if ( // Non reversed-speaking "{$a}xxx" patterns (English 2 20 or catalan 1 7)./*{{{*/
			$cl = $this->apply_rule ($n, $lang, "n{$c}x{$x}")
		) {
			$r = $this->priv_i2a($a, $cl) . $n . $this->priv_i2a($b, $lang);
		}/*}}}*/

		else if ( // $a unmatched but $b not yet empty:/*{{{*/
			strlen ($b)
		) {
			// Carry $a and try again with $b:
			$r = $this->priv_i2a("{$c}$b", $lang, $a);
		}/*}}}*/

		else { // No applicable pattern matching:/*{{{*/
			$r = "[error:$i/$a/$b]";
		};/*}}}*/

		// =========================================

		return $r;

	}/*}}}*/

	public function a2i ( // Convert string to integer:/*{{{*/
		$i,
		$lang = null
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/

	public function sa2i ( // Search for any numeric (integer) data inside given string and convert to numeric digits:/*{{{*/
		$i,
		$lang = null
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/


	public function f2a ( // Convert float to string:/*{{{*/
		$f,
		$lang = null
	) {

		is_null ($lang) && $lang = $this->lang;
		$dec = $this->get_rule ('@decimal', $lang);
		is_numeric ($f) && $f = str_replace ('.', $dec, $f);

		@ list ($i, $d) = explode ($dec, $f, 2);
		if (is_null ($d)) return $this->i2a($i, $lang);

		$dlen = strlen ($d);
		$d = ltrim($d, '0');

		// Use applicable fraction units if possible:/*{{{*/
		$fractions = $this->get_rule ('@fractions', $lang);
		$sep = isset ($fractions[0]) ? $fractions[0] : $this->get_rule('n.', $lang); // Alternative separator.
		if (
			is_array ($fractions)
		) foreach (
			$fractions
			as $digits => $frlabel
		) if ($digits >= $dlen) {
			$d .= str_repeat ('0', $digits - $dlen);
			$number = ($d + 0 == 1) ? 0 : 1;
			is_null ($frlang = @$frlabel[2]) && $frlang = $lang;
			return $this->i2a($i, $lang) // Integer part.
				. $sep
				. $this->priv_i2a($d, $frlang) // Decimal translation in given language (null => default)
				. $frlabel[$number]; // Label in correct number.
		};/*}}}*/


		// Else, say every leading '0':/*{{{*/
		$this->apply_rule($sep, $lang, 'n.');
		$this->apply_rule($z, $lang, 'n.0');
		return $this->i2a($i, $lang)
			. $sep
			. str_repeat ($z, $dlen - strlen ($d))
			. $this->priv_i2a($d, $lang);
		/*}}}*/


	}/*}}}*/

	public function a2f ( // Convert string to float:/*{{{*/
		$f,
		$lang = null
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/

	public function sa2f ( // Search for any numeric data (understandig floats) inside given string and convert to numeric digits:/*{{{*/
		$f,
		$lang = null
	) {
		die ("UNIMPLEMENTED!!\n");
	}/*}}}*/


};

