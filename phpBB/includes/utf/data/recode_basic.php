<?php
function iso_8859_1($string)
{
	return utf8_encode($string);
}

function iso_8859_2($string)
{
	static $transform = array(
		"\x80" => "\xC2\x80",
		"\x81" => "\xC2\x81",
		"\x82" => "\xC2\x82",
		"\x83" => "\xC2\x83",
		"\x84" => "\xC2\x84",
		"\x85" => "\xC2\x85",
		"\x86" => "\xC2\x86",
		"\x87" => "\xC2\x87",
		"\x88" => "\xC2\x88",
		"\x89" => "\xC2\x89",
		"\x8A" => "\xC2\x8A",
		"\x8B" => "\xC2\x8B",
		"\x8C" => "\xC2\x8C",
		"\x8D" => "\xC2\x8D",
		"\x8E" => "\xC2\x8E",
		"\x8F" => "\xC2\x8F",
		"\x90" => "\xC2\x90",
		"\x91" => "\xC2\x91",
		"\x92" => "\xC2\x92",
		"\x93" => "\xC2\x93",
		"\x94" => "\xC2\x94",
		"\x95" => "\xC2\x95",
		"\x96" => "\xC2\x96",
		"\x97" => "\xC2\x97",
		"\x98" => "\xC2\x98",
		"\x99" => "\xC2\x99",
		"\x9A" => "\xC2\x9A",
		"\x9B" => "\xC2\x9B",
		"\x9C" => "\xC2\x9C",
		"\x9D" => "\xC2\x9D",
		"\x9E" => "\xC2\x9E",
		"\x9F" => "\xC2\x9F",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xC4\x84",
		"\xA2" => "\xCB\x98",
		"\xA3" => "\xC5\x81",
		"\xA4" => "\xC2\xA4",
		"\xA5" => "\xC4\xBD",
		"\xA6" => "\xC5\x9A",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC2\xA8",
		"\xA9" => "\xC5\xA0",
		"\xAA" => "\xC5\x9E",
		"\xAB" => "\xC5\xA4",
		"\xAC" => "\xC5\xB9",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC5\xBD",
		"\xAF" => "\xC5\xBB",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC4\x85",
		"\xB2" => "\xCB\x9B",
		"\xB3" => "\xC5\x82",
		"\xB4" => "\xC2\xB4",
		"\xB5" => "\xC4\xBE",
		"\xB6" => "\xC5\x9B",
		"\xB7" => "\xCB\x87",
		"\xB8" => "\xC2\xB8",
		"\xB9" => "\xC5\xA1",
		"\xBA" => "\xC5\x9F",
		"\xBB" => "\xC5\xA5",
		"\xBC" => "\xC5\xBA",
		"\xBD" => "\xCB\x9D",
		"\xBE" => "\xC5\xBE",
		"\xBF" => "\xC5\xBC",
		"\xC0" => "\xC5\x94",
		"\xC1" => "\xC3\x81",
		"\xC2" => "\xC3\x82",
		"\xC3" => "\xC4\x82",
		"\xC4" => "\xC3\x84",
		"\xC5" => "\xC4\xB9",
		"\xC6" => "\xC4\x86",
		"\xC7" => "\xC3\x87",
		"\xC8" => "\xC4\x8C",
		"\xC9" => "\xC3\x89",
		"\xCA" => "\xC4\x98",
		"\xCB" => "\xC3\x8B",
		"\xCC" => "\xC4\x9A",
		"\xCD" => "\xC3\x8D",
		"\xCE" => "\xC3\x8E",
		"\xCF" => "\xC4\x8E",
		"\xD0" => "\xC4\x90",
		"\xD1" => "\xC5\x83",
		"\xD2" => "\xC5\x87",
		"\xD3" => "\xC3\x93",
		"\xD4" => "\xC3\x94",
		"\xD5" => "\xC5\x90",
		"\xD6" => "\xC3\x96",
		"\xD7" => "\xC3\x97",
		"\xD8" => "\xC5\x98",
		"\xD9" => "\xC5\xAE",
		"\xDA" => "\xC3\x9A",
		"\xDB" => "\xC5\xB0",
		"\xDC" => "\xC3\x9C",
		"\xDD" => "\xC3\x9D",
		"\xDE" => "\xC5\xA2",
		"\xDF" => "\xC3\x9F",
		"\xE0" => "\xC5\x95",
		"\xE1" => "\xC3\xA1",
		"\xE2" => "\xC3\xA2",
		"\xE3" => "\xC4\x83",
		"\xE4" => "\xC3\xA4",
		"\xE5" => "\xC4\xBA",
		"\xE6" => "\xC4\x87",
		"\xE7" => "\xC3\xA7",
		"\xE8" => "\xC4\x8D",
		"\xE9" => "\xC3\xA9",
		"\xEA" => "\xC4\x99",
		"\xEB" => "\xC3\xAB",
		"\xEC" => "\xC4\x9B",
		"\xED" => "\xC3\xAD",
		"\xEE" => "\xC3\xAE",
		"\xEF" => "\xC4\x8F",
		"\xF0" => "\xC4\x91",
		"\xF1" => "\xC5\x84",
		"\xF2" => "\xC5\x88",
		"\xF3" => "\xC3\xB3",
		"\xF4" => "\xC3\xB4",
		"\xF5" => "\xC5\x91",
		"\xF6" => "\xC3\xB6",
		"\xF7" => "\xC3\xB7",
		"\xF8" => "\xC5\x99",
		"\xF9" => "\xC5\xAF",
		"\xFA" => "\xC3\xBA",
		"\xFB" => "\xC5\xB1",
		"\xFC" => "\xC3\xBC",
		"\xFD" => "\xC3\xBD",
		"\xFE" => "\xC5\xA3",
		"\xFF" => "\xCB\x99",
	);
	return strtr($string, $transform);
}

