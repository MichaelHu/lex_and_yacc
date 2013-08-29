<?php
class MARKDOWN_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof MARKDOWN_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof MARKDOWN_yyToken) {
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
                $x = ($value instanceof MARKDOWN_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof MARKDOWN_yyToken) {
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

class MARKDOWN_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};


#line 9 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
class MarkdownParser#line 79 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
{
#line 11 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"

    // states whether the parse was successful or not
    public $successful = false;
    public $retvalue = 0;
    private $lex;
    private $internalError = false;
	private $context;
    private $enableDebug = true;
    private $enableErrorReport = true;

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

    public function disableDebug(){
        $this->enableDebug = false;
    }

    public function disableErrorReport(){
        $this->enableErrorReport = false;
    }

    private function imageBase64Enc($file_path){
        $imgtype = array('jpg', 'gif', 'png');
        if(file_exists($file_path)){
            $filename = htmlentities($file_path);
        }
        else{
            return "$file_path not exists";
        }

        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($filetype, $imgtype)){
            $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        } else {
            return 'Invalid image type, jpg, gif, and png is only allowed';
        }

        return 'data:image/' 
            . $filetype 
            . ';base64,' 
            . base64_encode($imgbinary);
    }

	private function addBlock($block){
		$this->context[] = $block;
	}

	private function log($info){
        if($this->enableDebug){
            echo $info . "\n";
        }
	}

	private function error($info){
        if($this->enableErrorReport){
            echo $info . "\n";
        }
	}

#line 153 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"

    const MARKDOWN_DOCINFO_START                  =  1;
    const MARKDOWN_TEXT                           =  2;
    const MARKDOWN_DOCINFOLINE_END                =  3;
    const MARKDOWN_PARAGRAPH_START                =  4;
    const MARKDOWN_ASTERISK                       =  5;
    const MARKDOWN_EMPHASIS                       =  6;
    const MARKDOWN_LINK_START                     =  7;
    const MARKDOWN_LINKTEXT                       =  8;
    const MARKDOWN_LINK_INNER                     =  9;
    const MARKDOWN_LINK_END                       = 10;
    const MARKDOWN_BACKSLASH                      = 11;
    const MARKDOWN_ESCAPEDCHAR                    = 12;
    const MARKDOWN_NON_ESCAPEDCHAR                = 13;
    const MARKDOWN_CODELINE_START                 = 14;
    const MARKDOWN_CODETEXT                       = 15;
    const MARKDOWN_UL_START                       = 16;
    const MARKDOWN_OL_START                       = 17;
    const MARKDOWN_HEADLINE_START                 = 18;
    const MARKDOWN_IMAGE_START                    = 19;
    const MARKDOWN_IMAGETEXT                      = 20;
    const MARKDOWN_IMAGE_INNER                    = 21;
    const MARKDOWN_IMAGE_END                      = 22;
    const YY_NO_ACTION = 165;
    const YY_ACCEPT_ACTION = 164;
    const YY_ERROR_ACTION = 163;

