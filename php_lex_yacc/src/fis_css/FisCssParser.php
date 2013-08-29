<?php
class FISCSS_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof FISCSS_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof FISCSS_yyToken) {
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
                $x = ($value instanceof FISCSS_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof FISCSS_yyToken) {
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

class FISCSS_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};


#line 12 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
class FisCssParser#line 79 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
{
#line 14 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"

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
#line 125 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"

    const FISCSS_ASSIGN                         =  1;
    const FISCSS_EQ                             =  2;
    const FISCSS_GT                             =  3;
    const FISCSS_LT                             =  4;
    const FISCSS_PLUS                           =  5;
    const FISCSS_LPAREN                         =  6;
    const FISCSS_RPAREN                         =  7;
    const FISCSS_IF                             =  8;
    const FISCSS_LBRACE                         =  9;
    const FISCSS_RBRACE                         = 10;
    const FISCSS_ELSE                           = 11;
    const FISCSS_OTHER                          = 12;
    const FISCSS_ID                             = 13;
    const FISCSS_COLON                          = 14;
    const FISCSS_INCLUDE                        = 15;
    const FISCSS_SEMI_COLON                     = 16;
    const FISCSS_MIXIN_NAME                     = 17;
    const FISCSS_MIXIN_CONTENT                  = 18;
    const FISCSS_DQUOTE_STRING                  = 19;
    const FISCSS_NUM                            = 20;
    const YY_NO_ACTION = 79;
    const YY_ACCEPT_ACTION = 78;
    const YY_ERROR_ACTION = 77;