function iso_8859_4($string)
{
	static $transform = array(
		"\x80" => "\xC2\x80",
		"\x81" => "\xC2\x81",
		"\x82" => "\xC2\x82",
		"\x83" => "\xC2\x83",
		"\x84" => "\xC2\x84",
		"\x85" => "\xC2\x85",
		"\x86" => "\xC2\x86",
		"\x87" => "\xC2\x87",
		"\x88" => "\xC2\x88",
		"\x89" => "\xC2\x89",
		"\x8A" => "\xC2\x8A",
		"\x8B" => "\xC2\x8B",
		"\x8C" => "\xC2\x8C",
		"\x8D" => "\xC2\x8D",
		"\x8E" => "\xC2\x8E",
		"\x8F" => "\xC2\x8F",
		"\x90" => "\xC2\x90",
		"\x91" => "\xC2\x91",
		"\x92" => "\xC2\x92",
		"\x93" => "\xC2\x93",
		"\x94" => "\xC2\x94",
		"\x95" => "\xC2\x95",
		"\x96" => "\xC2\x96",
		"\x97" => "\xC2\x97",
		"\x98" => "\xC2\x98",
		"\x99" => "\xC2\x99",
		"\x9A" => "\xC2\x9A",
		"\x9B" => "\xC2\x9B",
		"\x9C" => "\xC2\x9C",
		"\x9D" => "\xC2\x9D",
		"\x9E" => "\xC2\x9E",
		"\x9F" => "\xC2\x9F",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xC4\x84",
		"\xA2" => "\xC4\xB8",
		"\xA3" => "\xC5\x96",
		"\xA4" => "\xC2\xA4",
		"\xA5" => "\xC4\xA8",
		"\xA6" => "\xC4\xBB",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC2\xA8",
		"\xA9" => "\xC5\xA0",
		"\xAA" => "\xC4\x92",
		"\xAB" => "\xC4\xA2",
		"\xAC" => "\xC5\xA6",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC5\xBD",
		"\xAF" => "\xC2\xAF",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC4\x85",
		"\xB2" => "\xCB\x9B",
		"\xB3" => "\xC5\x97",
		"\xB4" => "\xC2\xB4",
		"\xB5" => "\xC4\xA9",
		"\xB6" => "\xC4\xBC",
		"\xB7" => "\xCB\x87",
		"\xB8" => "\xC2\xB8",
		"\xB9" => "\xC5\xA1",
		"\xBA" => "\xC4\x93",
		"\xBB" => "\xC4\xA3",
		"\xBC" => "\xC5\xA7",
		"\xBD" => "\xC5\x8A",
		"\xBE" => "\xC5\xBE",
		"\xBF" => "\xC5\x8B",
		"\xC0" => "\xC4\x80",
		"\xC1" => "\xC3\x81",
		"\xC2" => "\xC3\x82",
		"\xC3" => "\xC3\x83",
		"\xC4" => "\xC3\x84",
		"\xC5" => "\xC3\x85",
		"\xC6" => "\xC3\x86",
		"\xC7" => "\xC4\xAE",
		"\xC8" => "\xC4\x8C",
		"\xC9" => "\xC3\x89",
		"\xCA" => "\xC4\x98",
		"\xCB" => "\xC3\x8B",
		"\xCC" => "\xC4\x96",
		"\xCD" => "\xC3\x8D",
		"\xCE" => "\xC3\x8E",
		"\xCF" => "\xC4\xAA",
		"\xD0" => "\xC4\x90",
		"\xD1" => "\xC5\x85",
		"\xD2" => "\xC5\x8C",
		"\xD3" => "\xC4\xB6",
		"\xD4" => "\xC3\x94",
		"\xD5" => "\xC3\x95",
		"\xD6" => "\xC3\x96",
		"\xD7" => "\xC3\x97",
		"\xD8" => "\xC3\x98",
		"\xD9" => "\xC5\xB2",
		"\xDA" => "\xC3\x9A",
		"\xDB" => "\xC3\x9B",
		"\xDC" => "\xC3\x9C",
		"\xDD" => "\xC5\xA8",
		"\xDE" => "\xC5\xAA",
		"\xDF" => "\xC3\x9F",
		"\xE0" => "\xC4\x81",
		"\xE1" => "\xC3\xA1",
		"\xE2" => "\xC3\xA2",
		"\xE3" => "\xC3\xA3",
		"\xE4" => "\xC3\xA4",
		"\xE5" => "\xC3\xA5",
		"\xE6" => "\xC3\xA6",
		"\xE7" => "\xC4\xAF",
		"\xE8" => "\xC4\x8D",
		"\xE9" => "\xC3\xA9",
		"\xEA" => "\xC4\x99",
		"\xEB" => "\xC3\xAB",
		"\xEC" => "\xC4\x97",
		"\xED" => "\xC3\xAD",
		"\xEE" => "\xC3\xAE",
		"\xEF" => "\xC4\xAB",
		"\xF0" => "\xC4\x91",
		"\xF1" => "\xC5\x86",
		"\xF2" => "\xC5\x8D",
		"\xF3" => "\xC4\xB7",
		"\xF4" => "\xC3\xB4",
		"\xF5" => "\xC3\xB5",
		"\xF6" => "\xC3\xB6",
		"\xF7" => "\xC3\xB7",
		"\xF8" => "\xC3\xB8",
		"\xF9" => "\xC5\xB3",
		"\xFA" => "\xC3\xBA",
		"\xFB" => "\xC3\xBB",
		"\xFC" => "\xC3\xBC",
		"\xFD" => "\xC5\xA9",
		"\xFE" => "\xC5\xAB",
		"\xFF" => "\xCB\x99",
	);
	return strtr($string, $transform);
}

function iso_8859_7($string)
{
	static $transform = array(
		"\x80" => "\xC2\x80",
		"\x81" => "\xC2\x81",
		"\x82" => "\xC2\x82",
		"\x83" => "\xC2\x83",
		"\x84" => "\xC2\x84",
		"\x85" => "\xC2\x85",
		"\x86" => "\xC2\x86",
		"\x87" => "\xC2\x87",
		"\x88" => "\xC2\x88",
		"\x89" => "\xC2\x89",
		"\x8A" => "\xC2\x8A",
		"\x8B" => "\xC2\x8B",
		"\x8C" => "\xC2\x8C",
		"\x8D" => "\xC2\x8D",
		"\x8E" => "\xC2\x8E",
		"\x8F" => "\xC2\x8F",
		"\x90" => "\xC2\x90",
		"\x91" => "\xC2\x91",
		"\x92" => "\xC2\x92",
		"\x93" => "\xC2\x93",
		"\x94" => "\xC2\x94",
		"\x95" => "\xC2\x95",
		"\x96" => "\xC2\x96",
		"\x97" => "\xC2\x97",
		"\x98" => "\xC2\x98",
		"\x99" => "\xC2\x99",
		"\x9A" => "\xC2\x9A",
		"\x9B" => "\xC2\x9B",
		"\x9C" => "\xC2\x9C",
		"\x9D" => "\xC2\x9D",
		"\x9E" => "\xC2\x9E",
		"\x9F" => "\xC2\x9F",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xE2\x80\x98",
		"\xA2" => "\xE2\x80\x99",
		"\xA3" => "\xC2\xA3",
		"\xA4" => "\xE2\x82\xAC",
		"\xA5" => "\xE2\x82\xAF",
		"\xA6" => "\xC2\xA6",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC2\xA8",
		"\xA9" => "\xC2\xA9",
		"\xAA" => "\xCD\xBA",
		"\xAB" => "\xC2\xAB",
		"\xAC" => "\xC2\xAC",
		"\xAD" => "\xC2\xAD",
		"\xAF" => "\xE2\x80\x95",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC2\xB1",
		"\xB2" => "\xC2\xB2",
		"\xB3" => "\xC2\xB3",
		"\xB4" => "\xCE\x84",
		"\xB5" => "\xCE\x85",
		"\xB6" => "\xCE\x86",
		"\xB7" => "\xC2\xB7",
		"\xB8" => "\xCE\x88",
		"\xB9" => "\xCE\x89",
		"\xBA" => "\xCE\x8A",
		"\xBB" => "\xC2\xBB",
		"\xBC" => "\xCE\x8C",
		"\xBD" => "\xC2\xBD",
		"\xBE" => "\xCE\x8E",
		"\xBF" => "\xCE\x8F",
		"\xC0" => "\xCE\x90",
		"\xC1" => "\xCE\x91",
		"\xC2" => "\xCE\x92",
		"\xC3" => "\xCE\x93",
		"\xC4" => "\xCE\x94",
		"\xC5" => "\xCE\x95",
		"\xC6" => "\xCE\x96",
		"\xC7" => "\xCE\x97",
		"\xC8" => "\xCE\x98",
		"\xC9" => "\xCE\x99",
		"\xCA" => "\xCE\x9A",
		"\xCB" => "\xCE\x9B",
		"\xCC" => "\xCE\x9C",
		"\xCD" => "\xCE\x9D",
		"\xCE" => "\xCE\x9E",
		"\xCF" => "\xCE\x9F",
		"\xD0" => "\xCE\xA0",
		"\xD1" => "\xCE\xA1",
		"\xD3" => "\xCE\xA3",
		"\xD4" => "\xCE\xA4",
		"\xD5" => "\xCE\xA5",
		"\xD6" => "\xCE\xA6",
		"\xD7" => "\xCE\xA7",
		"\xD8" => "\xCE\xA8",
		"\xD9" => "\xCE\xA9",
		"\xDA" => "\xCE\xAA",
		"\xDB" => "\xCE\xAB",
		"\xDC" => "\xCE\xAC",
		"\xDD" => "\xCE\xAD",
		"\xDE" => "\xCE\xAE",
		"\xDF" => "\xCE\xAF",
		"\xE0" => "\xCE\xB0",
		"\xE1" => "\xCE\xB1",
		"\xE2" => "\xCE\xB2",
		"\xE3" => "\xCE\xB3",
		"\xE4" => "\xCE\xB4",
		"\xE5" => "\xCE\xB5",
		"\xE6" => "\xCE\xB6",
		"\xE7" => "\xCE\xB7",
		"\xE8" => "\xCE\xB8",
		"\xE9" => "\xCE\xB9",
		"\xEA" => "\xCE\xBA",
		"\xEB" => "\xCE\xBB",
		"\xEC" => "\xCE\xBC",
		"\xED" => "\xCE\xBD",
		"\xEE" => "\xCE\xBE",
		"\xEF" => "\xCE\xBF",
		"\xF0" => "\xCF\x80",
		"\xF1" => "\xCF\x81",
		"\xF2" => "\xCF\x82",
		"\xF3" => "\xCF\x83",
		"\xF4" => "\xCF\x84",
		"\xF5" => "\xCF\x85",
		"\xF6" => "\xCF\x86",
		"\xF7" => "\xCF\x87",
		"\xF8" => "\xCF\x88",
		"\xF9" => "\xCF\x89",
		"\xFA" => "\xCF\x8A",
		"\xFB" => "\xCF\x8B",
		"\xFC" => "\xCF\x8C",
		"\xFD" => "\xCF\x8D",
		"\xFE" => "\xCF\x8E",
	);
	return strtr($string, $transform);
}

