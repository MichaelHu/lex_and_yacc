<?php

require "FisCssLexer.php";
require "FisCssParser.php";

$lexer = new FisCssLexer(file_get_contents('FisCssTest.txt'));
// $lexer = new FisCssLexer('$a:1;');
$context = array();
$parser = new FisCssParser($lexer, $context);
while($lexer->yylex()){
	// echo "[token: $lexer->token, value: $lexer->value]\n";
	$parser->doParse($lexer->token, $lexer->value);
}
$parser->doParse(0, '');

// var_export($parser->retvalue);
var_export($context);

echo "\n===============\nexecute: \n";
passthru('php -f __c.php');
