<?php

require "AssignLexer.php";
require "AssignParser.php";

$lexer = new AssignLexer(file_get_contents('AssignTest.txt'));
// $lexer = new AssignLexer('$ab =  1 + 34; $cd = $ab; $_acd = $ab + $cd;');
$context = array();
$parser = new AssignParser($lexer, $context);
while($lexer->yylex()){
	// echo "[token: $lexer->token, value: $lexer->value]\n";
	$parser->doParse($lexer->token, $lexer->value);
}
$parser->doParse(0, '');

// var_export($parser->retvalue);
var_export($context);
