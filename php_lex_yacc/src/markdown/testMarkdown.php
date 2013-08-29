<?php

require "MarkdownLexer.php";
require "MarkdownParser.php";

$test_file_path = 'MarkdownTest.txt';
// echo dirname(realpath($test_file_path)) . "\n";

$content = file_get_contents($test_file_path);
$lexer = new MarkdownLexer($content);

// $lexer = new MarkdownLexer('$ab =  1 + 34; $cd = $ab; $_acd = $ab + $cd;');
$context = array(
    'file_path' => realpath($test_file_path)        
);

$parser = new MarkdownParser($lexer, $context);
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
var_export(simplify($context));

function simplify($context){
    $doc = array();
    $cur_type = null;
    $conf_mergable_types = array(
        'docinfo'
        ,'ul'
        ,'ol'
        ,'code'
    );
    $conf_skipwhenempty_types = array(
        'docinfo'
        ,'ul'
        ,'ol'
        ,'paragraph'
        ,'headline'
    );

    foreach($context as $key => $value){
        $type = $value['type'];
        $arr_len = count($doc);

        // 略过空内容块
        if(in_array($type, $conf_skipwhenempty_types) 
            && empty($value['content'])){
            continue;
        }

        if(in_array($type, $conf_mergable_types)){
            if($type == $cur_type){
                array_push($doc[$arr_len - 1]['content'], $value['content']); 
            }
            else{
                $cur_type = $type;
                $tmp = array(
                    'type' => $type
                    ,'content' => array($value['content'])
                );
                array_push($doc, $tmp);
            }
        }
        else{
            $cur_type = $type;
            array_push($doc, $value);
        }
    }

    return $doc;

}