function iso_8859_9($string)
{
	static $tranform = array(
		"\xC3\x90" => "\xC4\x9E",
		"\xC3\x9D" => "\xC4\xB0",
		"\xC3\x9E" => "\xC5\x9E",
		"\xC3\xB0" => "\xC4\x9F",
		"\xC3\xBD" => "\xC4\xB1",
		"\xC3\xBE" => "\xC5\x9F",
	);
	return strtr(utf8_encode($string), $transform);
}

function iso_8859_15($string)
{
	static $tranform = array(
		"\xC2\xA4" => "\xE2\x82\xAC",
		"\xC2\xA6" => "\xC5\xA0",
		"\xC2\xA8" => "\xC5\xA1",
		"\xC2\xB4" => "\xC5\xBD",
		"\xC2\xB8" => "\xC5\xBE",
		"\xC2\xBC" => "\xC5\x92",
		"\xC2\xBD" => "\xC5\x93",
		"\xC2\xBE" => "\xC5\xB8",
	);
	return strtr(utf8_encode($string), $transform);
}

// nearly the same as iso-8859-11
function tis_620($string)
{
	static $transform = array(
		"\x80" => "\xC2\x80",
		"\x81" => "\xC2\x81",
		"\x82" => "\xC2\x82",
		"\x83" => "\xC2\x83",
		"\x84" => "\xC2\x84",
		"\x85" => "\xC2\x85",
		"\x86" => "\xC2\x86",
		"\x87" => "\xC2\x87",
		"\x88" => "\xC2\x88",
		"\x89" => "\xC2\x89",
		"\x8A" => "\xC2\x8A",
		"\x8B" => "\xC2\x8B",
		"\x8C" => "\xC2\x8C",
		"\x8D" => "\xC2\x8D",
		"\x8E" => "\xC2\x8E",
		"\x8F" => "\xC2\x8F",
		"\x90" => "\xC2\x90",
		"\x91" => "\xC2\x91",
		"\x92" => "\xC2\x92",
		"\x93" => "\xC2\x93",
		"\x94" => "\xC2\x94",
		"\x95" => "\xC2\x95",
		"\x96" => "\xC2\x96",
		"\x97" => "\xC2\x97",
		"\x98" => "\xC2\x98",
		"\x99" => "\xC2\x99",
		"\x9A" => "\xC2\x9A",
		"\x9B" => "\xC2\x9B",
		"\x9C" => "\xC2\x9C",
		"\x9D" => "\xC2\x9D",
		"\x9E" => "\xC2\x9E",
		"\x9F" => "\xC2\x9F",
		"\xA1" => "\xE0\xB8\x81",
		"\xA2" => "\xE0\xB8\x82",
		"\xA3" => "\xE0\xB8\x83",
		"\xA4" => "\xE0\xB8\x84",
		"\xA5" => "\xE0\xB8\x85",
		"\xA6" => "\xE0\xB8\x86",
		"\xA7" => "\xE0\xB8\x87",
		"\xA8" => "\xE0\xB8\x88",
		"\xA9" => "\xE0\xB8\x89",
		"\xAA" => "\xE0\xB8\x8A",
		"\xAB" => "\xE0\xB8\x8B",
		"\xAC" => "\xE0\xB8\x8C",
		"\xAD" => "\xE0\xB8\x8D",
		"\xAE" => "\xE0\xB8\x8E",
		"\xAF" => "\xE0\xB8\x8F",
		"\xB0" => "\xE0\xB8\x90",
		"\xB1" => "\xE0\xB8\x91",
		"\xB2" => "\xE0\xB8\x92",
		"\xB3" => "\xE0\xB8\x93",
		"\xB4" => "\xE0\xB8\x94",
		"\xB5" => "\xE0\xB8\x95",
		"\xB6" => "\xE0\xB8\x96",
		"\xB7" => "\xE0\xB8\x97",
		"\xB8" => "\xE0\xB8\x98",
		"\xB9" => "\xE0\xB8\x99",
		"\xBA" => "\xE0\xB8\x9A",
		"\xBB" => "\xE0\xB8\x9B",
		"\xBC" => "\xE0\xB8\x9C",
		"\xBD" => "\xE0\xB8\x9D",
		"\xBE" => "\xE0\xB8\x9E",
		"\xBF" => "\xE0\xB8\x9F",
		"\xC0" => "\xE0\xB8\xA0",
		"\xC1" => "\xE0\xB8\xA1",
		"\xC2" => "\xE0\xB8\xA2",
		"\xC3" => "\xE0\xB8\xA3",
		"\xC4" => "\xE0\xB8\xA4",
		"\xC5" => "\xE0\xB8\xA5",
		"\xC6" => "\xE0\xB8\xA6",
		"\xC7" => "\xE0\xB8\xA7",
		"\xC8" => "\xE0\xB8\xA8",
		"\xC9" => "\xE0\xB8\xA9",
		"\xCA" => "\xE0\xB8\xAA",
		"\xCB" => "\xE0\xB8\xAB",
		"\xCC" => "\xE0\xB8\xAC",
		"\xCD" => "\xE0\xB8\xAD",
		"\xCE" => "\xE0\xB8\xAE",
		"\xCF" => "\xE0\xB8\xAF",
		"\xD0" => "\xE0\xB8\xB0",
		"\xD1" => "\xE0\xB8\xB1",
		"\xD2" => "\xE0\xB8\xB2",
		"\xD3" => "\xE0\xB8\xB3",
		"\xD4" => "\xE0\xB8\xB4",
		"\xD5" => "\xE0\xB8\xB5",
		"\xD6" => "\xE0\xB8\xB6",
		"\xD7" => "\xE0\xB8\xB7",
		"\xD8" => "\xE0\xB8\xB8",
		"\xD9" => "\xE0\xB8\xB9",
		"\xDA" => "\xE0\xB8\xBA",
		"\xDF" => "\xE0\xB8\xBF",
		"\xE0" => "\xE0\xB9\x80",
		"\xE1" => "\xE0\xB9\x81",
		"\xE2" => "\xE0\xB9\x82",
		"\xE3" => "\xE0\xB9\x83",
		"\xE4" => "\xE0\xB9\x84",
		"\xE5" => "\xE0\xB9\x85",
		"\xE6" => "\xE0\xB9\x86",
		"\xE7" => "\xE0\xB9\x87",
		"\xE8" => "\xE0\xB9\x88",
		"\xE9" => "\xE0\xB9\x89",
		"\xEA" => "\xE0\xB9\x8A",
		"\xEB" => "\xE0\xB9\x8B",
		"\xEC" => "\xE0\xB9\x8C",
		"\xED" => "\xE0\xB9\x8D",
		"\xEE" => "\xE0\xB9\x8E",
		"\xEF" => "\xE0\xB9\x8F",
		"\xF0" => "\xE0\xB9\x90",
		"\xF1" => "\xE0\xB9\x91",
		"\xF2" => "\xE0\xB9\x92",
		"\xF3" => "\xE0\xB9\x93",
		"\xF4" => "\xE0\xB9\x94",
		"\xF5" => "\xE0\xB9\x95",
		"\xF6" => "\xE0\xB9\x96",
		"\xF7" => "\xE0\xB9\x97",
		"\xF8" => "\xE0\xB9\x98",
		"\xF9" => "\xE0\xB9\x99",
		"\xFA" => "\xE0\xB9\x9A",
		"\xFB" => "\xE0\xB9\x9B",
	);
	return strtr($string, $transform);
}

