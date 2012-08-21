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
		$usecache && @ $this->r = unserialize (file_get_contents ($cachef = "cache/i18n_{$full_lang}.cache"));
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


	private function get_rule ( // Return requested rule untouched:/*{{{*/
		$rule, // Usually '@' rules which has variable structure.
		$lang
	) {
		foreach (
			$this->r[$lang]['@import']
			as $ilang
		) if (
			isset ($this->r[$ilang][$rule])
		) {
			if (is_null ($this->r[$ilang][$rule])) break; // Expicit null breaks inherition.
			return $this->r[$ilang][$rule];
		};
		return @ $this->r['_default_'][$rule]; // Return default value (if defined) or null.
	}/*}}}*/

	private function apply_rule ( // Search for and apply translation rule:/*{{{*/
		& $n,
		$lang,
		$rule
	) {
		foreach (
			$this->r[$lang]['@import']
			as $ilang
		) if (
			isset ($this->r[$ilang][$rule])
		) {
			$n = $this->r[$ilang][$rule];
			if (is_null ($this->r[$ilang][$rule])) break; // Explicit null breaks inherition.
			if (is_array ($n)) list ($n, $lang) = $n; // Let to specify partial variation change.
			return $lang;
		};

		if (isset ($this->r['_default_'][$rule])) { // Use default value if defined:
			$n = @ $this->r['_default_'][$rule];
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
		$i,
		$lang = null,
		$c = null // Carry (internal use only)
	) {
		///$i .= ''; // Cast to string.

		is_null ($lang) && $lang = $this->lang;

		$a = ltrim($c, '0') . $i[0];
		$b = substr ($i, 1);
		$x = str_repeat ('x', strlen($b));
		$z = str_repeat ('0', strlen($b));
		$r = '';

		if ( // 3
			$this->apply_rule ($n, $lang, "n{$a}{$b}")
		) {
			$r = $n;
		} else if ( // 30
			! preg_match ('/[1-9]/', $b)
			&& $this->apply_rule ($n, $lang, "nx{$z}")
		) {
			$r = $this->priv_i2a($a, $lang) . $n;
		} else if ( // 37
			$this->apply_rule ($n, $lang, "n{$a}{$x}")
		) {
			$r = $n . $this->priv_i2a($b, $lang);
		} else if ( // 17 (seventeen)
			$this->apply_rule ($n, $lang, "n{$x}{$a}")
		) {
			$r = $this->priv_i2a($b, $lang) . $n;
		} else if ( // 77
			$cl = $this->apply_rule ($n, $lang, "nx{$x}")
		) {
			$r = $this->priv_i2a($a, $cl) . $n . $this->priv_i2a($b, $lang);
		} else if (
			strlen ($b)
		) {
			$r = $this->priv_i2a($b, $lang, $a);
		} else {
			$r = "[error:$i/$a/$b]";
		};

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
		if (is_null ($d)) return $this->i2a($i);

		$dlen = strlen ($d);
		$d = ltrim($d, '0');

		// Use applicable fraction units if possible:/*{{{*/
		$fractions = $this->get_rule ('@fractions', $lang);
		$sep = isset ($fractions[0]) ? $fractions[0] : $this->get_rule('n.', $lang); // Alternative separator.
		foreach (
			$fractions
			as $digits => $frlabel
		) if ($digits >= $dlen) {
			$d .= str_repeat ('0', $digits - $dlen);
			$number = ($d + 0 == 1) ? 0 : 1;
			return $this->i2a($i) // Integer part.
				. $sep
				. $this->priv_i2a($d, @$frlabel[2]) // Decimal translation in given language (null => default)
				. $frlabel[$number]; // Label in correct number.
		};/*}}}*/


		// Else, say every leading '0':/*{{{*/
		$this->apply_rule($sep, $lang, 'n.');
		$this->apply_rule($z, $lang, 'n.0');
		return $this->i2a($i)
			. $sep
			. str_repeat ($z, $dlen - strlen ($d))
			. $this->priv_i2a($d);
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