    const YY_SZ_ACTTAB = 113;
static public $yy_action = array(
 /*     0 */    30,    1,   37,   32,    4,   33,   36,   23,   48,   21,
 /*    10 */    39,   51,   50,   30,   11,    8,   35,    4,   33,   34,
 /*    20 */    23,   48,   21,   15,   51,   50,   78,   52,    7,   13,
 /*    30 */     3,    9,   40,   18,   26,   46,    7,    6,    3,    9,
 /*    40 */    40,   18,   31,    7,    2,    3,    9,   40,   18,   43,
 /*    50 */     7,   28,    3,    9,   40,   18,   45,    7,    5,    3,
 /*    60 */     9,   40,   18,   27,    7,   25,    3,    9,   40,   18,
 /*    70 */    44,    7,   48,    3,    9,   40,   18,   42,    7,   53,
 /*    80 */     3,    9,   40,   18,   14,   12,   16,   15,   14,   12,
 /*    90 */    16,   15,   41,   17,   14,   12,   16,   15,   48,   29,
 /*   100 */    49,   20,   10,   55,   47,   19,   51,   50,   22,   55,
 /*   110 */    24,   55,   38,
    );
    static public $yy_lookahead = array(
 /*     0 */     8,   10,   28,   11,   12,   13,   10,   15,   16,   17,
 /*    10 */     7,   19,   20,    8,    6,    6,    6,   12,   13,    9,
 /*    20 */    15,   16,   17,    5,   19,   20,   22,   23,   24,   14,
 /*    30 */    26,   27,   28,   29,   18,   23,   24,    9,   26,   27,
 /*    40 */    28,   29,   23,   24,   10,   26,   27,   28,   29,   23,
 /*    50 */    24,    7,   26,   27,   28,   29,   23,   24,    9,   26,
 /*    60 */    27,   28,   29,   23,   24,   27,   26,   27,   28,   29,
 /*    70 */    23,   24,   16,   26,   27,   28,   29,   23,   24,   28,
 /*    80 */    26,   27,   28,   29,    2,    3,    4,    5,    2,    3,
 /*    90 */     4,    5,   27,    7,    2,    3,    4,    5,   16,   25,
 /*   100 */    13,   27,   27,   30,   28,   27,   19,   20,   27,   30,
 /*   110 */    27,   30,   28,
);
    const YY_SHIFT_USE_DFLT = -10;
    const YY_SHIFT_MAX = 35;
    static public $yy_shift_ofst = array(
 /*     0 */     5,   -8,    5,    5,    5,    5,    5,    5,   87,   82,
 /*    10 */    82,   87,   87,   87,   87,   87,   87,   56,   56,   86,
 /*    20 */    92,   10,   18,    8,   18,   18,   -4,   -9,   49,   44,
 /*    30 */     9,   34,   28,   15,   16,    3,
);
    const YY_REDUCE_USE_DFLT = -27;
    const YY_REDUCE_MAX = 18;
    static public $yy_reduce_ofst = array(
 /*     0 */     4,   33,   47,   54,   26,   40,   19,   12,   74,  -26,
 /*    10 */    76,   78,   81,   75,   83,   65,   38,   51,   84,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 1 */ array(8, 11, 12, 13, 15, 16, 17, 19, 20, ),
        /* 2 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 3 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 4 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 5 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 6 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 7 */ array(8, 12, 13, 15, 16, 17, 19, 20, ),
        /* 8 */ array(13, 19, 20, ),
        /* 9 */ array(2, 3, 4, 5, 16, ),
        /* 10 */ array(2, 3, 4, 5, 16, ),
        /* 11 */ array(13, 19, 20, ),
        /* 12 */ array(13, 19, 20, ),
        /* 13 */ array(13, 19, 20, ),
        /* 14 */ array(13, 19, 20, ),
        /* 15 */ array(13, 19, 20, ),
        /* 16 */ array(13, 19, 20, ),
        /* 17 */ array(16, ),
        /* 18 */ array(16, ),
        /* 19 */ array(2, 3, 4, 5, 7, ),
        /* 20 */ array(2, 3, 4, 5, ),
        /* 21 */ array(6, 9, ),
        /* 22 */ array(5, ),
        /* 23 */ array(6, ),
        /* 24 */ array(5, ),
        /* 25 */ array(5, ),
        /* 26 */ array(10, ),
        /* 27 */ array(10, ),
        /* 28 */ array(9, ),
        /* 29 */ array(7, ),
        /* 30 */ array(6, ),
        /* 31 */ array(10, ),
        /* 32 */ array(9, ),
        /* 33 */ array(14, ),
        /* 34 */ array(18, ),
        /* 35 */ array(7, ),
        /* 36 */ array(),
        /* 37 */ array(),
        /* 38 */ array(),
        /* 39 */ array(),
        /* 40 */ array(),
        /* 41 */ array(),
        /* 42 */ array(),
        /* 43 */ array(),
        /* 44 */ array(),
        /* 45 */ array(),
        /* 46 */ array(),
        /* 47 */ array(),
        /* 48 */ array(),
        /* 49 */ array(),
        /* 50 */ array(),
        /* 51 */ array(),
        /* 52 */ array(),
        /* 53 */ array(),
);
    static public $yy_default = array(
 /*     0 */    60,   60,   60,   60,   60,   60,   60,   60,   77,   77,
 /*    10 */    77,   77,   77,   77,   77,   77,   77,   77,   77,   77,
 /*    20 */    67,   77,   72,   77,   73,   71,   77,   77,   77,   77,
 /*    30 */    77,   77,   77,   76,   77,   77,   68,   63,   64,   69,
 /*    40 */    65,   70,   58,   59,   57,   56,   55,   61,   66,   76,
 /*    50 */    75,   74,   54,   62,
);
    const YYNOCODE = 31;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 54;
    const YYNRULE = 23;
    const YYERRORSYMBOL = 21;
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
  'OTHER',         'ID',            'COLON',         'INCLUDE',     
  'SEMI_COLON',    'MIXIN_NAME',    'MIXIN_CONTENT',  'DQUOTE_STRING',
  'NUM',           'error',         'prog',          'stat_list',   
  'stat',          'bool_expr',     'mixin_declare',  'expr',        
  'stat_end',      'mixin_execute',
    );

