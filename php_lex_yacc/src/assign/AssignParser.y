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
%name ASSIGN_
%declare_class {class AssignParser}
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
} 


%token_prefix ASSIGN_

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

%left EQ.
%left PLUS.

prog ::= stat_list. {
	echo "yes\n";
}

stat_list ::= stat stat_list. {
	echo "ok\n";
}

stat_list ::= . {
	echo "empty\n";
}

stat ::= ID(B) EQ expr(C). {
	$name = $this->getID(B);
	echo "name:[$name]\n";
	$this->setVar($name, C);
}

stat ::= SEMI_COLON. {
	echo "semi_colon\n";
}

expr(A) ::= expr(B) PLUS expr(C). {
	A = (float)B + (float)C;
}

expr(A) ::= NUM(B). {
	A = (float)B;
}

expr(A) ::= ID(B). {
	$name = $this->getID(B);
	echo "name:[$name]\n";
	A = $this->getVar($name);
}

