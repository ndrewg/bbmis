<?php
	$br = '<br>';
	$strSingle = 'hello';
	$strDouble = 'hello world';
	$strUpper = 'HELLO WORLD';
	$strSpace = '        HELLO WORLD';
	$pos = strpos($strDouble, 'w');
	
	echo $strSingle;
	echo $br;
	echo $strDouble;
	echo $br;
	echo ucfirst($strSingle);
	echo $br;
	echo ucfirst($strDouble);
	echo $br;
	echo ucwords($strDouble);
	echo $br;
	echo ucwords(strtolower($strUpper));
	echo $br;
	echo $strSpace;
	echo $br;
	echo ltrim(rtrim($strSpace));
	echo $br;
	echo strpos($strDouble, ' ');
	echo $br;
	echo substr($strDouble, $pos+1, 1);
	echo 1;
?>