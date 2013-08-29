<?php
class SWITCHASSIGN_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof SWITCHASSIGN_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof SWITCHASSIGN_yyToken) {
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
                $x = ($value instanceof SWITCHASSIGN_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof SWITCHASSIGN_yyToken) {
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

class SWITCHASSIGN_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};


#line 12 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
class SwitchAssignParser#line 79 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
{
#line 14 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"

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
#line 116 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"

    const SWITCHASSIGN_ASSIGN                         =  1;
    const SWITCHASSIGN_EQ                             =  2;
    const SWITCHASSIGN_GT                             =  3;
    const SWITCHASSIGN_LT                             =  4;
    const SWITCHASSIGN_PLUS                           =  5;
    const SWITCHASSIGN_LPAREN                         =  6;
    const SWITCHASSIGN_RPAREN                         =  7;
    const SWITCHASSIGN_IF                             =  8;
    const SWITCHASSIGN_LBRACE                         =  9;
    const SWITCHASSIGN_RBRACE                         = 10;
    const SWITCHASSIGN_ELSE                           = 11;
    const SWITCHASSIGN_OTHER                          = 12;
    const SWITCHASSIGN_ID                             = 13;
    const SWITCHASSIGN_SEMI_COLON                     = 14;
    const SWITCHASSIGN_NUM                            = 15;
    const YY_NO_ACTION = 52;
    const YY_ACCEPT_ACTION = 51;
    const YY_ERROR_ACTION = 50;

    const YY_SZ_ACTTAB = 51;
static public $yy_action = array(
 /*     0 */    11,   10,   12,    9,   19,   21,   14,   20,    5,   24,
 /*    10 */    17,    6,   32,   31,    6,   11,   10,   12,    9,   51,
 /*    20 */    30,    6,   16,   25,   19,   26,   18,    6,    5,   24,
 /*    30 */    28,    6,   29,    6,    1,   27,    6,    7,   13,    9,
 /*    40 */     3,    4,    2,   22,   15,   40,   34,   40,   33,    8,
 /*    50 */    23,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,    4,    5,    8,   20,   21,   11,   12,   13,
 /*    10 */    18,   19,   14,   18,   19,    2,    3,    4,    5,   17,
 /*    20 */    18,   19,    7,   13,    8,   15,   18,   19,   12,   13,
 /*    30 */    18,   19,   18,   19,   10,   18,   19,    6,    1,    5,
 /*    40 */    10,    9,    9,   21,   21,   23,   21,   23,   22,   21,
 /*    50 */    21,
);
    const YY_SHIFT_USE_DFLT = -5;
    const YY_SHIFT_MAX = 24;
    static public $yy_shift_ofst = array(
 /*     0 */    16,   -4,   16,   16,   16,   16,   16,   10,   -2,   10,
 /*    10 */    10,   10,   10,   10,   13,   34,   32,   30,   24,   31,
 /*    20 */    33,   15,   34,   34,   37,
);
    const YY_REDUCE_USE_DFLT = -16;
    const YY_REDUCE_MAX = 13;
    static public $yy_reduce_ofst = array(
 /*     0 */     2,   17,   -8,   12,    8,   -5,   14,  -15,   26,   25,
 /*    10 */    23,   29,   22,   28,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(8, 12, 13, ),
        /* 1 */ array(8, 11, 12, 13, ),
        /* 2 */ array(8, 12, 13, ),
        /* 3 */ array(8, 12, 13, ),
        /* 4 */ array(8, 12, 13, ),
        /* 5 */ array(8, 12, 13, ),
        /* 6 */ array(8, 12, 13, ),
        /* 7 */ array(13, 15, ),
        /* 8 */ array(2, 3, 4, 5, 14, ),
        /* 9 */ array(13, 15, ),
        /* 10 */ array(13, 15, ),
        /* 11 */ array(13, 15, ),
        /* 12 */ array(13, 15, ),
        /* 13 */ array(13, 15, ),
        /* 14 */ array(2, 3, 4, 5, ),
        /* 15 */ array(5, ),
        /* 16 */ array(9, ),
        /* 17 */ array(10, ),
        /* 18 */ array(10, ),
        /* 19 */ array(6, ),
        /* 20 */ array(9, ),
        /* 21 */ array(7, ),
        /* 22 */ array(5, ),
        /* 23 */ array(5, ),
        /* 24 */ array(1, ),
        /* 25 */ array(),
        /* 26 */ array(),
        /* 27 */ array(),
        /* 28 */ array(),
        /* 29 */ array(),
        /* 30 */ array(),
        /* 31 */ array(),
        /* 32 */ array(),
        /* 33 */ array(),
        /* 34 */ array(),
);
    static public $yy_default = array(
 /*     0 */    40,   40,   40,   40,   40,   40,   40,   50,   50,   50,
 /*    10 */    50,   50,   50,   50,   43,   46,   50,   50,   50,   50,
 /*    20 */    50,   50,   45,   47,   50,   49,   48,   37,   38,   36,
 /*    30 */    35,   39,   42,   41,   44,
);
    const YYNOCODE = 24;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 35;
    const YYNRULE = 15;
    const YYERRORSYMBOL = 16;
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
  '$',             'ASSIGN',        'EQ',            'GT',          
  'LT',            'PLUS',          'LPAREN',        'RPAREN',      
  'IF',            'LBRACE',        'RBRACE',        'ELSE',        
  'OTHER',         'ID',            'SEMI_COLON',    'NUM',         
  'error',         'prog',          'stat_list',     'stat',        
  'bool_expr',     'expr',          'stat_end',    
    );