    const YY_SZ_ACTTAB = 151;
static public $yy_action = array(
 /*     0 */    54,   58,   59,   62,   92,   91,   88,   11,   61,    9,
 /*    10 */     7,   31,    8,   13,   24,   10,   49,   44,  164,   76,
 /*    20 */    39,   40,   30,  100,   33,   67,   27,   22,   43,   42,
 /*    30 */     6,   29,   74,    2,   49,   44,   29,   72,   19,   40,
 /*    40 */     4,   73,    3,    5,    4,   84,    3,    5,   37,   51,
 /*    50 */     4,   85,    3,    5,   24,    4,   89,    3,    5,    4,
 /*    60 */    79,    3,    5,   90,    4,   99,    3,    5,    4,   96,
 /*    70 */     3,    5,   45,    4,   95,    3,    5,   80,   82,    4,
 /*    80 */    87,    3,    5,    4,   78,    3,    5,   15,   18,   16,
 /*    90 */    14,   49,   17,   49,   20,   32,   21,   23,   49,   26,
 /*   100 */    49,   24,   28,   63,   28,   65,   18,   13,   24,   13,
 /*   110 */    98,   13,   41,   35,   13,   36,   24,   94,   19,   56,
 /*   120 */    13,   53,   24,   68,   48,   93,   66,   83,   38,   52,
 /*   130 */   101,   71,   57,   47,   25,   46,   81,   50,   64,   34,
 /*   140 */    70,   75,   86,   77,   60,   33,   12,   55,   69,    1,
 /*   150 */    97,
    );
    static public $yy_lookahead = array(
 /*     0 */    32,   33,   34,   35,   36,   37,   38,   39,    2,   41,
 /*    10 */    42,   43,    2,   39,   39,    5,    6,    7,   24,   25,
 /*    20 */    26,   11,   28,   48,   14,   51,   16,   17,   18,   19,
 /*    30 */     2,   43,   44,    5,    6,    7,   43,   44,   39,   11,
 /*    40 */    39,   40,   41,   42,   39,   40,   41,   42,   49,    8,
 /*    50 */    39,   40,   41,   42,   39,   39,   40,   41,   42,   39,
 /*    60 */    40,   41,   42,   48,   39,   40,   41,   42,   39,   40,
 /*    70 */    41,   42,   20,   39,   40,   41,   42,   12,   13,   39,
 /*    80 */    40,   41,   42,   39,   40,   41,   42,    2,   39,    2,
 /*    90 */     5,    6,    5,    6,    2,   46,    2,    5,    6,    5,
 /*   100 */     6,   39,   28,   29,   28,   29,   39,   39,   39,   39,
 /*   110 */    48,   39,   21,   46,   39,   27,   39,   48,   39,   51,
 /*   120 */    39,   51,   39,   51,   20,   48,   51,    6,   49,    9,
 /*   130 */    50,   48,   51,    8,   17,    1,   10,    2,   22,    2,
 /*   140 */    31,   45,   47,   15,    3,   14,   16,   50,   30,    4,
 /*   150 */    47,
);
    const YY_SHIFT_USE_DFLT = -1;
    const YY_SHIFT_MAX = 52;
    static public $yy_shift_ofst = array(
 /*     0 */   134,   10,   28,   28,   28,   28,   28,   28,   28,   28,
 /*    10 */    28,   28,   94,   85,   85,   85,   85,   85,   92,   85,
 /*    20 */    92,   92,   87,   92,   92,   87,   92,   94,  134,  131,
 /*    30 */   134,  131,  130,  128,  141,  130,  145,  117,  117,   -1,
 /*    40 */    65,  104,   52,    6,   41,   91,  137,  126,  116,  135,
 /*    50 */   121,  120,  125,
);
    const YY_REDUCE_USE_DFLT = -33;
    const YY_REDUCE_MAX = 39;
    static public $yy_reduce_ofst = array(
 /*     0 */    -6,  -32,   29,   25,   34,   40,   44,   20,    1,   11,
 /*    10 */     5,   16,   67,   70,   68,  -26,   75,   72,   62,   81,
 /*    20 */    83,   77,   79,   69,  -25,   -1,   15,   49,   76,  -12,
 /*    30 */    74,   -7,   95,   96,  118,  103,  109,   97,   80,   88,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(1, ),
        /* 1 */ array(2, 5, 6, 7, 11, 14, 16, 17, 18, 19, ),
        /* 2 */ array(2, 5, 6, 7, 11, ),
        /* 3 */ array(2, 5, 6, 7, 11, ),
        /* 4 */ array(2, 5, 6, 7, 11, ),
        /* 5 */ array(2, 5, 6, 7, 11, ),
        /* 6 */ array(2, 5, 6, 7, 11, ),
        /* 7 */ array(2, 5, 6, 7, 11, ),
        /* 8 */ array(2, 5, 6, 7, 11, ),
        /* 9 */ array(2, 5, 6, 7, 11, ),
        /* 10 */ array(2, 5, 6, 7, 11, ),
        /* 11 */ array(2, 5, 6, 7, 11, ),
        /* 12 */ array(2, 5, 6, ),
        /* 13 */ array(2, 5, 6, ),
        /* 14 */ array(2, 5, 6, ),
        /* 15 */ array(2, 5, 6, ),
        /* 16 */ array(2, 5, 6, ),
        /* 17 */ array(2, 5, 6, ),
        /* 18 */ array(2, 5, 6, ),
        /* 19 */ array(2, 5, 6, ),
        /* 20 */ array(2, 5, 6, ),
        /* 21 */ array(2, 5, 6, ),
        /* 22 */ array(2, 5, 6, ),
        /* 23 */ array(2, 5, 6, ),
        /* 24 */ array(2, 5, 6, ),
        /* 25 */ array(2, 5, 6, ),
        /* 26 */ array(2, 5, 6, ),
        /* 27 */ array(2, 5, 6, ),
        /* 28 */ array(1, ),
        /* 29 */ array(14, ),
        /* 30 */ array(1, ),
        /* 31 */ array(14, ),
        /* 32 */ array(16, ),
        /* 33 */ array(15, ),
        /* 34 */ array(3, ),
        /* 35 */ array(16, ),
        /* 36 */ array(4, ),
        /* 37 */ array(17, ),
        /* 38 */ array(17, ),
        /* 39 */ array(),
        /* 40 */ array(12, 13, ),
        /* 41 */ array(20, ),
        /* 42 */ array(20, ),
        /* 43 */ array(2, ),
        /* 44 */ array(8, ),
        /* 45 */ array(21, ),
        /* 46 */ array(2, ),
        /* 47 */ array(10, ),
        /* 48 */ array(22, ),
        /* 49 */ array(2, ),
        /* 50 */ array(6, ),
        /* 51 */ array(9, ),
        /* 52 */ array(8, ),
        /* 53 */ array(),
        /* 54 */ array(),
        /* 55 */ array(),
        /* 56 */ array(),
        /* 57 */ array(),
        /* 58 */ array(),
        /* 59 */ array(),
        /* 60 */ array(),
        /* 61 */ array(),
        /* 62 */ array(),
        /* 63 */ array(),
        /* 64 */ array(),
        /* 65 */ array(),
        /* 66 */ array(),
        /* 67 */ array(),
        /* 68 */ array(),
        /* 69 */ array(),
        /* 70 */ array(),
        /* 71 */ array(),
        /* 72 */ array(),
        /* 73 */ array(),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(),
        /* 77 */ array(),
        /* 78 */ array(),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(),
);
    static public $yy_default = array(
 /*     0 */   163,  119,  130,  130,  130,  130,  130,  130,  130,  130,
 /*    10 */   130,  130,  163,  160,  160,  160,  160,  160,  150,  160,
 /*    20 */   150,  150,  163,  150,  150,  163,  150,  163,  106,  137,
 /*    30 */   106,  137,  143,  140,  109,  143,  103,  153,  153,  111,
 /*    40 */   163,  163,  163,  163,  163,  163,  163,  163,  163,  163,
 /*    50 */   163,  163,  163,  157,  112,  152,  158,  154,  113,  114,
 /*    60 */   108,  161,  115,  104,  162,  105,  156,  159,  155,  107,
 /*    70 */   110,  149,  135,  124,  136,  138,  102,  139,  129,  123,
 /*    80 */   133,  132,  134,  131,  122,  121,  141,  128,  118,  120,
 /*    90 */   145,  117,  116,  146,  148,  125,  127,  142,  144,  126,
 /*   100 */   147,  151,
);
    const YYNOCODE = 53;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 102;
    const YYNRULE = 61;
    const YYERRORSYMBOL = 23;
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
  '$',             'DOCINFO_START',  'TEXT',          'DOCINFOLINE_END',
  'PARAGRAPH_START',  'ASTERISK',      'EMPHASIS',      'LINK_START',  
  'LINKTEXT',      'LINK_INNER',    'LINK_END',      'BACKSLASH',   
  'ESCAPEDCHAR',   'NON_ESCAPEDCHAR',  'CODELINE_START',  'CODETEXT',    
  'UL_START',      'OL_START',      'HEADLINE_START',  'IMAGE_START', 
  'IMAGETEXT',     'IMAGE_INNER',   'IMAGE_END',     'error',       
  'start',         'markdownfile',  'docinfo',       'paragraphs',  
  'docinfo_line',  'otherdocinfo',  'docinfo_lineend',  'paragraph',   
  'text',          'codelines',     'ul',            'ol',          
  'headline',      'image',         'emptytext',     'emphasis_text',
  'text_other',    'link',          'escape',        'codeline',    
  'othercodelines',  'code',          'ul_li',         'remain_ul',   
  'ul_text_other',  'ol_li',         'remain_ol',     'ol_text_other',
    );

    static public $yyRuleName = array(
 /*   0 */ "start ::= markdownfile",
 /*   1 */ "markdownfile ::= docinfo paragraphs",
 /*   2 */ "docinfo ::= docinfo_line otherdocinfo",
 /*   3 */ "otherdocinfo ::= docinfo_line otherdocinfo",
 /*   4 */ "otherdocinfo ::=",
 /*   5 */ "docinfo_line ::= DOCINFO_START TEXT docinfo_lineend",
 /*   6 */ "docinfo_lineend ::= DOCINFOLINE_END",
 /*   7 */ "docinfo_lineend ::=",
 /*   8 */ "paragraphs ::= paragraphs paragraph",
 /*   9 */ "paragraphs ::=",
 /*  10 */ "paragraph ::= PARAGRAPH_START text",
 /*  11 */ "paragraph ::= PARAGRAPH_START codelines",
 /*  12 */ "paragraph ::= PARAGRAPH_START ul",
 /*  13 */ "paragraph ::= PARAGRAPH_START ol",
 /*  14 */ "paragraph ::= PARAGRAPH_START headline",
 /*  15 */ "paragraph ::= PARAGRAPH_START image",
 /*  16 */ "paragraph ::= PARAGRAPH_START emptytext",
 /*  17 */ "emptytext ::=",
 /*  18 */ "text ::= emphasis_text text_other",
 /*  19 */ "text ::= link text_other",
 /*  20 */ "text ::= ASTERISK text_other",
 /*  21 */ "text ::= escape text_other",
 /*  22 */ "text ::= TEXT text_other",
 /*  23 */ "text_other ::= emphasis_text text_other",
 /*  24 */ "text_other ::= link text_other",
 /*  25 */ "text_other ::= ASTERISK text_other",
 /*  26 */ "text_other ::= escape text_other",
 /*  27 */ "text_other ::= TEXT text_other",
 /*  28 */ "text_other ::=",
 /*  29 */ "emphasis_text ::= EMPHASIS TEXT EMPHASIS",
 /*  30 */ "link ::= LINK_START LINKTEXT LINK_INNER LINKTEXT LINK_END",
 /*  31 */ "escape ::= BACKSLASH ESCAPEDCHAR",
 /*  32 */ "escape ::= BACKSLASH NON_ESCAPEDCHAR",
 /*  33 */ "codelines ::= codeline othercodelines",
 /*  34 */ "othercodelines ::= codeline othercodelines",
 /*  35 */ "othercodelines ::=",
 /*  36 */ "codeline ::= CODELINE_START code",
 /*  37 */ "code ::= CODETEXT",
 /*  38 */ "code ::=",
 /*  39 */ "ul ::= UL_START ul_li remain_ul",
 /*  40 */ "remain_ul ::= UL_START ul_li remain_ul",
 /*  41 */ "remain_ul ::=",
 /*  42 */ "ul_li ::= emphasis_text ul_text_other",
 /*  43 */ "ul_li ::= ASTERISK ul_text_other",
 /*  44 */ "ul_li ::= TEXT ul_text_other",
 /*  45 */ "ul_text_other ::= emphasis_text ul_text_other",
 /*  46 */ "ul_text_other ::= ASTERISK ul_text_other",
 /*  47 */ "ul_text_other ::= TEXT ul_text_other",
 /*  48 */ "ul_text_other ::=",
 /*  49 */ "ol ::= OL_START ol_li remain_ol",
 /*  50 */ "remain_ol ::= OL_START ol_li remain_ol",
 /*  51 */ "remain_ol ::=",
 /*  52 */ "ol_li ::= emphasis_text ol_text_other",
 /*  53 */ "ol_li ::= ASTERISK ol_text_other",
 /*  54 */ "ol_li ::= TEXT ol_text_other",
 /*  55 */ "ol_text_other ::= emphasis_text ol_text_other",
 /*  56 */ "ol_text_other ::= ASTERISK ol_text_other",
 /*  57 */ "ol_text_other ::= TEXT ol_text_other",
 /*  58 */ "ol_text_other ::=",
 /*  59 */ "headline ::= HEADLINE_START TEXT",
 /*  60 */ "image ::= IMAGE_START IMAGETEXT IMAGE_INNER IMAGETEXT IMAGE_END",
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
                        $x = new MARKDOWN_yyStackEntry;
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
                        $x = new MARKDOWN_yyStackEntry;
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
#line 107 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"

    /**
     * @note: 偶尔出现的overflow问题，比如guide_to_BSTR_and_c_string_conversions.text, ni_plan_2011.text 
     *      等内容较长的文件，可以通过调整解析堆栈的深度参数来解决
     *      MarkdownParser::YYSTACKDEPTH默认值为100，是小了点
     *      修改：lib/ParserGenerator.php line 441: $lem->stacksize = 300;
     * @note: 修正，发现随着文件行数的增加，堆栈使用量也在同量增加。应该是存在bug，目前修改到3000
     * @note: 修正，重新修改回默认的100，之前的语法文件犯了一个性能方面的错误－消除所有的左递归，
     *    实际上左递归可以大大减少堆栈使用量
     */
	$this->error("error: stack overflow");
    $this->internalError = true;
    // $this->compiler->trigger_config_file_error("Stack overflow in configfile parser");
#line 735 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
            return;
        }
        $yytos = new MARKDOWN_yyStackEntry;
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
  array( 'lhs' => 24, 'rhs' => 1 ),
  array( 'lhs' => 25, 'rhs' => 2 ),
  array( 'lhs' => 26, 'rhs' => 2 ),
  array( 'lhs' => 29, 'rhs' => 2 ),
  array( 'lhs' => 29, 'rhs' => 0 ),
  array( 'lhs' => 28, 'rhs' => 3 ),
  array( 'lhs' => 30, 'rhs' => 1 ),
  array( 'lhs' => 30, 'rhs' => 0 ),
  array( 'lhs' => 27, 'rhs' => 2 ),
  array( 'lhs' => 27, 'rhs' => 0 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 31, 'rhs' => 2 ),
  array( 'lhs' => 38, 'rhs' => 0 ),
  array( 'lhs' => 32, 'rhs' => 2 ),
  array( 'lhs' => 32, 'rhs' => 2 ),
  array( 'lhs' => 32, 'rhs' => 2 ),
  array( 'lhs' => 32, 'rhs' => 2 ),
  array( 'lhs' => 32, 'rhs' => 2 ),
  array( 'lhs' => 40, 'rhs' => 2 ),
  array( 'lhs' => 40, 'rhs' => 2 ),
  array( 'lhs' => 40, 'rhs' => 2 ),
  array( 'lhs' => 40, 'rhs' => 2 ),
  array( 'lhs' => 40, 'rhs' => 2 ),
  array( 'lhs' => 40, 'rhs' => 0 ),
  array( 'lhs' => 39, 'rhs' => 3 ),
  array( 'lhs' => 41, 'rhs' => 5 ),
  array( 'lhs' => 42, 'rhs' => 2 ),
  array( 'lhs' => 42, 'rhs' => 2 ),
  array( 'lhs' => 33, 'rhs' => 2 ),
  array( 'lhs' => 44, 'rhs' => 2 ),
  array( 'lhs' => 44, 'rhs' => 0 ),
  array( 'lhs' => 43, 'rhs' => 2 ),
  array( 'lhs' => 45, 'rhs' => 1 ),
  array( 'lhs' => 45, 'rhs' => 0 ),
  array( 'lhs' => 34, 'rhs' => 3 ),
  array( 'lhs' => 47, 'rhs' => 3 ),
  array( 'lhs' => 47, 'rhs' => 0 ),
  array( 'lhs' => 46, 'rhs' => 2 ),
  array( 'lhs' => 46, 'rhs' => 2 ),
  array( 'lhs' => 46, 'rhs' => 2 ),
  array( 'lhs' => 48, 'rhs' => 2 ),
  array( 'lhs' => 48, 'rhs' => 2 ),
  array( 'lhs' => 48, 'rhs' => 2 ),
  array( 'lhs' => 48, 'rhs' => 0 ),
  array( 'lhs' => 35, 'rhs' => 3 ),
  array( 'lhs' => 50, 'rhs' => 3 ),
  array( 'lhs' => 50, 'rhs' => 0 ),
  array( 'lhs' => 49, 'rhs' => 2 ),
  array( 'lhs' => 49, 'rhs' => 2 ),
  array( 'lhs' => 49, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 0 ),
  array( 'lhs' => 36, 'rhs' => 2 ),
  array( 'lhs' => 37, 'rhs' => 5 ),
    );

    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 2,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 6,
        8 => 8,
        18 => 8,
        19 => 8,
        20 => 8,
        21 => 8,
        22 => 8,
        23 => 8,
        24 => 8,
        25 => 8,
        26 => 8,
        27 => 8,
        33 => 8,
        34 => 8,
        36 => 8,
        39 => 8,
        40 => 8,
        45 => 8,
        46 => 8,
        47 => 8,
        49 => 8,
        50 => 8,
        55 => 8,
        56 => 8,
        57 => 8,
        9 => 9,
        16 => 9,
        28 => 9,
        35 => 9,
        41 => 9,
        48 => 9,
        51 => 9,
        58 => 9,
        10 => 10,
        11 => 11,
        12 => 11,
        13 => 11,
        14 => 11,
        15 => 11,
        17 => 17,
        29 => 29,
        30 => 30,
        31 => 31,
        32 => 32,
        37 => 37,
        38 => 38,
        42 => 42,
        43 => 42,
        44 => 42,
        52 => 52,
        53 => 52,
        54 => 52,
        59 => 59,
        60 => 60,
    );
