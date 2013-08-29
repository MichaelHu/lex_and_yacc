<?php
class CALC_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof CALC_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof CALC_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->_string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof CALC_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof CALC_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

class CALC_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};


#line 12 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
class CalcParser#line 79 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
{
#line 14 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"

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

#line 103 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"

    const CALC_PLUS                           =  1;
    const CALC_MINUS                          =  2;
    const CALC_TIMES                          =  3;
    const CALC_DIVIDE                         =  4;
    const CALC_LPAREN                         =  5;
    const CALC_RPAREN                         =  6;
    const CALC_SEMI_COLON                     =  7;
    const CALC_NUM                            =  8;
    const YY_NO_ACTION = 30;
    const YY_ACCEPT_ACTION = 29;
    const YY_ERROR_ACTION = 28;

    const YY_SZ_ACTTAB = 28;
static public $yy_action = array(
 /*     0 */     6,    5,    2,    4,   29,    1,   14,   27,    6,    5,
 /*    10 */     2,    4,   17,   12,   10,    3,   13,    3,   15,   16,
 /*    20 */    15,    2,    4,   11,    7,   27,    8,    9,
    );
    static public $yy_lookahead = array(
 /*     0 */     1,    2,    3,    4,   10,   11,    7,   14,    1,    2,
 /*    10 */     3,    4,    0,    6,   13,    5,   13,    5,    8,   13,
 /*    20 */     8,    3,    4,   12,   13,   14,   13,   13,
);
    const YY_SHIFT_USE_DFLT = -2;
    const YY_SHIFT_MAX = 10;
    static public $yy_shift_ofst = array(
 /*     0 */    -2,   12,   10,   10,   10,   10,   10,   -1,    7,   18,
 /*    10 */    18,
);
    const YY_REDUCE_USE_DFLT = -7;
    const YY_REDUCE_MAX = 6;
    static public $yy_reduce_ofst = array(
 /*     0 */    -6,   11,    3,   13,    6,   14,    1,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(0, 5, 8, ),
        /* 2 */ array(5, 8, ),
        /* 3 */ array(5, 8, ),
        /* 4 */ array(5, 8, ),
        /* 5 */ array(5, 8, ),
        /* 6 */ array(5, 8, ),
        /* 7 */ array(1, 2, 3, 4, 7, ),
        /* 8 */ array(1, 2, 3, 4, 6, ),
        /* 9 */ array(3, 4, ),
        /* 10 */ array(3, 4, ),
        /* 11 */ array(),
        /* 12 */ array(),
        /* 13 */ array(),
        /* 14 */ array(),
        /* 15 */ array(),
        /* 16 */ array(),
);
    static public $yy_default = array(
 /*     0 */    19,   27,   27,   27,   27,   27,   27,   28,   28,   23,
 /*    10 */    22,   18,   26,   24,   20,   21,   25,
);
    const YYNOCODE = 15;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 17;
    const YYNRULE = 11;
    const YYERRORSYMBOL = 9;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    static public $yyFallback = array(
    );
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '<br>';
    }

    static public $yyTraceFILE;
    static public $yyTracePrompt;
    public $yyidx;                    /* Index of top element in stack */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    public $yystack = array();  /* The parser's stack */

    public $yyTokenName = array( 
  '$',             'PLUS',          'MINUS',         'TIMES',       
  'DIVIDE',        'LPAREN',        'RPAREN',        'SEMI_COLON',  
  'NUM',           'error',         'start',         'statement_list',
  'statement',     'expr',        
    );

    static public $yyRuleName = array(
 /*   0 */ "start ::= statement_list",
 /*   1 */ "statement_list ::= statement_list statement",
 /*   2 */ "statement_list ::=",
 /*   3 */ "statement ::= expr SEMI_COLON",
 /*   4 */ "expr ::= NUM",
 /*   5 */ "expr ::= expr PLUS expr",
 /*   6 */ "expr ::= expr MINUS expr",
 /*   7 */ "expr ::= expr TIMES expr",
 /*   8 */ "expr ::= expr DIVIDE expr",
 /*   9 */ "expr ::= LPAREN expr RPAREN",
 /*  10 */ "expr ::=",
    );

    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count($this->yyTokenName)) {
            return $this->yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . $this->yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    function __destruct()
    {
        while ($this->yystack !== Array()) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
		        $expected = array_merge($expected, self::$yyExpectedTokens[$nextstate]);
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new CALC_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
	$this->yyidx = $yyidx;
	$this->yystack = $stack;
        return array_unique($expected);
    }

    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new CALC_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

   function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        $this->yyTokenName[$iLookAhead] . " => " .
                        $this->yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
#line 59 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"

	echo "overflow\n";
    $this->internalError = true;
    // $this->compiler->trigger_config_file_error("Stack overflow in configfile parser");
#line 476 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
            return;
        }
        $yytos = new CALC_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    $this->yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    static public $yyRuleInfo = array(
  array( 'lhs' => 10, 'rhs' => 1 ),
  array( 'lhs' => 11, 'rhs' => 2 ),
  array( 'lhs' => 11, 'rhs' => 0 ),
  array( 'lhs' => 12, 'rhs' => 2 ),
  array( 'lhs' => 13, 'rhs' => 1 ),
  array( 'lhs' => 13, 'rhs' => 3 ),
  array( 'lhs' => 13, 'rhs' => 3 ),
  array( 'lhs' => 13, 'rhs' => 3 ),
  array( 'lhs' => 13, 'rhs' => 3 ),
  array( 'lhs' => 13, 'rhs' => 3 ),
  array( 'lhs' => 13, 'rhs' => 0 ),
    );

    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
    );