function cp874($string)
{
	static $transform = array(
		"\x80" => "\xE2\x82\xAC",
		"\x85" => "\xE2\x80\xA6",
		"\x91" => "\xE2\x80\x98",
		"\x92" => "\xE2\x80\x99",
		"\x93" => "\xE2\x80\x9C",
		"\x94" => "\xE2\x80\x9D",
		"\x95" => "\xE2\x80\xA2",
		"\x96" => "\xE2\x80\x93",
		"\x97" => "\xE2\x80\x94",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xE0\xB8\x81",
		"\xA2" => "\xE0\xB8\x82",
		"\xA3" => "\xE0\xB8\x83",
		"\xA4" => "\xE0\xB8\x84",
		"\xA5" => "\xE0\xB8\x85",
		"\xA6" => "\xE0\xB8\x86",
		"\xA7" => "\xE0\xB8\x87",
		"\xA8" => "\xE0\xB8\x88",
		"\xA9" => "\xE0\xB8\x89",
		"\xAA" => "\xE0\xB8\x8A",
		"\xAB" => "\xE0\xB8\x8B",
		"\xAC" => "\xE0\xB8\x8C",
		"\xAD" => "\xE0\xB8\x8D",
		"\xAE" => "\xE0\xB8\x8E",
		"\xAF" => "\xE0\xB8\x8F",
		"\xB0" => "\xE0\xB8\x90",
		"\xB1" => "\xE0\xB8\x91",
		"\xB2" => "\xE0\xB8\x92",
		"\xB3" => "\xE0\xB8\x93",
		"\xB4" => "\xE0\xB8\x94",
		"\xB5" => "\xE0\xB8\x95",
		"\xB6" => "\xE0\xB8\x96",
		"\xB7" => "\xE0\xB8\x97",
		"\xB8" => "\xE0\xB8\x98",
		"\xB9" => "\xE0\xB8\x99",
		"\xBA" => "\xE0\xB8\x9A",
		"\xBB" => "\xE0\xB8\x9B",
		"\xBC" => "\xE0\xB8\x9C",
		"\xBD" => "\xE0\xB8\x9D",
		"\xBE" => "\xE0\xB8\x9E",
		"\xBF" => "\xE0\xB8\x9F",
		"\xC0" => "\xE0\xB8\xA0",
		"\xC1" => "\xE0\xB8\xA1",
		"\xC2" => "\xE0\xB8\xA2",
		"\xC3" => "\xE0\xB8\xA3",
		"\xC4" => "\xE0\xB8\xA4",
		"\xC5" => "\xE0\xB8\xA5",
		"\xC6" => "\xE0\xB8\xA6",
		"\xC7" => "\xE0\xB8\xA7",
		"\xC8" => "\xE0\xB8\xA8",
		"\xC9" => "\xE0\xB8\xA9",
		"\xCA" => "\xE0\xB8\xAA",
		"\xCB" => "\xE0\xB8\xAB",
		"\xCC" => "\xE0\xB8\xAC",
		"\xCD" => "\xE0\xB8\xAD",
		"\xCE" => "\xE0\xB8\xAE",
		"\xCF" => "\xE0\xB8\xAF",
		"\xD0" => "\xE0\xB8\xB0",
		"\xD1" => "\xE0\xB8\xB1",
		"\xD2" => "\xE0\xB8\xB2",
		"\xD3" => "\xE0\xB8\xB3",
		"\xD4" => "\xE0\xB8\xB4",
		"\xD5" => "\xE0\xB8\xB5",
		"\xD6" => "\xE0\xB8\xB6",
		"\xD7" => "\xE0\xB8\xB7",
		"\xD8" => "\xE0\xB8\xB8",
		"\xD9" => "\xE0\xB8\xB9",
		"\xDA" => "\xE0\xB8\xBA",
		"\xDF" => "\xE0\xB8\xBF",
		"\xE0" => "\xE0\xB9\x80",
		"\xE1" => "\xE0\xB9\x81",
		"\xE2" => "\xE0\xB9\x82",
		"\xE3" => "\xE0\xB9\x83",
		"\xE4" => "\xE0\xB9\x84",
		"\xE5" => "\xE0\xB9\x85",
		"\xE6" => "\xE0\xB9\x86",
		"\xE7" => "\xE0\xB9\x87",
		"\xE8" => "\xE0\xB9\x88",
		"\xE9" => "\xE0\xB9\x89",
		"\xEA" => "\xE0\xB9\x8A",
		"\xEB" => "\xE0\xB9\x8B",
		"\xEC" => "\xE0\xB9\x8C",
		"\xED" => "\xE0\xB9\x8D",
		"\xEE" => "\xE0\xB9\x8E",
		"\xEF" => "\xE0\xB9\x8F",
		"\xF0" => "\xE0\xB9\x90",
		"\xF1" => "\xE0\xB9\x91",
		"\xF2" => "\xE0\xB9\x92",
		"\xF3" => "\xE0\xB9\x93",
		"\xF4" => "\xE0\xB9\x94",
		"\xF5" => "\xE0\xB9\x95",
		"\xF6" => "\xE0\xB9\x96",
		"\xF7" => "\xE0\xB9\x97",
		"\xF8" => "\xE0\xB9\x98",
		"\xF9" => "\xE0\xB9\x99",
		"\xFA" => "\xE0\xB9\x9A",
		"\xFB" => "\xE0\xB9\x9B",
	);
	return strtr($string, $transform);
}

function cp1250($string)
{
	static $transform = array(
		"\x80" => "\xE2\x82\xAC",
		"\x82" => "\xE2\x80\x9A",
		"\x84" => "\xE2\x80\x9E",
		"\x85" => "\xE2\x80\xA6",
		"\x86" => "\xE2\x80\xA0",
		"\x87" => "\xE2\x80\xA1",
		"\x89" => "\xE2\x80\xB0",
		"\x8A" => "\xC5\xA0",
		"\x8B" => "\xE2\x80\xB9",
		"\x8C" => "\xC5\x9A",
		"\x8D" => "\xC5\xA4",
		"\x8E" => "\xC5\xBD",
		"\x8F" => "\xC5\xB9",
		"\x91" => "\xE2\x80\x98",
		"\x92" => "\xE2\x80\x99",
		"\x93" => "\xE2\x80\x9C",
		"\x94" => "\xE2\x80\x9D",
		"\x95" => "\xE2\x80\xA2",
		"\x96" => "\xE2\x80\x93",
		"\x97" => "\xE2\x80\x94",
		"\x99" => "\xE2\x84\xA2",
		"\x9A" => "\xC5\xA1",
		"\x9B" => "\xE2\x80\xBA",
		"\x9C" => "\xC5\x9B",
		"\x9D" => "\xC5\xA5",
		"\x9E" => "\xC5\xBE",
		"\x9F" => "\xC5\xBA",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xCB\x87",
		"\xA2" => "\xCB\x98",
		"\xA3" => "\xC5\x81",
		"\xA4" => "\xC2\xA4",
		"\xA5" => "\xC4\x84",
		"\xA6" => "\xC2\xA6",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC2\xA8",
		"\xA9" => "\xC2\xA9",
		"\xAA" => "\xC5\x9E",
		"\xAB" => "\xC2\xAB",
		"\xAC" => "\xC2\xAC",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC2\xAE",
		"\xAF" => "\xC5\xBB",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC2\xB1",
		"\xB2" => "\xCB\x9B",
		"\xB3" => "\xC5\x82",
		"\xB4" => "\xC2\xB4",
		"\xB5" => "\xC2\xB5",
		"\xB6" => "\xC2\xB6",
		"\xB7" => "\xC2\xB7",
		"\xB8" => "\xC2\xB8",
		"\xB9" => "\xC4\x85",
		"\xBA" => "\xC5\x9F",
		"\xBB" => "\xC2\xBB",
		"\xBC" => "\xC4\xBD",
		"\xBD" => "\xCB\x9D",
		"\xBE" => "\xC4\xBE",
		"\xBF" => "\xC5\xBC",
		"\xC0" => "\xC5\x94",
		"\xC1" => "\xC3\x81",
		"\xC2" => "\xC3\x82",
		"\xC3" => "\xC4\x82",
		"\xC4" => "\xC3\x84",
		"\xC5" => "\xC4\xB9",
		"\xC6" => "\xC4\x86",
		"\xC7" => "\xC3\x87",
		"\xC8" => "\xC4\x8C",
		"\xC9" => "\xC3\x89",
		"\xCA" => "\xC4\x98",
		"\xCB" => "\xC3\x8B",
		"\xCC" => "\xC4\x9A",
		"\xCD" => "\xC3\x8D",
		"\xCE" => "\xC3\x8E",
		"\xCF" => "\xC4\x8E",
		"\xD0" => "\xC4\x90",
		"\xD1" => "\xC5\x83",
		"\xD2" => "\xC5\x87",
		"\xD3" => "\xC3\x93",
		"\xD4" => "\xC3\x94",
		"\xD5" => "\xC5\x90",
		"\xD6" => "\xC3\x96",
		"\xD7" => "\xC3\x97",
		"\xD8" => "\xC5\x98",
		"\xD9" => "\xC5\xAE",
		"\xDA" => "\xC3\x9A",
		"\xDB" => "\xC5\xB0",
		"\xDC" => "\xC3\x9C",
		"\xDD" => "\xC3\x9D",
		"\xDE" => "\xC5\xA2",
		"\xDF" => "\xC3\x9F",
		"\xE0" => "\xC5\x95",
		"\xE1" => "\xC3\xA1",
		"\xE2" => "\xC3\xA2",
		"\xE3" => "\xC4\x83",
		"\xE4" => "\xC3\xA4",
		"\xE5" => "\xC4\xBA",
		"\xE6" => "\xC4\x87",
		"\xE7" => "\xC3\xA7",
		"\xE8" => "\xC4\x8D",
		"\xE9" => "\xC3\xA9",
		"\xEA" => "\xC4\x99",
		"\xEB" => "\xC3\xAB",
		"\xEC" => "\xC4\x9B",
		"\xED" => "\xC3\xAD",
		"\xEE" => "\xC3\xAE",
		"\xEF" => "\xC4\x8F",
		"\xF0" => "\xC4\x91",
		"\xF1" => "\xC5\x84",
		"\xF2" => "\xC5\x88",
		"\xF3" => "\xC3\xB3",
		"\xF4" => "\xC3\xB4",
		"\xF5" => "\xC5\x91",
		"\xF6" => "\xC3\xB6",
		"\xF7" => "\xC3\xB7",
		"\xF8" => "\xC5\x99",
		"\xF9" => "\xC5\xAF",
		"\xFA" => "\xC3\xBA",
		"\xFB" => "\xC5\xB1",
		"\xFC" => "\xC3\xBC",
		"\xFD" => "\xC3\xBD",
		"\xFE" => "\xC5\xA3",
		"\xFF" => "\xCB\x99",
	);
	return strtr($string, $transform);
}

