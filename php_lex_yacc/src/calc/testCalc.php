<?php

require "CalcLexer.php";
require "CalcParser.php";

$lexer = new CalcLexer(file_get_contents('CalcTest.txt'));
// $lexer = new CalcLexer("1+34");
$parser = new CalcParser($lexer);
while($lexer->yylex()){
	// echo "[token: $lexer->token, value: $lexer->value]\n";
	$parser->doParse($lexer->token, $lexer->value);
}
$parser->doParse(0, '');

var_export($parser->retvalue);