    static public $yyRuleName = array(
 /*   0 */ "prog ::= stat_list",
 /*   1 */ "stat_list ::= stat stat_list",
 /*   2 */ "stat_list ::= IF LPAREN bool_expr RPAREN LBRACE stat_list RBRACE stat_list",
 /*   3 */ "stat_list ::= IF LPAREN bool_expr RPAREN LBRACE stat_list RBRACE ELSE LBRACE stat_list RBRACE stat_list",
 /*   4 */ "stat_list ::= mixin_declare stat_list",
 /*   5 */ "stat_list ::= OTHER stat_list",
 /*   6 */ "stat_list ::=",
 /*   7 */ "stat ::= ID COLON expr stat_end",
 /*   8 */ "stat ::= INCLUDE LPAREN expr RPAREN stat_end",
 /*   9 */ "stat ::= expr stat_end",
 /*  10 */ "stat ::= mixin_execute stat_end",
 /*  11 */ "stat ::= stat_end",
 /*  12 */ "stat_end ::= SEMI_COLON",
 /*  13 */ "bool_expr ::= expr",
 /*  14 */ "mixin_declare ::= MIXIN_NAME LBRACE MIXIN_CONTENT RBRACE",
 /*  15 */ "mixin_execute ::= MIXIN_NAME LPAREN RPAREN",
 /*  16 */ "expr ::= expr PLUS expr",
 /*  17 */ "expr ::= expr LT expr",
 /*  18 */ "expr ::= expr GT expr",
 /*  19 */ "expr ::= expr EQ expr",
 /*  20 */ "expr ::= DQUOTE_STRING",
 /*  21 */ "expr ::= NUM",
 /*  22 */ "expr ::= ID",
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
                        $x = new FISCSS_yyStackEntry;
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
                        $x = new FISCSS_yyStackEntry;
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
#line 83 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"

	echo "overflow\n";
    $this->internalError = true;
    // $this->compiler->trigger_config_file_error("Stack overflow in configfile parser");
#line 588 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
            return;
        }
        $yytos = new FISCSS_yyStackEntry;
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
  array( 'lhs' => 22, 'rhs' => 1 ),
  array( 'lhs' => 23, 'rhs' => 2 ),
  array( 'lhs' => 23, 'rhs' => 8 ),
  array( 'lhs' => 23, 'rhs' => 12 ),
  array( 'lhs' => 23, 'rhs' => 2 ),
  array( 'lhs' => 23, 'rhs' => 2 ),
  array( 'lhs' => 23, 'rhs' => 0 ),
  array( 'lhs' => 24, 'rhs' => 4 ),
  array( 'lhs' => 24, 'rhs' => 5 ),
  array( 'lhs' => 24, 'rhs' => 2 ),
  array( 'lhs' => 24, 'rhs' => 2 ),
  array( 'lhs' => 24, 'rhs' => 1 ),
  array( 'lhs' => 28, 'rhs' => 1 ),
  array( 'lhs' => 25, 'rhs' => 1 ),
  array( 'lhs' => 26, 'rhs' => 4 ),
  array( 'lhs' => 29, 'rhs' => 3 ),
  array( 'lhs' => 27, 'rhs' => 3 ),
  array( 'lhs' => 27, 'rhs' => 3 ),
  array( 'lhs' => 27, 'rhs' => 3 ),
  array( 'lhs' => 27, 'rhs' => 3 ),
  array( 'lhs' => 27, 'rhs' => 1 ),
  array( 'lhs' => 27, 'rhs' => 1 ),
  array( 'lhs' => 27, 'rhs' => 1 ),
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
        10 => 9,
        11 => 11,
        12 => 12,
        13 => 13,
        14 => 14,
        15 => 15,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
    );
#line 94 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r0(){
	$this->_retvalue = '<?php $context = array(); ' . $this->yystack[$this->yyidx + 0]->minor . ' ?>';
	echo $this->_retvalue;
	file_put_contents('__c.php', $this->_retvalue);
    }