function cp1251($string)
{
	static $transform = array(
		"\x80" => "\xD0\x82",
		"\x81" => "\xD0\x83",
		"\x82" => "\xE2\x80\x9A",
		"\x83" => "\xD1\x93",
		"\x84" => "\xE2\x80\x9E",
		"\x85" => "\xE2\x80\xA6",
		"\x86" => "\xE2\x80\xA0",
		"\x87" => "\xE2\x80\xA1",
		"\x88" => "\xE2\x82\xAC",
		"\x89" => "\xE2\x80\xB0",
		"\x8A" => "\xD0\x89",
		"\x8B" => "\xE2\x80\xB9",
		"\x8C" => "\xD0\x8A",
		"\x8D" => "\xD0\x8C",
		"\x8E" => "\xD0\x8B",
		"\x8F" => "\xD0\x8F",
		"\x90" => "\xD1\x92",
		"\x91" => "\xE2\x80\x98",
		"\x92" => "\xE2\x80\x99",
		"\x93" => "\xE2\x80\x9C",
		"\x94" => "\xE2\x80\x9D",
		"\x95" => "\xE2\x80\xA2",
		"\x96" => "\xE2\x80\x93",
		"\x97" => "\xE2\x80\x94",
		"\x99" => "\xE2\x84\xA2",
		"\x9A" => "\xD1\x99",
		"\x9B" => "\xE2\x80\xBA",
		"\x9C" => "\xD1\x9A",
		"\x9D" => "\xD1\x9C",
		"\x9E" => "\xD1\x9B",
		"\x9F" => "\xD1\x9F",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xD0\x8E",
		"\xA2" => "\xD1\x9E",
		"\xA3" => "\xD0\x88",
		"\xA4" => "\xC2\xA4",
		"\xA5" => "\xD2\x90",
		"\xA6" => "\xC2\xA6",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xD0\x81",
		"\xA9" => "\xC2\xA9",
		"\xAA" => "\xD0\x84",
		"\xAB" => "\xC2\xAB",
		"\xAC" => "\xC2\xAC",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC2\xAE",
		"\xAF" => "\xD0\x87",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC2\xB1",
		"\xB2" => "\xD0\x86",
		"\xB3" => "\xD1\x96",
		"\xB4" => "\xD2\x91",
		"\xB5" => "\xC2\xB5",
		"\xB6" => "\xC2\xB6",
		"\xB7" => "\xC2\xB7",
		"\xB8" => "\xD1\x91",
		"\xB9" => "\xE2\x84\x96",
		"\xBA" => "\xD1\x94",
		"\xBB" => "\xC2\xBB",
		"\xBC" => "\xD1\x98",
		"\xBD" => "\xD0\x85",
		"\xBE" => "\xD1\x95",
		"\xBF" => "\xD1\x97",
		"\xC0" => "\xD0\x90",
		"\xC1" => "\xD0\x91",
		"\xC2" => "\xD0\x92",
		"\xC3" => "\xD0\x93",
		"\xC4" => "\xD0\x94",
		"\xC5" => "\xD0\x95",
		"\xC6" => "\xD0\x96",
		"\xC7" => "\xD0\x97",
		"\xC8" => "\xD0\x98",
		"\xC9" => "\xD0\x99",
		"\xCA" => "\xD0\x9A",
		"\xCB" => "\xD0\x9B",
		"\xCC" => "\xD0\x9C",
		"\xCD" => "\xD0\x9D",
		"\xCE" => "\xD0\x9E",
		"\xCF" => "\xD0\x9F",
		"\xD0" => "\xD0\xA0",
		"\xD1" => "\xD0\xA1",
		"\xD2" => "\xD0\xA2",
		"\xD3" => "\xD0\xA3",
		"\xD4" => "\xD0\xA4",
		"\xD5" => "\xD0\xA5",
		"\xD6" => "\xD0\xA6",
		"\xD7" => "\xD0\xA7",
		"\xD8" => "\xD0\xA8",
		"\xD9" => "\xD0\xA9",
		"\xDA" => "\xD0\xAA",
		"\xDB" => "\xD0\xAB",
		"\xDC" => "\xD0\xAC",
		"\xDD" => "\xD0\xAD",
		"\xDE" => "\xD0\xAE",
		"\xDF" => "\xD0\xAF",
		"\xE0" => "\xD0\xB0",
		"\xE1" => "\xD0\xB1",
		"\xE2" => "\xD0\xB2",
		"\xE3" => "\xD0\xB3",
		"\xE4" => "\xD0\xB4",
		"\xE5" => "\xD0\xB5",
		"\xE6" => "\xD0\xB6",
		"\xE7" => "\xD0\xB7",
		"\xE8" => "\xD0\xB8",
		"\xE9" => "\xD0\xB9",
		"\xEA" => "\xD0\xBA",
		"\xEB" => "\xD0\xBB",
		"\xEC" => "\xD0\xBC",
		"\xED" => "\xD0\xBD",
		"\xEE" => "\xD0\xBE",
		"\xEF" => "\xD0\xBF",
		"\xF0" => "\xD1\x80",
		"\xF1" => "\xD1\x81",
		"\xF2" => "\xD1\x82",
		"\xF3" => "\xD1\x83",
		"\xF4" => "\xD1\x84",
		"\xF5" => "\xD1\x85",
		"\xF6" => "\xD1\x86",
		"\xF7" => "\xD1\x87",
		"\xF8" => "\xD1\x88",
		"\xF9" => "\xD1\x89",
		"\xFA" => "\xD1\x8A",
		"\xFB" => "\xD1\x8B",
		"\xFC" => "\xD1\x8C",
		"\xFD" => "\xD1\x8D",
		"\xFE" => "\xD1\x8E",
		"\xFF" => "\xD1\x8F",
	);
	return strtr($string, $transform);
}

