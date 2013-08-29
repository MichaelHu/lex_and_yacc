<?php
/**
* Smarty Internal Plugin Configfilelexer
*
* This is the lexer to break the config file source into tokens 
* @package Smarty
* @subpackage Config
* @author Uwe Tews 
*/
/**
* Smarty Internal Plugin Configfilelexer
*/
class SwitchAssignLexer
{

    public $data;
    public $counter;
    public $token;
    public $value;
    public $node;
    public $line;
    private $state = 1;
    private $mbstring_overload = false;
    public $smarty_token_names = array (		// Text for parser error messages
   				);
    				
    				
    function __construct($data, $smarty = null)
    {
        // set instance object
        self::instance($this); 
        $this->data = $data . "\n"; //now all lines are \n-terminated
        $this->counter = 0;
        $this->line = 1;
        $this->smarty = $smarty; 
     }
    public static function &instance($new_instance = null)
    {
        static $instance = null;
        if (isset($new_instance) && is_object($new_instance))
            $instance = $new_instance;
        return $instance;
    } 



    private $_yy_state = 1;
    private $_yy_stack = array();

    function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    function yypushstate($state)
    {
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
    }

    function yypopstate()
    {
        $this->_yy_state = array_pop($this->_yy_stack);
    }

    function yybegin($state)
    {
        $this->_yy_state = $state;
    }




    function yylex1()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
              12 => 0,
              13 => 0,
              14 => 0,
              15 => 0,
              16 => 0,
              17 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(\\+)|\G(\\$[a-zA-Z_]+)|\G(\\d+(?:\\.\\d+)?)|\G(>)|\G(<)|\G(\\()|\G(\\{)|\G(\\})|\G(\\))|\G(if)|\G(else)|\G(==)|\G(=)|\G(;)|\G(\n)|\G([\t\r ])|\G(@_@.+?@_@)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state START');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->counter += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->counter += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->counter >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                }            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->counter]);
            }
            break;
        } while (true);

    } // end function


    const START = 1;
    function yy_r1_1($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_PLUS;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_2($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_ID;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_3($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_NUM;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_4($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_GT;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_5($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_LT;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_6($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_LPAREN;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_7($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_LBRACE;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_8($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_RBRACE;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_9($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_RPAREN;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_10($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_IF;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_11($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_ELSE;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_12($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_EQ;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_13($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_ASSIGN;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_14($yy_subpatterns)
    {

	echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_SEMI_COLON;
    // $this->yypushstate(self::VALUE);
    }
    function yy_r1_15($yy_subpatterns)
    {

	// echo "value: [$this->value]\n";
	// $this->token = CalcParser::CALC_NEWLINE;
    // $this->yypushstate(self::VALUE);
	return false;
    }
    function yy_r1_16($yy_subpatterns)
    {

	// echo "value: [$this->value]\n";
    return false;
    }
    function yy_r1_17($yy_subpatterns)
    {

	// echo "value: [$this->value]\n";
	$this->token = SwitchAssignParser::SWITCHASSIGN_OTHER;
    // return false;
    }

}


?>

