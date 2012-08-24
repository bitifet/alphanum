========
ALPHANUM
========

-----------------------------------------------------------------------------------------------
PHP multi-language number conversion class to convert numeric data into strings and vice-versa.
-----------------------------------------------------------------------------------------------

Abstract
========

This class is intended to be able to convert any numeric data in its textual string in multiple languages and textual numbers back into numeric data.

The resultant strings must be correct in the selected language and the string-to-number conversion must be able to understand and ignore common syntax mistakes.

It can understand and generate strings in each language standard and in many variations such as localizations, ordinals, or gender variations.

Variations are specified by one or more underscore preceded suffixs in the language code.

This class operates with positive integer or floating poing numbers. Support for negative numbers will be added soon.

Floating point numbers are automatically rendered in best known fraction units or in 'zero zero zero...' style when language definiton doesn't provide any smaller-enought unit.

We will also implement functions to generate and recognize many set of strings meaning the same number including not only variations but also common human mistakes to make it more efficient in text recognition or normalyzation tasks.

Finally, we will implement functions to detect any numeric data in any format (and possibly in any given languages or variations, including common human mistakes) inside strings mixed with non numeric text and normalyze all of them to, say, numeric digits to be able to compare strings without taking care of the way numbers are represented in it.


For example: sa2i('99 red balloons') == sa2i('ninety-nine red balloons') // will evaluate to true.


And last, but not least, I would like to implement some plpgsql function generator to generate compatible plpgsql functions that can, at least, normalyze any string in selected languages replacing all number, whichever format is written, to its equivalent number.

First step for that will be providing functions generate the propper regular expressions to detect and convert numbers in desired languages/variations.

This way, we could generate PostgreSQL indexes over this function applyed over string columns and then, build efficient querys to search strings "numbering-insensitive"



PROJECT STRUCTURE
=================

./README					- This readme file.
./LICENSE				- Licensing terms (GPLv3)
./doc/
./lib/
	alphanum.class.php	- Alphanum library.
	lang/						- Language and variations specification files.
	cache/					- Used for language structures caching.
./tools/
	a2i.php					- Tool to test text-to-number conversion.



EXAMPLES
========

[en]
----

13 -> [thirteen]
230007234 -> [two hundred and thirty millions seven thousands and two hundred and thirty-four]
700000001002 -> [seven hundred thousands millions thousand and two]
270023576340045 -> [two hundred and seventy bilions twenty-three thousands and five hundred and seventy-six millions three hundred and fourty thousands and fourty-five]
980320002004034323319 -> [nine hundred and eighty trillons three hundred and twenty thousands and two bilions four thousands and thirty-four millions three hundred and twenty-three thousands and three hundred and nineteen]


[ca]
----

13 -> [tretze]
230007234 -> [dos-cents trenta milions set mil dos-cents trenta-quatre]
700000001002 -> [set-cents mil milions mil dos]
270023576340045 -> [dos-cents setanta bilions vint-i-tres mil cinc-cents setanta-sis milions tres-cents quaranta mil quaranta-cinc]
980320002004034323319 -> [nou-cents vuitanta trilions tres-cents vint mil dos bilions quatre mil trenta-quatre milions tres-cents vint-i-tres mil tres-cents dinou]


[es]
----

13 -> [trece]
230007234 -> [doscientos treinta miliones siete mil doscientos treinta y cuatro]
700000001002 -> [setecientos mil miliones mil dos]
270023576340045 -> [doscientos setenta billones veintitres mil quinientos setenta y seis miliones trescientos cuarenta mil cuarenta y cinco]
980320002004034323319 -> [novecientos ochenta trillones trescientos veinte mil dos billones cuatro mil treinta y cuatro miliones trescientos veintitres mil trescientos diecinueve]


[de]
----

*Need to be checked (Internet based)*

13 -> [dreizehn]
230007234 -> [zweihundertdreißigmillionundsiebentausendundzweihundertvierunddreißig]
700000001002 -> [siebenhundertnullmillardeundeinstausendundzwei]
270023576340045 -> [zweihundertsiebzigbillionunddreiundzwanzigmillardeundfünfhundertsechsundsiebzigmillionunddreihundertvierzigtausendundfünfundvierzig]
980320002004034323319 -> [neunhundertachtzigmillionunddreihundertzwanzigtausendundzweibillionundviermillardeundvierunddreißigmillionunddreihundertdreiundzwanzigtausendunddreihundertneunzehn]


[roman]
-------

12 -> [XII]
450 -> [CDL]
666 -> [DCLXVI]
999 -> [CMXCIX]
1444 -> [MCDXLIV]
2012 -> [MMXII]
2014 -> [MMXIV]
2016 -> [MMXVI]