#line 665 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 100 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r1(){
	// echo "ok\n";
	$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 671 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 105 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r2(){
	$this->_retvalue = 'if(' . $this->yystack[$this->yyidx + -5]->minor . '){' . $this->yystack[$this->yyidx + -2]->minor . '}' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 676 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 109 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r3(){
	$this->_retvalue = 'if(' . $this->yystack[$this->yyidx + -9]->minor . '){' . $this->yystack[$this->yyidx + -6]->minor . '}else{' . $this->yystack[$this->yyidx + -2]->minor . '}' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 681 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 113 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r4(){
	$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
	echo $this->yystack[$this->yyidx + -1]->minor . "\n";
    }
#line 687 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 118 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r5(){
	$this->_retvalue = 'echo "' . $this->yystack[$this->yyidx + -1]->minor . '\n";' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 692 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 122 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r6(){
	$this->_retvalue = '';
	// echo "empty\n";
    }
#line 698 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 127 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r7(){
	$name = $this->getID($this->yystack[$this->yyidx + -3]->minor);
	// echo "name:[$name]\n";
	// $this->setVar($name, $this->yystack[$this->yyidx + -1]->minor);
	$this->_retvalue = '$context["' . $name . '"] = ' . $this->yystack[$this->yyidx + -1]->minor
		. '; echo $context["' . $name . '"] . "\n"' . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 707 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 135 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r8(){
	$this->_retvalue = '';
	echo "include file " . $this->yystack[$this->yyidx + -2]->minor . "\n";
	if(file_exists($this->yystack[$this->yyidx + -2]->minor)){
		$this->_retvalue = file_get_contents($this->yystack[$this->yyidx + -2]->minor);
		$this->_retvalue = $this->escapeText($this->_retvalue);
		$this->_retvalue = 'echo "' . $this->_retvalue . '";';
	}
    }
#line 718 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 145 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r9(){
	$this->_retvalue = 'echo ' . $this->yystack[$this->yyidx + -1]->minor . ';';
    }
#line 723 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 153 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r11(){
	$this->_retvalue = '';
	echo "empty statment \n";
    }
#line 729 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 158 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r12(){
	// echo "semi_colon\n";
	$this->_retvalue = ';';
    }
#line 735 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 163 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r13(){
	$this->_retvalue = '(bool)(' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 740 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 167 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r14(){
	$this->_retvalue = '$context["mixin"]["' . $this->yystack[$this->yyidx + -3]->minor . '"] = "' . $this->escapeText($this->yystack[$this->yyidx + -1]->minor) . '";';
	echo "declare: " . $this->yystack[$this->yyidx + -3]->minor . '{' . $this->yystack[$this->yyidx + -1]->minor . '}\n';
    }
#line 746 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 172 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r15(){
	$this->_retvalue = '$context["mixin"]["' . $this->yystack[$this->yyidx + -2]->minor . '"];';
    }
#line 751 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 176 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r16(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor + (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') + (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 757 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 181 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r17(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor < (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') < (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 763 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 186 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r18(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor > (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') > (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 769 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 191 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r19(){
	// $this->_retvalue = (float)$this->yystack[$this->yyidx + -2]->minor == (float)$this->yystack[$this->yyidx + 0]->minor;
	$this->_retvalue = '(' . $this->yystack[$this->yyidx + -2]->minor . ') == (' . $this->yystack[$this->yyidx + 0]->minor . ')';
    }
#line 775 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 196 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r20(){
	$this->_retvalue = substr($this->yystack[$this->yyidx + 0]->minor, 1, strlen($this->yystack[$this->yyidx + 0]->minor)-2);
	$this->_retvalue = $this->escapeText($this->_retvalue);
	$this->_retvalue = '"' . $this->_retvalue . '"';
	echo "quoted string: " . $this->yystack[$this->yyidx + 0]->minor . "\n";
    }
#line 783 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 203 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r21(){
	$this->_retvalue = (float)$this->yystack[$this->yyidx + 0]->minor;
    }
#line 788 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
#line 207 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"
    function yy_r22(){
	$name = $this->getID($this->yystack[$this->yyidx + 0]->minor);
	// echo "name:[$name]\n";
	// $this->_retvalue = $this->getVar($name);
	$this->_retvalue = '$context["' . $name .'"]';
    }
#line 796 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"

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
                $x = new FISCSS_yyStackEntry;
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
#line 71 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"

	echo "error[yymajor: $yymajor, tokenvalue: " . $this->lex->value . "]" 
		. "stateno: " . $this->yystack[$this->yyidx]->stateno
		. " lineno: " . $this->lex->line
		. "\n";
	var_export($this->yy_get_expected_tokens($yymajor));
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // $this->compiler->trigger_config_file_error();
#line 864 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
    }

    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
#line 62 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.y"

	echo "accept\n";
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
#line 883 "D:\SVN_TEMP\my_fis\lexer\src\fis_css\FisCssParser.php"
    }

    function doParse($yymajor, $yytokenvalue)
    {
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        if ($this->yyidx === null || $this->yyidx < 0) {
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new FISCSS_yyStackEntry;
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
