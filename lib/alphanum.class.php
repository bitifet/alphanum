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


	private function load_lang_rules (/*{{{*/
		& $ruledata,
		$lang
	) {

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

		// Load dependencys if any:
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
			&& $dep != $lang
		){

			// Prevent from infinite loop: 
			if (
				isset ($ruledata[$dep])
			) throw new Exception ("ALPHANUM: Detected cyclical dependency between {$lc}_{$var} and {$dep}"); $this->load_lang_rules ($ruledata, $dep);

		};

		// Prepend itself:
		array_unshift ($r[$lang]['@import'], "{$lang}");


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
			$this->r = array();
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


	private function apply_rule ( // Search for translation rule:/*{{{*/
		& $n,
		$lang,
		$rule
	) {
		foreach (
			$this->r[$lang]['@import']
			as $ilang
		) if (
			null !== $n = @ $this->r[$ilang][$rule]
		) {
			// Let to specify partial variation change:
			if (is_array ($n)) list ($n, $lang) = $n;
			return $lang;
		};
		return false;
	}/*}}}*/


	public function i2a ( // Convert integer to string: /*{{{*/
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


};