function cp1252($string)
{
	static $transform = array(
		"\xC2\x80" => "\xE2\x82\xAC",
		"\xC2\x82" => "\xE2\x80\x9A",
		"\xC2\x83" => "\xC6\x92",
		"\xC2\x84" => "\xE2\x80\x9E",
		"\xC2\x85" => "\xE2\x80\xA6",
		"\xC2\x86" => "\xE2\x80\xA0",
		"\xC2\x87" => "\xE2\x80\xA1",
		"\xC2\x88" => "\xCB\x86",
		"\xC2\x89" => "\xE2\x80\xB0",
		"\xC2\x8A" => "\xC5\xA0",
		"\xC2\x8B" => "\xE2\x80\xB9",
		"\xC2\x8C" => "\xC5\x92",
		"\xC2\x8E" => "\xC5\xBD",
		"\xC2\x91" => "\xE2\x80\x98",
		"\xC2\x92" => "\xE2\x80\x99",
		"\xC2\x93" => "\xE2\x80\x9C",
		"\xC2\x94" => "\xE2\x80\x9D",
		"\xC2\x95" => "\xE2\x80\xA2",
		"\xC2\x96" => "\xE2\x80\x93",
		"\xC2\x97" => "\xE2\x80\x94",
		"\xC2\x98" => "\xCB\x9C",
		"\xC2\x99" => "\xE2\x84\xA2",
		"\xC2\x9A" => "\xC5\xA1",
		"\xC2\x9B" => "\xE2\x80\xBA",
		"\xC2\x9C" => "\xC5\x93",
		"\xC2\x9E" => "\xC5\xBE",
		"\xC2\x9F" => "\xC5\xB8"
	);
	return strtr(utf8_encode($string), $transform);
}

function cp1254($string)
{
	static $tranform = array(
		"\xC2\x80" => "\xE2\x82\xAC",
		"\xC2\x82" => "\xE2\x80\x9A",
		"\xC2\x83" => "\xC6\x92",
		"\xC2\x84" => "\xE2\x80\x9E",
		"\xC2\x85" => "\xE2\x80\xA6",
		"\xC2\x86" => "\xE2\x80\xA0",
		"\xC2\x87" => "\xE2\x80\xA1",
		"\xC2\x88" => "\xCB\x86",
		"\xC2\x89" => "\xE2\x80\xB0",
		"\xC2\x8A" => "\xC5\xA0",
		"\xC2\x8B" => "\xE2\x80\xB9",
		"\xC2\x8C" => "\xC5\x92",
		"\xC2\x91" => "\xE2\x80\x98",
		"\xC2\x92" => "\xE2\x80\x99",
		"\xC2\x93" => "\xE2\x80\x9C",
		"\xC2\x94" => "\xE2\x80\x9D",
		"\xC2\x95" => "\xE2\x80\xA2",
		"\xC2\x96" => "\xE2\x80\x93",
		"\xC2\x97" => "\xE2\x80\x94",
		"\xC2\x98" => "\xCB\x9C",
		"\xC2\x99" => "\xE2\x84\xA2",
		"\xC2\x9A" => "\xC5\xA1",
		"\xC2\x9B" => "\xE2\x80\xBA",
		"\xC2\x9C" => "\xC5\x93",
		"\xC2\x9F" => "\xC5\xB8",
		"\xC3\x90" => "\xC4\x9E",
		"\xC3\x9D" => "\xC4\xB0",
		"\xC3\x9E" => "\xC5\x9E",
		"\xC3\xB0" => "\xC4\x9F",
		"\xC3\xBD" => "\xC4\xB1",
		"\xC3\xBE" => "\xC5\x9F",
	);
	return strtr(utf8_encode($string), $transform);
}

function cp1255($string)
{
	static $transform = array(
		"\x80" => "\xE2\x82\xAC",
		"\x82" => "\xE2\x80\x9A",
		"\x83" => "\xC6\x92",
		"\x84" => "\xE2\x80\x9E",
		"\x85" => "\xE2\x80\xA6",
		"\x86" => "\xE2\x80\xA0",
		"\x87" => "\xE2\x80\xA1",
		"\x88" => "\xCB\x86",
		"\x89" => "\xE2\x80\xB0",
		"\x8B" => "\xE2\x80\xB9",
		"\x91" => "\xE2\x80\x98",
		"\x92" => "\xE2\x80\x99",
		"\x93" => "\xE2\x80\x9C",
		"\x94" => "\xE2\x80\x9D",
		"\x95" => "\xE2\x80\xA2",
		"\x96" => "\xE2\x80\x93",
		"\x97" => "\xE2\x80\x94",
		"\x98" => "\xCB\x9C",
		"\x99" => "\xE2\x84\xA2",
		"\x9B" => "\xE2\x80\xBA",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xC2\xA1",
		"\xA2" => "\xC2\xA2",
		"\xA3" => "\xC2\xA3",
		"\xA4" => "\xE2\x82\xAA",
		"\xA5" => "\xC2\xA5",
		"\xA6" => "\xC2\xA6",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC2\xA8",
		"\xA9" => "\xC2\xA9",
		"\xAA" => "\xC3\x97",
		"\xAB" => "\xC2\xAB",
		"\xAC" => "\xC2\xAC",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC2\xAE",
		"\xAF" => "\xC2\xAF",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC2\xB1",
		"\xB2" => "\xC2\xB2",
		"\xB3" => "\xC2\xB3",
		"\xB4" => "\xC2\xB4",
		"\xB5" => "\xC2\xB5",
		"\xB6" => "\xC2\xB6",
		"\xB7" => "\xC2\xB7",
		"\xB8" => "\xC2\xB8",
		"\xB9" => "\xC2\xB9",
		"\xBA" => "\xC3\xB7",
		"\xBB" => "\xC2\xBB",
		"\xBC" => "\xC2\xBC",
		"\xBD" => "\xC2\xBD",
		"\xBE" => "\xC2\xBE",
		"\xBF" => "\xC2\xBF",
		"\xC0" => "\xD6\xB0",
		"\xC1" => "\xD6\xB1",
		"\xC2" => "\xD6\xB2",
		"\xC3" => "\xD6\xB3",
		"\xC4" => "\xD6\xB4",
		"\xC5" => "\xD6\xB5",
		"\xC6" => "\xD6\xB6",
		"\xC7" => "\xD6\xB7",
		"\xC8" => "\xD6\xB8",
		"\xC9" => "\xD6\xB9",
		"\xCB" => "\xD6\xBB",
		"\xCC" => "\xD6\xBC",
		"\xCD" => "\xD6\xBD",
		"\xCE" => "\xD6\xBE",
		"\xCF" => "\xD6\xBF",
		"\xD0" => "\xD7\x80",
		"\xD1" => "\xD7\x81",
		"\xD2" => "\xD7\x82",
		"\xD3" => "\xD7\x83",
		"\xD4" => "\xD7\xB0",
		"\xD5" => "\xD7\xB1",
		"\xD6" => "\xD7\xB2",
		"\xD7" => "\xD7\xB3",
		"\xD8" => "\xD7\xB4",
		"\xE0" => "\xD7\x90",
		"\xE1" => "\xD7\x91",
		"\xE2" => "\xD7\x92",
		"\xE3" => "\xD7\x93",
		"\xE4" => "\xD7\x94",
		"\xE5" => "\xD7\x95",
		"\xE6" => "\xD7\x96",
		"\xE7" => "\xD7\x97",
		"\xE8" => "\xD7\x98",
		"\xE9" => "\xD7\x99",
		"\xEA" => "\xD7\x9A",
		"\xEB" => "\xD7\x9B",
		"\xEC" => "\xD7\x9C",
		"\xED" => "\xD7\x9D",
		"\xEE" => "\xD7\x9E",
		"\xEF" => "\xD7\x9F",
		"\xF0" => "\xD7\xA0",
		"\xF1" => "\xD7\xA1",
		"\xF2" => "\xD7\xA2",
		"\xF3" => "\xD7\xA3",
		"\xF4" => "\xD7\xA4",
		"\xF5" => "\xD7\xA5",
		"\xF6" => "\xD7\xA6",
		"\xF7" => "\xD7\xA7",
		"\xF8" => "\xD7\xA8",
		"\xF9" => "\xD7\xA9",
		"\xFA" => "\xD7\xAA",
		"\xFD" => "\xE2\x80\x8E",
		"\xFE" => "\xE2\x80\x8F",
	);
	return strtr($string, $transform);
}

