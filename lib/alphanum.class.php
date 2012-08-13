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
			) if (
				// Perform minimum consistency tests:
				is_array (
					$r = @ include ("lang/i18n_{$lc}.php")
				)
				&& count ($r)
			) {
				// Load language:
				$this->r = array_merge ($this->r, $r);
			} else {
				throw new Exception ("ALPHANUM: Failed to load language {$lc}.");
			};

			// Save to cache (if enabled):/*{{{*/
			if (
				$usecache && (@ false === file_put_contents ($cachef, serialize ($this->r)))
			) throw new Exception ("ALPHANUM: Cannot write to cache file: {$cachef}");
			/*}}}*/

		};
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
		} else if (null !== $n = @ $this->r[$lang]["n{$x}{$a}"]) {	// 17 (seventeen)
			$r = $this->priv_i2a($b, $lang) . $n;
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


};

