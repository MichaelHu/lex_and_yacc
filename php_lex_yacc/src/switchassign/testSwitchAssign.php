<?php

require "SwitchAssignLexer.php";
require "SwitchAssignParser.php";

$lexer = new SwitchAssignLexer(file_get_contents('SwitchAssignTest.txt'));
// $lexer = new SwitchAssignLexer('$ab =  1 + 34; $cd = $ab; $_acd = $ab + $cd;');
$context = array();
$parser = new SwitchAssignParser($lexer, $context);
while($lexer->yylex()){
	// echo "[token: $lexer->token, value: $lexer->value]\n";
	$parser->doParse($lexer->token, $lexer->value);
}
$parser->doParse(0, '');

// var_export($parser->retvalue);
var_export($context);