function cp1256($string)
{
	static $transform = array(
		"\x80" => "\xE2\x82\xAC",
		"\x81" => "\xD9\xBE",
		"\x82" => "\xE2\x80\x9A",
		"\x83" => "\xC6\x92",
		"\x84" => "\xE2\x80\x9E",
		"\x85" => "\xE2\x80\xA6",
		"\x86" => "\xE2\x80\xA0",
		"\x87" => "\xE2\x80\xA1",
		"\x88" => "\xCB\x86",
		"\x89" => "\xE2\x80\xB0",
		"\x8A" => "\xD9\xB9",
		"\x8B" => "\xE2\x80\xB9",
		"\x8C" => "\xC5\x92",
		"\x8D" => "\xDA\x86",
		"\x8E" => "\xDA\x98",
		"\x8F" => "\xDA\x88",
		"\x90" => "\xDA\xAF",
		"\x91" => "\xE2\x80\x98",
		"\x92" => "\xE2\x80\x99",
		"\x93" => "\xE2\x80\x9C",
		"\x94" => "\xE2\x80\x9D",
		"\x95" => "\xE2\x80\xA2",
		"\x96" => "\xE2\x80\x93",
		"\x97" => "\xE2\x80\x94",
		"\x98" => "\xDA\xA9",
		"\x99" => "\xE2\x84\xA2",
		"\x9A" => "\xDA\x91",
		"\x9B" => "\xE2\x80\xBA",
		"\x9C" => "\xC5\x93",
		"\x9D" => "\xE2\x80\x8C",
		"\x9E" => "\xE2\x80\x8D",
		"\x9F" => "\xDA\xBA",
		"\xA0" => "\xC2\xA0",
		"\xA1" => "\xD8\x8C",
		"\xA2" => "\xC2\xA2",
		"\xA3" => "\xC2\xA3",
		"\xA4" => "\xC2\xA4",
		"\xA5" => "\xC2\xA5",
		"\xA6" => "\xC2\xA6",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC2\xA8",
		"\xA9" => "\xC2\xA9",
		"\xAA" => "\xDA\xBE",
		"\xAB" => "\xC2\xAB",
		"\xAC" => "\xC2\xAC",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC2\xAE",
		"\xAF" => "\xC2\xAF",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC2\xB1",
		"\xB2" => "\xC2\xB2",
		"\xB3" => "\xC2\xB3",
		"\xB4" => "\xC2\xB4",
		"\xB5" => "\xC2\xB5",
		"\xB6" => "\xC2\xB6",
		"\xB7" => "\xC2\xB7",
		"\xB8" => "\xC2\xB8",
		"\xB9" => "\xC2\xB9",
		"\xBA" => "\xD8\x9B",
		"\xBB" => "\xC2\xBB",
		"\xBC" => "\xC2\xBC",
		"\xBD" => "\xC2\xBD",
		"\xBE" => "\xC2\xBE",
		"\xBF" => "\xD8\x9F",
		"\xC0" => "\xDB\x81",
		"\xC1" => "\xD8\xA1",
		"\xC2" => "\xD8\xA2",
		"\xC3" => "\xD8\xA3",
		"\xC4" => "\xD8\xA4",
		"\xC5" => "\xD8\xA5",
		"\xC6" => "\xD8\xA6",
		"\xC7" => "\xD8\xA7",
		"\xC8" => "\xD8\xA8",
		"\xC9" => "\xD8\xA9",
		"\xCA" => "\xD8\xAA",
		"\xCB" => "\xD8\xAB",
		"\xCC" => "\xD8\xAC",
		"\xCD" => "\xD8\xAD",
		"\xCE" => "\xD8\xAE",
		"\xCF" => "\xD8\xAF",
		"\xD0" => "\xD8\xB0",
		"\xD1" => "\xD8\xB1",
		"\xD2" => "\xD8\xB2",
		"\xD3" => "\xD8\xB3",
		"\xD4" => "\xD8\xB4",
		"\xD5" => "\xD8\xB5",
		"\xD6" => "\xD8\xB6",
		"\xD7" => "\xC3\x97",
		"\xD8" => "\xD8\xB7",
		"\xD9" => "\xD8\xB8",
		"\xDA" => "\xD8\xB9",
		"\xDB" => "\xD8\xBA",
		"\xDC" => "\xD9\x80",
		"\xDD" => "\xD9\x81",
		"\xDE" => "\xD9\x82",
		"\xDF" => "\xD9\x83",
		"\xE0" => "\xC3\xA0",
		"\xE1" => "\xD9\x84",
		"\xE2" => "\xC3\xA2",
		"\xE3" => "\xD9\x85",
		"\xE4" => "\xD9\x86",
		"\xE5" => "\xD9\x87",
		"\xE6" => "\xD9\x88",
		"\xE7" => "\xC3\xA7",
		"\xE8" => "\xC3\xA8",
		"\xE9" => "\xC3\xA9",
		"\xEA" => "\xC3\xAA",
		"\xEB" => "\xC3\xAB",
		"\xEC" => "\xD9\x89",
		"\xED" => "\xD9\x8A",
		"\xEE" => "\xC3\xAE",
		"\xEF" => "\xC3\xAF",
		"\xF0" => "\xD9\x8B",
		"\xF1" => "\xD9\x8C",
		"\xF2" => "\xD9\x8D",
		"\xF3" => "\xD9\x8E",
		"\xF4" => "\xC3\xB4",
		"\xF5" => "\xD9\x8F",
		"\xF6" => "\xD9\x90",
		"\xF7" => "\xC3\xB7",
		"\xF8" => "\xD9\x91",
		"\xF9" => "\xC3\xB9",
		"\xFA" => "\xD9\x92",
		"\xFB" => "\xC3\xBB",
		"\xFC" => "\xC3\xBC",
		"\xFD" => "\xE2\x80\x8E",
		"\xFE" => "\xE2\x80\x8F",
		"\xFF" => "\xDB\x92",
	);
	return strtr($string, $transform);
}

function cp1257($string)
{
	static $transform = array(
		"\x80" => "\xE2\x82\xAC",
		"\x82" => "\xE2\x80\x9A",
		"\x84" => "\xE2\x80\x9E",
		"\x85" => "\xE2\x80\xA6",
		"\x86" => "\xE2\x80\xA0",
		"\x87" => "\xE2\x80\xA1",
		"\x89" => "\xE2\x80\xB0",
		"\x8B" => "\xE2\x80\xB9",
		"\x8D" => "\xC2\xA8",
		"\x8E" => "\xCB\x87",
		"\x8F" => "\xC2\xB8",
		"\x91" => "\xE2\x80\x98",
		"\x92" => "\xE2\x80\x99",
		"\x93" => "\xE2\x80\x9C",
		"\x94" => "\xE2\x80\x9D",
		"\x95" => "\xE2\x80\xA2",
		"\x96" => "\xE2\x80\x93",
		"\x97" => "\xE2\x80\x94",
		"\x99" => "\xE2\x84\xA2",
		"\x9B" => "\xE2\x80\xBA",
		"\x9D" => "\xC2\xAF",
		"\x9E" => "\xCB\x9B",
		"\xA0" => "\xC2\xA0",
		"\xA2" => "\xC2\xA2",
		"\xA3" => "\xC2\xA3",
		"\xA4" => "\xC2\xA4",
		"\xA6" => "\xC2\xA6",
		"\xA7" => "\xC2\xA7",
		"\xA8" => "\xC3\x98",
		"\xA9" => "\xC2\xA9",
		"\xAA" => "\xC5\x96",
		"\xAB" => "\xC2\xAB",
		"\xAC" => "\xC2\xAC",
		"\xAD" => "\xC2\xAD",
		"\xAE" => "\xC2\xAE",
		"\xAF" => "\xC3\x86",
		"\xB0" => "\xC2\xB0",
		"\xB1" => "\xC2\xB1",
		"\xB2" => "\xC2\xB2",
		"\xB3" => "\xC2\xB3",
		"\xB4" => "\xC2\xB4",
		"\xB5" => "\xC2\xB5",
		"\xB6" => "\xC2\xB6",
		"\xB7" => "\xC2\xB7",
		"\xB8" => "\xC3\xB8",
		"\xB9" => "\xC2\xB9",
		"\xBA" => "\xC5\x97",
		"\xBB" => "\xC2\xBB",
		"\xBC" => "\xC2\xBC",
		"\xBD" => "\xC2\xBD",
		"\xBE" => "\xC2\xBE",
		"\xBF" => "\xC3\xA6",
		"\xC0" => "\xC4\x84",
		"\xC1" => "\xC4\xAE",
		"\xC2" => "\xC4\x80",
		"\xC3" => "\xC4\x86",
		"\xC4" => "\xC3\x84",
		"\xC5" => "\xC3\x85",
		"\xC6" => "\xC4\x98",
		"\xC7" => "\xC4\x92",
		"\xC8" => "\xC4\x8C",
		"\xC9" => "\xC3\x89",
		"\xCA" => "\xC5\xB9",
		"\xCB" => "\xC4\x96",
		"\xCC" => "\xC4\xA2",
		"\xCD" => "\xC4\xB6",
		"\xCE" => "\xC4\xAA",
		"\xCF" => "\xC4\xBB",
		"\xD0" => "\xC5\xA0",
		"\xD1" => "\xC5\x83",
		"\xD2" => "\xC5\x85",
		"\xD3" => "\xC3\x93",
		"\xD4" => "\xC5\x8C",
		"\xD5" => "\xC3\x95",
		"\xD6" => "\xC3\x96",
		"\xD7" => "\xC3\x97",
		"\xD8" => "\xC5\xB2",
		"\xD9" => "\xC5\x81",
		"\xDA" => "\xC5\x9A",
		"\xDB" => "\xC5\xAA",
		"\xDC" => "\xC3\x9C",
		"\xDD" => "\xC5\xBB",
		"\xDE" => "\xC5\xBD",
		"\xDF" => "\xC3\x9F",
		"\xE0" => "\xC4\x85",
		"\xE1" => "\xC4\xAF",
		"\xE2" => "\xC4\x81",
		"\xE3" => "\xC4\x87",
		"\xE4" => "\xC3\xA4",
		"\xE5" => "\xC3\xA5",
		"\xE6" => "\xC4\x99",
		"\xE7" => "\xC4\x93",
		"\xE8" => "\xC4\x8D",
		"\xE9" => "\xC3\xA9",
		"\xEA" => "\xC5\xBA",
		"\xEB" => "\xC4\x97",
		"\xEC" => "\xC4\xA3",
		"\xED" => "\xC4\xB7",
		"\xEE" => "\xC4\xAB",
		"\xEF" => "\xC4\xBC",
		"\xF0" => "\xC5\xA1",
		"\xF1" => "\xC5\x84",
		"\xF2" => "\xC5\x86",
		"\xF3" => "\xC3\xB3",
		"\xF4" => "\xC5\x8D",
		"\xF5" => "\xC3\xB5",
		"\xF6" => "\xC3\xB6",
		"\xF7" => "\xC3\xB7",
		"\xF8" => "\xC5\xB3",
		"\xF9" => "\xC5\x82",
		"\xFA" => "\xC5\x9B",
		"\xFB" => "\xC5\xAB",
		"\xFC" => "\xC3\xBC",
		"\xFD" => "\xC5\xBC",
		"\xFE" => "\xC5\xBE",
		"\xFF" => "\xCB\x99",
	);
	return strtr($string, $transform);
}

