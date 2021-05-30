<?php

require "TestLexer.php";
require "TestParser.php";

$test_file_path = 'testFile.txt';
// echo dirname(realpath($test_file_path)) . "\n";

$content = file_get_contents($test_file_path);
$lexer = new TestLexer($content);

$lexer = new TestLexer('aaaaaaa');
/*
$context = array(
    'file_path' => realpath($test_file_path)        
);
*/

$parser = new TestParser($lexer, $context);
// $parser->disableDebug();
// $parser->disableErrorReport();
while($lexer->yylex()){
	// echo "\n[token: $lexer->token, value: $lexer->value]\n";
	$parser->doParse($lexer->token, $lexer->value);
}
$parser->doParse(0, '');

// var_export($parser->retvalue);
// var_export($context);
// echo json_encode($context);
// var_export($context);