    static public $yyRuleName = array(
 /*   0 */ "prog ::= stat_list",
 /*   1 */ "stat_list ::= stat stat_list",
 /*   2 */ "stat_list ::= IF LPAREN bool_expr RPAREN LBRACE stat_list RBRACE stat_list",
 /*   3 */ "stat_list ::= IF LPAREN bool_expr RPAREN LBRACE stat_list RBRACE ELSE LBRACE stat_list RBRACE stat_list",
 /*   4 */ "stat_list ::= OTHER stat_list",
 /*   5 */ "stat_list ::=",
 /*   6 */ "stat ::= ID ASSIGN expr stat_end",
 /*   7 */ "stat_end ::= SEMI_COLON",
 /*   8 */ "bool_expr ::= expr",
 /*   9 */ "expr ::= expr PLUS expr",
 /*  10 */ "expr ::= expr LT expr",
 /*  11 */ "expr ::= expr GT expr",
 /*  12 */ "expr ::= expr EQ expr",
 /*  13 */ "expr ::= NUM",
 /*  14 */ "expr ::= ID",
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
                        $x = new SWITCHASSIGN_yyStackEntry;
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
                        $x = new SWITCHASSIGN_yyStackEntry;
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
#line 72 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"

	echo "overflow\n";
    $this->internalError = true;
    // $this->compiler->trigger_config_file_error("Stack overflow in configfile parser");
#line 530 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
            return;
        }
        $yytos = new SWITCHASSIGN_yyStackEntry;
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
  array( 'lhs' => 17, 'rhs' => 1 ),
  array( 'lhs' => 18, 'rhs' => 2 ),
  array( 'lhs' => 18, 'rhs' => 8 ),
  array( 'lhs' => 18, 'rhs' => 12 ),
  array( 'lhs' => 18, 'rhs' => 2 ),
  array( 'lhs' => 18, 'rhs' => 0 ),
  array( 'lhs' => 19, 'rhs' => 4 ),
  array( 'lhs' => 22, 'rhs' => 1 ),
  array( 'lhs' => 20, 'rhs' => 1 ),
  array( 'lhs' => 21, 'rhs' => 3 ),
  array( 'lhs' => 21, 'rhs' => 3 ),
  array( 'lhs' => 21, 'rhs' => 3 ),
  array( 'lhs' => 21, 'rhs' => 3 ),
  array( 'lhs' => 21, 'rhs' => 1 ),
  array( 'lhs' => 21, 'rhs' => 1 ),
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
        10 => 10,
        11 => 11,
        12 => 12,
        13 => 13,
        14 => 14,
    );
#line 83 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r0(){
	// echo "yes\n";
	$this->_retvalue = '<?php $context = array(); ' . $this->yystack[$this->yyidx + 0]->minor . ' ?>';
	echo $this->_retvalue;
	file_put_contents('__c.php', $this->_retvalue);
    }
#line 592 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 90 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r1(){
	// echo "ok\n";
	$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 598 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 95 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r2(){
	$this->_retvalue = 'if(' . $this->yystack[$this->yyidx + -5]->minor . '){' . $this->yystack[$this->yyidx + -2]->minor . '}' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 603 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 99 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r3(){
	$this->_retvalue = 'if(' . $this->yystack[$this->yyidx + -9]->minor . '){' . $this->yystack[$this->yyidx + -6]->minor . '}else{' . $this->yystack[$this->yyidx + -2]->minor . '}' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 608 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 103 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r4(){
	$this->_retvalue = 'echo "' . $this->yystack[$this->yyidx + -1]->minor . '\n";' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 613 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 107 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r5(){
	$this->_retvalue = '';
	// echo "empty\n";
    }
#line 619 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 112 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r6(){
	$name = $this->getID($this->yystack[$this->yyidx + -3]->minor);
	// echo "name:[$name]\n";
	// $this->setVar($name, $this->yystack[$this->yyidx + -1]->minor);
	$this->_retvalue = '$context["' . $name . '"] = ' . $this->yystack[$this->yyidx + -1]->minor
		. '; echo $context["' . $name . '"] . "\n"' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 628 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 120 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r7(){
	// echo "semi_colon\n";
	$this->_retvalue = ';';
    }
#line 634 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 125 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r8(){
	$this->_retvalue = '(bool)(' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 639 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 129 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r9(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor + (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') + (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 645 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 134 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r10(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor < (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') < (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 651 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 139 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r11(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor > (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') > (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 657 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 144 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r12(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor == (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') == (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 663 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 149 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r13(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 668 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
#line 153 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"
    function yy_r14(){
	$name = $this->getID($this->yystack[$this->yyidx + 0]->minor);
	// echo "name:[$name]\n";
	// $this->_retvalue = $this->getVar($name);
	$this->_retvalue = '$context["' . $name .'"]';
    }
#line 676 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"

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
                $x = new SWITCHASSIGN_yyStackEntry;
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
#line 62 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"

	echo "error[yymajor: $yymajor, tokenvalue: " . $this->lex->value . "]" 
		. "stateno: " . $this->yystack[$this->yyidx]->stateno
		. "\n";
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // $this->compiler->trigger_config_file_error();
#line 742 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
    }

    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
#line 53 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.y"

	echo "accept\n";
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
#line 761 "D:\SVN_TEMP\my_fis\lexer\src\switchassign\SwitchAssignParser.php"
    }

    function doParse($yymajor, $yytokenvalue)
    {
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        if ($this->yyidx === null || $this->yyidx < 0) {
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new SWITCHASSIGN_yyStackEntry;
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