#line 129 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r0(){
    // $this->log($this->yystack[$this->yyidx + 0]->minor);
    }
#line 886 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 138 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r1(){
    // $this->log("docinfo: " . $this->yystack[$this->yyidx + -1]->minor);
    $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 892 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 147 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r2(){
    $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor; 
    }
#line 897 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 155 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r4(){
    $this->_retvalue = ''; 
    }
#line 902 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 159 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r5(){
    $this->log("docinfo_line: " . $this->yystack[$this->yyidx + -1]->minor);

    $this->addBlock(array(
        'type' => 'docinfo'
        ,'content' => $this->yystack[$this->yyidx + -1]->minor
    ));

    $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; 
    }
#line 914 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 170 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r6(){
    }
#line 918 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 180 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r8(){
    $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 923 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 184 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r9(){
    $this->_retvalue = '';
    }
#line 928 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 192 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r10(){
    $this->log("paragraph: " . $this->yystack[$this->yyidx + 0]->minor);

    $this->addBlock(array(
        'type' => 'paragraph'
        ,'content' => $this->yystack[$this->yyidx + 0]->minor
    ));

    $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 940 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 203 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r11(){
    $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 945 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 227 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r17(){
    // empty paragraph, especially empty lines at the end of file
    $this->_retvalue = '';
    }
#line 951 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 286 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r29(){

    $formated_text = '+@@__EMPHASIS__@@' 
                    . $this->yystack[$this->yyidx + -1]->minor 
                    .'-@@__EMPHASIS__@@';

    $this->log("emphasis: " . $formated_text);

    $this->addBlock(array(
        'type' => 'emphasis'
        ,'content' => $formated_text
    ));

    $this->_retvalue = $formated_text;
    }
