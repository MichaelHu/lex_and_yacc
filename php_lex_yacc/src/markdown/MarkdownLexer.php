<?php
/**
* MarkdownFileLexer
*
* This is the lexer to break the markdown file source into tokens 
* @author hudamin@baidu.com 
*/
class MarkdownLexer
{

    public $data;
    public $counter;
    public $token;
    public $value;
    public $node;
    public $line;
    private $state = 1;
    private $mbstring_overload = false;
    				
    				
    function __construct($data, $smarty = null)
    {
        // set instance object
        self::instance($this); 
        // $this->data = $data . "\n"; //now all lines are \n-terminated
        $this->data = $data;
        $this->counter = 0;
        $this->line = 1;
     }
    public static function &instance($new_instance = null)
    {
        static $instance = null;
        if (isset($new_instance) && is_object($new_instance))
            $instance = $new_instance;
        return $instance;
    } 

    public function showstate(){
        echo "state: " . $this->_yy_state . "\n";
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
              3 => 1,
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
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(% *)|\G(#+ *)|\G((\r?\n)+)|\G(\\* +)|\G([1-9]+\\. )|\G(\\*\\*)|\G(\t| {4})|\G(!\\[)|\G(\\[)|\G(\\\\)|\G([^\r\n*[\\\\]+)|\G(\\*)|\G(\r?\n)/iS";

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

    $this->token = MarkdownParser::MARKDOWN_DOCINFO_START;

    // context-related grammar, enter new state: READDOCINFO 
    $this->yypushstate(self::READDOCINFO);
    }
    function yy_r1_2($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_HEADLINE_START;

    // context-related grammar, enter new state: READTEXT 
    $this->yypushstate(self::READTEXT);
    }
    function yy_r1_3($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    }
    function yy_r1_5($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_UL_START;

    // context-related grammar, enter new state: TEXT 
    $this->yypushstate(self::TEXT);
    }
    function yy_r1_6($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_OL_START;

    // context-related grammar, enter new state: TEXT 
    $this->yypushstate(self::TEXT);
    }
    function yy_r1_7($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_EMPHASIS;

    // context-related grammar, enter new state: READEMPHASISTEXT 
    $this->yypushstate(self::READEMPHASISTEXT);
    }
    function yy_r1_8($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_CODELINE_START;

    // context-related grammar, enter new state: READCODETEXT 
    $this->yypushstate(self::READCODETEXT);
    }
    function yy_r1_9($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_IMAGE_START;

    // context-related grammar, enter new state: READIMAGE 
    $this->yypushstate(self::READIMAGE);
    }
    function yy_r1_10($yy_subpatterns)
    {

    // link mode
	$this->token = MarkdownParser::MARKDOWN_LINK_START;

    // context-related grammar, enter new state: READLINK 
    $this->yypushstate(self::READLINK);
    }
    function yy_r1_11($yy_subpatterns)
    {

    // escape mode
	$this->token = MarkdownParser::MARKDOWN_BACKSLASH;

    // context-related grammar, enter new state: READESCAPE 
    $this->yypushstate(self::READESCAPE);
    }
    function yy_r1_12($yy_subpatterns)
    {

    // text mode
	$this->token = MarkdownParser::MARKDOWN_TEXT;

    // context-related grammar, enter new state: TEXT 
    $this->yypushstate(self::TEXT);
    }
    function yy_r1_13($yy_subpatterns)
    {

    // text mode
	$this->token = MarkdownParser::MARKDOWN_ASTERISK;

    // context-related grammar, enter new state: TEXT 
    $this->yypushstate(self::TEXT);
    }
    function yy_r1_14($yy_subpatterns)
    {

    // @note: false to skip current token -- parser will ignore it -- and cycle to next token
    return false;
    }



    function yylex2()
    {
        $tokenMap = array (
              1 => 0,
              2 => 1,
              4 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n*[\\\\]+)|\G((\r?\n)+)|\G(\r?\n)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READTEXT');
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
                $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
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


    const READTEXT = 2;
    function yy_r2_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_TEXT;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    }
    function yy_r2_2($yy_subpatterns)
    {

    // 文本后面可能紧接着两个换行，但也得支持紧跟一个换行的情况
    // @note: 先于linebreak匹配
	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    // return to START state 
    $this->yypopstate();
    }
    function yy_r2_4($yy_subpatterns)
    {

    // 此时换行视为段落起始token
	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    // return to START state 
    $this->yypopstate();
    }



    function yylex3()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 1,
              8 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(\\*\\*)|\G(\\*)|\G(\\[)|\G(\\\\)|\G([^\r\n*[\\\\]+)|\G((\r?\n)+)|\G(\r?\n)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state TEXT');
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
                $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
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


    const TEXT = 3;
    function yy_r3_1($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_EMPHASIS;
    $this->yypushstate(self::READEMPHASISTEXT);
    }
    function yy_r3_2($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_ASTERISK;    
    }
    function yy_r3_3($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_LINK_START;

    // context-related grammar, enter new state: READLINK 
    $this->yypushstate(self::READLINK);
    }
    function yy_r3_4($yy_subpatterns)
    {

    /**
     * @note: 只在paragraph中考虑反斜线转义，code中的反斜线不转义 
     */

	$this->token = MarkdownParser::MARKDOWN_BACKSLASH;

    // context-related grammar, enter new state: READESCAPE 
    $this->yypushstate(self::READESCAPE);
    }
    function yy_r3_5($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_TEXT;
    }
    function yy_r3_6($yy_subpatterns)
    {

    // 文本后面可能紧接着两个换行，但也得支持紧跟一个换行的情况
    // @note: 先于linebreak匹配
	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    // return to START state 
    $this->yypopstate();
    }
    function yy_r3_8($yy_subpatterns)
    {

    // 此时换行视为段落起始token
	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    // return to START state 
    $this->yypopstate();
    }



    function yylex4()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n*[\\\\]+)|\G(\r?\n)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READDOCINFO');
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
                $r = $this->{'yy_r4_' . $this->token}($yysubmatches);
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


    const READDOCINFO = 4;
    function yy_r4_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_TEXT;
    }
    function yy_r4_2($yy_subpatterns)
    {

    /**
     * @note: !! return false cannot exist together with yypushstate, yypopstate or yybegin 
     */
	$this->token = MarkdownParser::MARKDOWN_DOCINFOLINE_END;
    $this->yypopstate();
    }



    function yylex5()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G(\\*\\*)|\G([^\r\n*[\\\\]+)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READEMPHASISTEXT');
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
                $r = $this->{'yy_r5_' . $this->token}($yysubmatches);
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


    const READEMPHASISTEXT = 5;
    function yy_r5_1($yy_subpatterns)
    {

    $this->token = MarkdownParser::MARKDOWN_EMPHASIS;
    $this->yypopstate();
    }
    function yy_r5_2($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_TEXT;
    }



    function yylex6()
    {
        $tokenMap = array (
              1 => 0,
              2 => 1,
              4 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n]+)|\G((\r?\n)+)|\G(\r?\n)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READCODETEXT');
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
                $r = $this->{'yy_r6_' . $this->token}($yysubmatches);
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


    const READCODETEXT = 6;
    function yy_r6_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_CODETEXT;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    }
    function yy_r6_2($yy_subpatterns)
    {

    // 文本后面可能紧接着两个换行，但也得支持紧跟一个换行的情况
    // @note: 先于linebreak匹配
	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    // return to START state 
    $this->yypopstate();
    }
    function yy_r6_4($yy_subpatterns)
    {

    // 此时换行视为段落起始token
	$this->token = MarkdownParser::MARKDOWN_PARAGRAPH_START;
    // return to START state 
    $this->yypopstate();
    }



    function yylex7()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n\])]+)|\G(\\]\\()|\G(\\))/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READIMAGE');
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
                $r = $this->{'yy_r7_' . $this->token}($yysubmatches);
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


    const READIMAGE = 7;
    function yy_r7_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_IMAGETEXT;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    }
    function yy_r7_2($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_IMAGE_INNER;
    $this->yypushstate(self::READIMAGEPATH);
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    }
    function yy_r7_3($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_IMAGE_END;
    // return to START state 
    $this->yypopstate();
    }



    function yylex8()
    {
        $tokenMap = array (
              1 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n\])]+)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READIMAGEPATH');
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
                $r = $this->{'yy_r8_' . $this->token}($yysubmatches);
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


    const READIMAGEPATH = 8;
    function yy_r8_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_IMAGETEXT;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    // return to READIMAGE state 
    $this->yypopstate();
    }



    function yylex9()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n\])]+)|\G(\\]\\()|\G(\\))/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READLINK');
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
                $r = $this->{'yy_r9_' . $this->token}($yysubmatches);
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


    const READLINK = 9;
    function yy_r9_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_LINKTEXT;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    }
    function yy_r9_2($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_LINK_INNER;
    $this->yypushstate(self::READLINKHREF);
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    }
    function yy_r9_3($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_LINK_END;
    // return to START state 
    $this->yypopstate();
    }



    function yylex10()
    {
        $tokenMap = array (
              1 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([^\r\n\])]+)/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READLINKHREF');
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
                $r = $this->{'yy_r10_' . $this->token}($yysubmatches);
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


    const READLINKHREF = 10;
    function yy_r10_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_LINKTEXT;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    // return to READIMAGE state 
    $this->yypopstate();
    }



    function yylex11()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
            );
        if ($this->counter >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/\G([[\\\\])|\G([^[\\\\])/iS";

        do {
            if ($this->mbstring_overload ? preg_match($yy_global_pattern, substr($this->data, $this->counter), $yymatches) : preg_match($yy_global_pattern,$this->data, $yymatches, null, $this->counter)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        ' an empty string.  Input "' . substr($this->data,
                        $this->counter, 5) . '... state READESCAPE');
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
                $r = $this->{'yy_r11_' . $this->token}($yysubmatches);
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


    const READESCAPE = 11;
    function yy_r11_1($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_ESCAPEDCHAR;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    // return to READIMAGE state 
    $this->yypopstate();
    }
    function yy_r11_2($yy_subpatterns)
    {

	$this->token = MarkdownParser::MARKDOWN_NON_ESCAPEDCHAR;
    // @note: no return to accept current token -- parser will take it -- and cycle to next token 
    // return to READIMAGE state 
    $this->yypopstate();
    }



}

?>