#line 70 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r0(){
	echo "yes\n";
    }
#line 526 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 74 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r1(){
	echo "ok\n";
    }
#line 531 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 78 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r2(){
	echo "empty\n";
    }
#line 536 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 82 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r3(){
	echo "result: " . (float)$this->yystack[$this->yyidx + -1]->minor . "\n";
    }
#line 541 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 86 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r4(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 546 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 90 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r5(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor + (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 551 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 94 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r6(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor - (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 556 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 98 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r7(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor * (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 561 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 102 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r8(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor / (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 566 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
#line 106 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"
    function yy_r9(){
	$this->_retvalue = (float)($this->yystack[$this->yyidx + -1]->minor);
    }
#line 571 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"

    private $_retvalue;

    function yy_reduce($yyruleno)
    {
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new CALC_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
    }

    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 49 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"

	echo "error[yymajor: $yymajor, tokenvalue: " . $this->lex->value . "]" 
		. "stateno: " . $this->yystack[$this->yyidx]->stateno
		. "\n";
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // $this->compiler->trigger_config_file_error();
#line 637 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
    }

    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
#line 40 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.y"

	echo "accept\n";
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
#line 656 "D:\SVN_TEMP\my_fis\lexer\src\calc\CalcParser.php"
    }

    function doParse($yymajor, $yytokenvalue)
    {
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        if ($this->yyidx === null || $this->yyidx < 0) {
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new CALC_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sInput %s\n",
                self::$yyTracePrompt, $this->yyTokenName[$yymajor]);
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL &&
                  !$this->yy_is_expected_token($yymajor)) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(self::$yyTraceFILE, "%sSyntax Error!\n",
                        self::$yyTracePrompt);
                }
                if (self::YYERRORSYMBOL) {
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ){
                        if (self::$yyTraceFILE) {
                            fprintf(self::$yyTraceFILE, "%sDiscard input token %s\n",
                                self::$yyTracePrompt, $this->yyTokenName[$yymajor]);
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0 &&
                                 $yymx != self::YYERRORSYMBOL &&
        ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                              ){
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}
