/**
* Smarty Internal Plugin Configfileparser
*
* This is the config file parser
* 
* 
* @package Smarty
* @subpackage Config
* @author Uwe Tews
*/
%name FISCSS_
%declare_class {class FisCssParser}
%include_class
{
    // states whether the parse was successful or not
    public $successful = true;
    public $retvalue = 0;
    private $lex;
    private $internalError = false;
	private $context;

    function __construct($lex, &$context) {
        // set instance object
        self::instance($this); 
        $this->lex = $lex;
		$this->context = &$context;
    }
    public static function &instance($new_instance = null)
    {
        static $instance = null;
        if (isset($new_instance) && is_object($new_instance))
            $instance = $new_instance;
        return $instance;
    }

	private function setVar($key, $value){
		$this->context[$key] = $value;
	}

	private function getVar($key){
		return $this->context[$key];
	}

	private function getID($id){
		return substr($id, 1);
	}

	private function escapeText($str){
		$str = preg_replace('/\\\\/', '\\\\\\\\', $str);
		$str = preg_replace('/"/', '\\\\"', $str);
		$str = preg_replace('/\n/', '\\\\n', $str);
		$str = preg_replace('/\t/', '\\\\t', $str);
		$str = preg_replace('/\r/', '\\\\r', $str);
		return $str;
	}
} 


%token_prefix FISCSS_

%parse_accept
{
	echo "accept\n";
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
}

%syntax_error
{
	echo "error[yymajor: $yymajor, tokenvalue: " . $this->lex->value . "]" 
		. "stateno: " . $this->yystack[$this->yyidx]->stateno
		. " lineno: " . $this->lex->line
		. "\n";
	var_export($this->yy_get_expected_tokens($yymajor));
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // $this->compiler->trigger_config_file_error();
}

%stack_overflow
{
	echo "overflow\n";
    $this->internalError = true;
    // $this->compiler->trigger_config_file_error("Stack overflow in configfile parser");
}

%left ASSIGN.
%left EQ GT LT.
%left PLUS.
%nonassoc LPAREN RPAREN.

prog(res) ::= stat_list(B). {
	res = '<?php $context = array(); ' . B . ' ?>';
	echo res;
	file_put_contents('__c.php', res);
}

stat_list(res) ::= stat(A) stat_list(B). {
	// echo "ok\n";
	res = A . B;
}

stat_list(res) ::= IF LPAREN bool_expr(B) RPAREN LBRACE stat_list(C) RBRACE stat_list(D). {
	res = 'if(' . B . '){' . C . '}' . D;
}

stat_list(res) ::= IF LPAREN bool_expr(B) RPAREN LBRACE stat_list(C) RBRACE ELSE LBRACE stat_list(D) RBRACE stat_list(E). {
	res = 'if(' . B . '){' . C . '}else{' . D . '}' . E;
}

stat_list(res) ::= mixin_declare(A) stat_list(B). {
	res = A . B;
	echo A . "\n";
}

stat_list(res) ::= OTHER(A) stat_list(B). {
	res = 'echo "' . A . '\n";' . B;
}

stat_list(res) ::= . {
	res = '';
	// echo "empty\n";
}

stat(res) ::= ID(B) COLON expr(C) stat_end(D). {
	$name = $this->getID(B);
	// echo "name:[$name]\n";
	// $this->setVar($name, C);
	res = '$context["' . $name . '"] = ' . C
		. '; echo $context["' . $name . '"] . "\n"' . D;
}

stat(res) ::= INCLUDE LPAREN expr(B) RPAREN stat_end. {
	res = '';
	echo "include file " . B . "\n";
	if(file_exists(B)){
		res = file_get_contents(B);
		res = $this->escapeText(res);
		res = 'echo "' . res . '";';
	}
}

stat(res) ::= expr(A) stat_end. {
	res = 'echo ' . A . ';';
}

stat(res) ::= mixin_execute(A) stat_end. {
	res = 'echo ' . A . ';';
}

stat(res) ::= stat_end. {
	res = '';
	echo "empty statment \n";
}

stat_end(res) ::= SEMI_COLON. {
	// echo "semi_colon\n";
	res = ';';
}

bool_expr(A) ::= expr(B). {
	A = '(bool)(' . B . ')';
}

mixin_declare(res) ::= MIXIN_NAME(A) LBRACE MIXIN_CONTENT(B) RBRACE. {
	res = '$context["mixin"]["' . A . '"] = "' . $this->escapeText(B) . '";';
	echo "declare: " . A . '{' . B . '}\n';
}

mixin_execute(res) ::= MIXIN_NAME(A) LPAREN RPAREN. {
	res = '$context["mixin"]["' . A . '"];';
}

expr(A) ::= expr(B) PLUS expr(C). {
	// A = (float)B + (float)C;
	A = '(' . B . ') + (' . C . ')';
}

expr(A) ::= expr(B) LT expr(C). {
	// A = (float)B < (float)C;
	A = '(' . B . ') < (' . C . ')';
}

expr(A) ::= expr(B) GT expr(C). {
	// A = (float)B > (float)C;
	A = '(' . B . ') > (' . C . ')';
}

expr(A) ::= expr(B) EQ expr(C). {
	// A = (float)B == (float)C;
	A = '(' . B . ') == (' . C . ')';
}

expr(A) ::= DQUOTE_STRING(B). {
	A = substr(B, 1, strlen(B)-2);
	A = $this->escapeText(A);
	A = '"' . A . '"';
	echo "quoted string: " . B . "\n";
}

expr(A) ::= NUM(B). {
	A = (float)B;
}

expr(A) ::= ID(B). {
	$name = $this->getID(B);
	// echo "name:[$name]\n";
	// A = $this->getVar($name);
	A = '$context["' . $name .'"]';
}

