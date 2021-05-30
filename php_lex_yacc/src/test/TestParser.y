/**
* TestFileParser
*
* This is the test file parser
* 
* @author hudamin@baidu.com 
*/
%name TEST_
%declare_class {class TestParser}
%include_class
{
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

} 


%token_prefix TEST_

%parse_accept
{
    $this->successful = !$this->internalError;
    $this->internalError = false;
    $this->retvalue = $this->_retvalue;
    //echo $this->retvalue."\n\n";
}

%syntax_error
{
	$this->error(
        "syntax error: [yymajor: $yymajor, tokenvalue: " . $this->lex->value 
        . ", line: " . $this->lex->line . "]" 
		. " stateno: " . $this->yystack[$this->yyidx]->stateno
        );
    $this->internalError = true;
    $this->yymajor = $yymajor;
    // $this->compiler->trigger_config_file_error();
}

%stack_overflow
{
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
}



/**
 * ===================================================
 * ## reduce rule block 
 */

start ::= a(A). {
    $this->log(A);
}

a(res) ::= CHAR_A(A) a(B). {
    res = A . B;
}

a(res) ::= . {
    res = '';
}


