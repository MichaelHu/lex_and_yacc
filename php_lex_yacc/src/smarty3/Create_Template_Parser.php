<?php

define('DS', DIRECTORY_SEPARATOR);
define('DOMAIN_LANG_NAME', 'smarty_internal_template');
define('CUR_DIR', dirname(__FILE__));
define('LEXER_LIB', CUR_DIR . normalize_path('/../../lib'));

function normalize_path($path){
	return str_replace(array('/', '\\'), DS, $path);
}

// require_once(dirname(__FILE__)."/../../dev_settings.php");


// Create Parser
$cmd_parser = 'cd ' . LEXER_LIB . ' && ' 
	. 'php ./ParserGenerator/cli.php '
 	. CUR_DIR . DS . DOMAIN_LANG_NAME . 'Parser.y';
passthru($cmd_parser);


// Create Lexer
set_include_path(LEXER_LIB . PATH_SEPARATOR . get_include_path());
require_once 'LexerGenerator.php';
$lex = new PHP_LexerGenerator(DOMAIN_LANG_NAME . 'Lexer.plex');
$contents = file_get_contents(DOMAIN_LANG_NAME . 'Lexer.php');
file_put_contents(DOMAIN_LANG_NAME . 'Lexer.php', $contents . "\n");

?>