#line 968 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 306 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r30(){
    $formated_text = '+@@__LEFT__@@' 
                    . 'a href="'
                    . $this->yystack[$this->yyidx + -1]->minor
                    . '"'
                    .'-@@__RIGHT__@@'
                    . $this->yystack[$this->yyidx + -3]->minor 
                    .'+@@__LEFT__@@'
                    . '/a'
                    .'-@@__RIGHT__@@';

    $this->log("link: " . $formated_text);

    $this->addBlock(array(
        'type' => 'link'
        ,'content' => $formated_text
    ));

    $this->_retvalue = $formated_text;
    }
#line 990 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 331 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r31(){
    // @note: [和\需要转义

    $formated_text = $this->yystack[$this->yyidx + 0]->minor;

    $this->log("escape: " . $formated_text);

    $this->addBlock(array(
        'type' => 'escape'
        ,'content' => $formated_text
    ));

    $this->_retvalue = $formated_text;
    }
#line 1006 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 346 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r32(){
    $formated_text = '\\' . $this->yystack[$this->yyidx + 0]->minor;

    $this->log("non_escape: " . $formated_text);

    $this->addBlock(array(
        'type' => 'non_escape'
        ,'content' => $formated_text
    ));

    $this->_retvalue = $formated_text;
    }
#line 1020 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 379 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r37(){
    $this->log("code :" . $this->yystack[$this->yyidx + 0]->minor);

    $this->addBlock(array(
        'type' => 'code'
        ,'content' => $this->yystack[$this->yyidx + 0]->minor
    ));

    $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1032 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 390 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r38(){
    // @note: 支持空代码行
    $this->log("code : ");

    $this->addBlock(array(
        'type' => 'code'
        ,'content' => ''
    ));

    $this->_retvalue = '';
    }
