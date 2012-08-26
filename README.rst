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


For example:
| sa2i('99 red balloons') == sa2i('ninety-nine red balloons') // will evaluate to true.


And last, but not least, I would like to implement some plpgsql function generator to generate compatible plpgsql functions that can, at least, normalyze any string in selected languages replacing all number, whichever format is written, to its equivalent number.

First step for that will be providing functions generate the propper regular expressions to detect and convert numbers in desired languages/variations.

This way, we could generate PostgreSQL indexes over this function applyed over string columns and then, build efficient querys to search strings "numbering-insensitive"



PROJECT STRUCTURE
=================

  * ./README *This readme file.*
  * ./LICENSE *Licensing terms (GPLv3)*
  * ./doc/
  * ./lib/

    * alphanum.class.php *Alphanum library.*
    * lang/ *Language and variations specification files.*
    * cache/ *Used for language structures caching.*

  * ./tools/

    * a2i.php *Tool to test integer-to-number conversion function.*
    * f2i.php *Tool to test float-to-number conversion function.*



EXAMPLES
========

A few examples (build with tools/fill_test_file.php) depending on current completion level of each language.

Nowadays most complete language (and the only one with ordinal variations) is catalan. But defining it for other ones is quite trivial (just take a few time).

[en]
----

  * i2a, en, 13, thirteen
  * i2a, en, 230007234, two hundred and thirty millions seven thousands and two hundred and thirty-four
  * i2a, en, 700000001002, seven hundred thousands millions thousand and two
  * i2a, en, 270023576340045, two hundred and seventy bilions twenty-three thousands and five hundred and seventy-six millions three hundred and fourty thousands and fourty-five
  * i2a, en, 980320002004034323319, nine hundred and eighty trillons three hundred and twenty thousands and two bilions four thousands and thirty-four millions three hundred and twenty-three thousands and three hundred and nineteen
  * f2a, en, 1031.01, thousand and thirty-one comma zero one
  * f2a, en, 4300923.0003, four millions three hundred thousands and nine hundred and twenty-three comma zero zero zero three



[ca]
----

  * i2a, ca, 13, tretze
  * i2a, ca_ord, 13, tretzè
  * i2a, ca, 230007234, dos-cents trenta milions set mil dos-cents trenta-quatre
  * i2a, ca_ord, 230007234, dos-cents trenta milions set mil dos-cents trenta-quatrè
  * i2a, ca_ord_fem, 230007234, dos-cents trenta milions set mil dos-centes trenta-quatrena
  * i2a, ca, 700000001002, set-cents mil milions mil dos
  * i2a, ca, 270023576340045, dos-cents setanta bilions vint-i-tres mil cinc-cents setanta-sis milions tres-cents quaranta mil quaranta-cinc
  * i2a, ca_ord_fem, 270023576340045, dos-cents setanta bilions vint-i-tres mil cinc-cents setanta-sis milions tres-centes quaranta mil quaranta-cinquena
  * i2a, ca, 980320002004034323319, nou-cents vuitanta trilions tres-cents vint mil dos bilions quatre mil trenta-quatre milions tres-cents vint-i-tres mil tres-cents dinou
  * f2a, ca, 1031.01, mil trenta-un amb una centèssima
  * f2a, ca_fem, 1031.01, mil trenta-una amb una centèssima
  * f2a, ca, 4300923.0003, quatre milions tres-cents mil nou-cents vint-i-tres amb tres-centes milionèssimes
  * f2a, ca_fem, 63289322.00000065, seixanta-tres milions dos-centes vuitanta-nou mil tres-centes vint-i-dues coma zero zero zero zero zero zero seixanta-cinc



[es]
----

  * i2a, es, 13, trece
  * i2a, es, 230007234, doscientos treinta miliones siete mil doscientos treinta y cuatro
  * i2a, es, 700000001001, setecientos mil miliones mil uno
  * i2a, es, 270023576340045, doscientos setenta billones veintitres mil quinientos setenta y seis miliones trescientos cuarenta mil cuarenta y cinco
  * i2a, es, 980320002004034323319, novecientos ochenta trillones trescientos veinte mil dos billones cuatro mil treinta y cuatro miliones trescientos veintitres mil trescientos diecinueve
  * f2a, es, 1031,01, mil treinta y uno con una centésima
  * f2a, es_fem, 1031,01, mil treinta y una con una centésima
  * f2a, es, 4300923,0003, cuatro miliones trescientos mil novecientos veintitres con trescientas millonésimas
  * f2a, es_fem, 63289321,00000065, sesenta y tres miliones doscientos ochenta y nueve mil trescientas veintiuna coma cero cero cero cero cero cero sesenta y cinco



[de]
----

*Need to be checked (Internet based)*

  * i2a, de, 13, dreizehn
  * i2a, de, 230007234, zweihundertdreißigmillionundsiebentausendundzweihundertvierunddreißig
  * i2a, de, 700000001002, siebenhundertnullmillardeundnullmillionundeinstausendundnullhundertzwei
  * i2a, de, 270023576340045, zweihundertsiebzigbillionunddreiundzwanzigmillardeundfünfhundertsechsundsiebzigmillionunddreihundertvierzigtausendundnullhundertfünfundvierzig
  * i2a, de, 980320002004034323319, neunhundertachtzigmillionunddreihundertzwanzigtausendundnullhundertzweibillionundviermillardeundvierunddreißigmillionunddreihundertdreiundzwanzigtausendunddreihundertneunzehn


[roman]
-------

  * i2a, roman, 12, XII
  * i2a, roman, 450, CDL
  * i2a, roman, 666, DCLXVI
  * i2a, roman, 999, CMXCIX
  * i2a, roman, 1444, MCDXLIV
  * i2a, roman, 2012, MMXII
  * i2a, roman, 2014, MMXIV
  * i2a, roman, 2016, MMXVI