function utf8_to_cp1252($string)
{
	static $transform = array(
		"\xE2\x82\xAC" => "\x80",
		"\xE2\x80\x9A" => "\x82",
		"\xC6\x92" => "\x83",
		"\xE2\x80\x9E" => "\x84",
		"\xE2\x80\xA6" => "\x85",
		"\xE2\x80\xA0" => "\x86",
		"\xE2\x80\xA1" => "\x87",
		"\xCB\x86" => "\x88",
		"\xE2\x80\xB0" => "\x89",
		"\xC5\xA0" => "\x8A",
		"\xE2\x80\xB9" => "\x8B",
		"\xC5\x92" => "\x8C",
		"\xC5\xBD" => "\x8E",
		"\xE2\x80\x98" => "\x91",
		"\xE2\x80\x99" => "\x92",
		"\xE2\x80\x9C" => "\x93",
		"\xE2\x80\x9D" => "\x94",
		"\xE2\x80\xA2" => "\x95",
		"\xE2\x80\x93" => "\x96",
		"\xE2\x80\x94" => "\x97",
		"\xCB\x9C" => "\x98",
		"\xE2\x84\xA2" => "\x99",
		"\xC5\xA1" => "\x9A",
		"\xE2\x80\xBA" => "\x9B",
		"\xC5\x93" => "\x9C",
		"\xC5\xBE" => "\x9E",
		"\xC5\xB8" => "\x9F",
		"\xC2\xA0" => "\xA0",
		"\xC2\xA1" => "\xA1",
		"\xC2\xA2" => "\xA2",
		"\xC2\xA3" => "\xA3",
		"\xC2\xA4" => "\xA4",
		"\xC2\xA5" => "\xA5",
		"\xC2\xA6" => "\xA6",
		"\xC2\xA7" => "\xA7",
		"\xC2\xA8" => "\xA8",
		"\xC2\xA9" => "\xA9",
		"\xC2\xAA" => "\xAA",
		"\xC2\xAB" => "\xAB",
		"\xC2\xAC" => "\xAC",
		"\xC2\xAD" => "\xAD",
		"\xC2\xAE" => "\xAE",
		"\xC2\xAF" => "\xAF",
		"\xC2\xB0" => "\xB0",
		"\xC2\xB1" => "\xB1",
		"\xC2\xB2" => "\xB2",
		"\xC2\xB3" => "\xB3",
		"\xC2\xB4" => "\xB4",
		"\xC2\xB5" => "\xB5",
		"\xC2\xB6" => "\xB6",
		"\xC2\xB7" => "\xB7",
		"\xC2\xB8" => "\xB8",
		"\xC2\xB9" => "\xB9",
		"\xC2\xBA" => "\xBA",
		"\xC2\xBB" => "\xBB",
		"\xC2\xBC" => "\xBC",
		"\xC2\xBD" => "\xBD",
		"\xC2\xBE" => "\xBE",
		"\xC2\xBF" => "\xBF",
		"\xC3\x80" => "\xC0",
		"\xC3\x81" => "\xC1",
		"\xC3\x82" => "\xC2",
		"\xC3\x83" => "\xC3",
		"\xC3\x84" => "\xC4",
		"\xC3\x85" => "\xC5",
		"\xC3\x86" => "\xC6",
		"\xC3\x87" => "\xC7",
		"\xC3\x88" => "\xC8",
		"\xC3\x89" => "\xC9",
		"\xC3\x8A" => "\xCA",
		"\xC3\x8B" => "\xCB",
		"\xC3\x8C" => "\xCC",
		"\xC3\x8D" => "\xCD",
		"\xC3\x8E" => "\xCE",
		"\xC3\x8F" => "\xCF",
		"\xC3\x90" => "\xD0",
		"\xC3\x91" => "\xD1",
		"\xC3\x92" => "\xD2",
		"\xC3\x93" => "\xD3",
		"\xC3\x94" => "\xD4",
		"\xC3\x95" => "\xD5",
		"\xC3\x96" => "\xD6",
		"\xC3\x97" => "\xD7",
		"\xC3\x98" => "\xD8",
		"\xC3\x99" => "\xD9",
		"\xC3\x9A" => "\xDA",
		"\xC3\x9B" => "\xDB",
		"\xC3\x9C" => "\xDC",
		"\xC3\x9D" => "\xDD",
		"\xC3\x9E" => "\xDE",
		"\xC3\x9F" => "\xDF",
		"\xC3\xA0" => "\xE0",
		"\xC3\xA1" => "\xE1",
		"\xC3\xA2" => "\xE2",
		"\xC3\xA3" => "\xE3",
		"\xC3\xA4" => "\xE4",
		"\xC3\xA5" => "\xE5",
		"\xC3\xA6" => "\xE6",
		"\xC3\xA7" => "\xE7",
		"\xC3\xA8" => "\xE8",
		"\xC3\xA9" => "\xE9",
		"\xC3\xAA" => "\xEA",
		"\xC3\xAB" => "\xEB",
		"\xC3\xAC" => "\xEC",
		"\xC3\xAD" => "\xED",
		"\xC3\xAE" => "\xEE",
		"\xC3\xAF" => "\xEF",
		"\xC3\xB0" => "\xF0",
		"\xC3\xB1" => "\xF1",
		"\xC3\xB2" => "\xF2",
		"\xC3\xB3" => "\xF3",
		"\xC3\xB4" => "\xF4",
		"\xC3\xB5" => "\xF5",
		"\xC3\xB6" => "\xF6",
		"\xC3\xB7" => "\xF7",
		"\xC3\xB8" => "\xF8",
		"\xC3\xB9" => "\xF9",
		"\xC3\xBA" => "\xFA",
		"\xC3\xBB" => "\xFB",
		"\xC3\xBC" => "\xFC",
		"\xC3\xBD" => "\xFD",
		"\xC3\xBE" => "\xFE",
		"\xC3\xBF" => "\xFF"
	);
	return strtr($string, $transform);
}

?>