#line 1045 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 418 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r42(){
    $this->log("ul: " . $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor);

    $this->addBlock(array(
        'type' => 'ul'
        ,'content' => $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor
    ));

    $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1057 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 483 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r52(){
    $this->log("ol: " . $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor);

    $this->addBlock(array(
        'type' => 'ol'
        ,'content' => $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor
    ));

    $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor . $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1069 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 537 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r59(){
    $this->log("headline level " . strlen(rtrim($this->yystack[$this->yyidx + -1]->minor)) . ": " . $this->yystack[$this->yyidx + 0]->minor);

    $this->addBlock(array(
        'type' => 'headline'
        ,'level' => strlen(rtrim($this->yystack[$this->yyidx + -1]->minor))
        ,'content' => $this->yystack[$this->yyidx + 0]->minor
    ));

    $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1082 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
#line 553 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"
    function yy_r60(){
    $alt_text = $this->yystack[$this->yyidx + -3]->minor;
    $path = '';
    $title = $alt_text;
    $arr = preg_split('/ +/', $this->yystack[$this->yyidx + -1]->minor);

    $path = $arr[0];
    $realpath = $path;

    if(count($arr) == 2){
        $title = $arr[1];
    }

    if( 0 !== strpos($path, 'http://') ){
        $file_path = $this->context['file_path'];
        $realpath = realpath(
            dirname($file_path) . DIRECTORY_SEPARATOR . $path        
        );
        $realpath = $this->imageBase64Enc($realpath);
    }

    $content = "<img src=\"$realpath\" alt=\"$alt_text\" title=\"$title\">";

    $this->log("image: $content"); 

    $this->addBlock(array(
        'type' => 'image'
        ,'url' => $realpath
        ,'title' => $title
        ,'alt' => $alt_text
    ));

    $this->_retvalue = $content;
    }
#line 1118 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"

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
                $x = new MARKDOWN_yyStackEntry;
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
#line 95 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"

	$this->error(
        "syntax error: [yymajor: $yymajor, tokenvalue: " . $this->lex->value 
        . ", line: " . $this->lex->line . "]" 
		. " stateno: " . $this->yystack[$this->yyidx]->stateno
        );
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // $this->compiler->trigger_config_file_error();
#line 1186 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
    }

    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
#line 87 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.y"

    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
#line 1204 "/Users/hudamin/projects/git/lex_yacc/php_lex_yacc/src/markdown/MarkdownParser.php"
    }

    function doParse($yymajor, $yytokenvalue)
    {
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        if ($this->yyidx === null || $this->yyidx < 0) {
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new MARKDOWN_yyStackEntry;
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
