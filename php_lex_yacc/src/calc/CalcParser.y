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
%name CALC_
%declare_class {class CalcParser}
%include_class
{
    // states whether the parse was successful or not
    public $successful = true;
    public $retvalue = 0;
    private $lex;
    private $internalError = false;

    function __construct($lex, $compiler=null) {
        // set instance object
        self::instance($this); 
        $this->lex = $lex;
    }
    public static function &instance($new_instance = null)
    {
        static $instance = null;
        if (isset($new_instance) && is_object($new_instance))
            $instance = $new_instance;
        return $instance;
    }

} 


%token_prefix CALC_

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
		. "\n";
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

%left PLUS MINUS.
%left TIMES DIVIDE.
%nonassoc LPAREN RPAREN.
%left SEMI_COLON.

start ::= statement_list. {
	echo "yes\n";
}

statement_list ::= statement_list statement. {
	echo "ok\n";
}

statement_list ::= . {
	echo "empty\n";
}

statement ::= expr(B) SEMI_COLON. {
	echo "result: " . (float)B . "\n";
}

expr(A) ::= NUM(B). {
	A = (float)B;
}

expr(A) ::= expr(B) PLUS expr(C). {
	A = (float)B + (float)C;
}

expr(A) ::= expr(B) MINUS expr(C). {
	A = (float)B - (float)C;
}

expr(A) ::= expr(B) TIMES expr(C). {
	A = (float)B * (float)C;
}

expr(A) ::= expr(B) DIVIDE expr(C). {
	A = (float)B / (float)C;
}

expr(A) ::= LPAREN expr(B) RPAREN. {
	A = (float)(B);
}

expr ::= .

