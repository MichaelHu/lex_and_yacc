/**
* MarkdownFileParser
*
* This is the markdown file parser
* 
* @author hudamin@baidu.com 
*/
%name MARKDOWN_
%declare_class {class MarkdownParser}
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


%token_prefix MARKDOWN_

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

start ::= markdownfile(markdown). {
    // $this->log(markdown);
}

/**
 * ===================================================
 * ## markdownfile 
 * @note: docinfo -- must supply, must go ahead of paragraphs
 */
markdownfile(res) ::= docinfo(A) paragraphs(B). {
    // $this->log("docinfo: " . A);
    res = A . B;
}

/**
 * ===================================================
 * ## docinfo
 */
docinfo(res) ::= docinfo_line(A) otherdocinfo(B). {
    res = A . B; 
}

otherdocinfo(res) ::= docinfo_line(A) otherdocinfo(B). {
    res = A . B; 
}

otherdocinfo(res) ::= . {
    res = ''; 
}

docinfo_line(res) ::= DOCINFO_START TEXT(A) docinfo_lineend. {
    $this->log("docinfo_line: " . A);

    $this->addBlock(array(
        'type' => 'docinfo'
        ,'content' => A
    ));

    res = A; 
}

docinfo_lineend ::= DOCINFOLINE_END. {
}

docinfo_lineend ::= . {
}

/**
 * ===================================================
 * ## paragraphs
 */
paragraphs(res) ::= paragraphs(A) paragraph(B). {
    res = A . B;
}

paragraphs(res) ::= . {
    res = '';
}

/**
 * ===================================================
 * ## paragraph
 */
paragraph(res) ::= PARAGRAPH_START text(A). {
    $this->log("paragraph: " . A);

    $this->addBlock(array(
        'type' => 'paragraph'
        ,'content' => A
    ));

    res = A;
}

paragraph(res) ::= PARAGRAPH_START codelines(A). {
    res = A;
}

paragraph(res) ::= PARAGRAPH_START ul(A). {
    res = A;
}

paragraph(res) ::= PARAGRAPH_START ol(A). {
    res = A;
}

paragraph(res) ::= PARAGRAPH_START headline(A). {
    res = A;
}

paragraph(res) ::= PARAGRAPH_START image(A). {
    res = A;
}

paragraph(res) ::= PARAGRAPH_START emptytext. {
    res = '';
}

emptytext(res) ::= . {
    // empty paragraph, especially empty lines at the end of file
    res = '';
}

/**
 * ===================================================
 * ## text
 * @note: 引入text_other目的是为了解决text ::= . 与 emptytext(res) ::= . 的冲突
 * @note: 不同于image，link是inline的
 */
text(res) ::= emphasis_text(A) text_other(B). {
    res = A . B;
}

text(res) ::= link(A) text_other(B). {
    res = A . B;
}

text(res) ::= ASTERISK(A) text_other(B). {
    res = A . B;
}

text(res) ::= escape(A) text_other(B). {
    res = A . B;
}

text(res) ::= TEXT(A) text_other(B). {
    res = A . B;
}

text_other(res) ::= emphasis_text(A) text_other(B). {
    res = A . B;
}

text_other(res) ::= link(A) text_other(B). {
    res = A . B;
}

text_other(res) ::= ASTERISK(A) text_other(B). {
    res = A . B;
}

text_other(res) ::= escape(A) text_other(B). {
    res = A . B;
}

text_other(res) ::= TEXT(A) text_other(B). {
    res = A . B;
}

text_other(res) ::= . {
    res = '';
}

/**
 * ===================================================
 * ## emphasis_text
 */
emphasis_text(res) ::= EMPHASIS TEXT(A) EMPHASIS. {

    $formated_text = '+@@__EMPHASIS__@@' 
                    . A 
                    .'-@@__EMPHASIS__@@';

    $this->log("emphasis: " . $formated_text);

    $this->addBlock(array(
        'type' => 'emphasis'
        ,'content' => $formated_text
    ));

    res = $formated_text;
}

/**
 * ===================================================
 * ## link
 */
link(res) ::= LINK_START LINKTEXT(A) LINK_INNER LINKTEXT(B) LINK_END. {
    $formated_text = '+@@__LEFT__@@' 
                    . 'a href="'
                    . B
                    . '"'
                    .'-@@__RIGHT__@@'
                    . A 
                    .'+@@__LEFT__@@'
                    . '/a'
                    .'-@@__RIGHT__@@';

    $this->log("link: " . $formated_text);

    $this->addBlock(array(
        'type' => 'link'
        ,'content' => $formated_text
    ));

    res = $formated_text;
}

/**
 * ===================================================
 * ## escape
 */
escape(res) ::= BACKSLASH ESCAPEDCHAR(A). {
    // @note: [和\需要转义

    $formated_text = A;

    $this->log("escape: " . $formated_text);

    $this->addBlock(array(
        'type' => 'escape'
        ,'content' => $formated_text
    ));

    res = $formated_text;
}

escape(res) ::= BACKSLASH NON_ESCAPEDCHAR(A). {
    $formated_text = '\\' . A;

    $this->log("non_escape: " . $formated_text);

    $this->addBlock(array(
        'type' => 'non_escape'
        ,'content' => $formated_text
    ));

    res = $formated_text;
}

/**
 * ===================================================
 * ## codelines
 */
codelines(res) ::= codeline(A) othercodelines(B). {
    res = A . B;
}

othercodelines(res) ::= codeline(A) othercodelines(B). {
    res = A . B;
}

othercodelines(res) ::= . {
    res = '';
}

codeline(res) ::= CODELINE_START(A) code(B). {
    res = A . B;
}

code(res) ::= CODETEXT(A). {
    $this->log("code :" . A);

    $this->addBlock(array(
        'type' => 'code'
        ,'content' => A
    ));

    res = A;
}

code(res) ::= . {
    // @note: 支持空代码行
    $this->log("code : ");

    $this->addBlock(array(
        'type' => 'code'
        ,'content' => ''
    ));

    res = '';
}

/**
 * ===================================================
 * ## ul
 */
ul(res) ::= UL_START ul_li(A) remain_ul(B). {
    res = A . B;
}

remain_ul(res) ::= UL_START ul_li(A) remain_ul(B). {
    res = A . B;
}

remain_ul(res) ::= . {
    res = '';
}

ul_li(res) ::= emphasis_text(A) ul_text_other(B). {
    $this->log("ul: " . A . B);

    $this->addBlock(array(
        'type' => 'ul'
        ,'content' => A . B
    ));

    res = A . B;
}

ul_li(res) ::= ASTERISK(A) ul_text_other(B). {
    $this->log("ul: " . A . B);

    $this->addBlock(array(
        'type' => 'ul'
        ,'content' => A . B
    ));

    res = A . B;
}

ul_li(res) ::= TEXT(A) ul_text_other(B). {
    $this->log("ul: " . A . B);

    $this->addBlock(array(
        'type' => 'ul'
        ,'content' => A . B
    ));

    res = A . B;
}

ul_text_other(res) ::= emphasis_text(A) ul_text_other(B). {
    res = A . B;
}

ul_text_other(res) ::= ASTERISK(A) ul_text_other(B). {
    res = A . B;
}

ul_text_other(res) ::= TEXT(A) ul_text_other(B). {
    res = A . B;
}

ul_text_other(res) ::= . {
    res = '';
}

/**
 * ===================================================
 * ## ol
 */
ol(res) ::= OL_START ol_li(A) remain_ol(B). {
    res = A . B;
}

remain_ol(res) ::= OL_START ol_li(A) remain_ol(B). {
    res = A . B;
}

remain_ol(res) ::= . {
    res = '';
}

ol_li(res) ::= emphasis_text(A) ol_text_other(B). {
    $this->log("ol: " . A . B);

    $this->addBlock(array(
        'type' => 'ol'
        ,'content' => A . B
    ));

    res = A . B;
}

ol_li(res) ::= ASTERISK(A) ol_text_other(B). {
    $this->log("ol: " . A . B);

    $this->addBlock(array(
        'type' => 'ol'
        ,'content' => A . B
    ));

    res = A . B;
}

ol_li(res) ::= TEXT(A) ol_text_other(B). {
    $this->log("ol: " . A . B);

    $this->addBlock(array(
        'type' => 'ol'
        ,'content' => A . B
    ));

    res = A . B;
}

ol_text_other(res) ::= emphasis_text(A) ol_text_other(B). {
    res = A . B;
}

ol_text_other(res) ::= ASTERISK(A) ol_text_other(B). {
    res = A . B;
}

ol_text_other(res) ::= TEXT(A) ol_text_other(B). {
    res = A . B;
}

ol_text_other(res) ::= . {
    res = '';
}


/**
 * ===================================================
 * ## headline
 */
headline(res) ::= HEADLINE_START(A) TEXT(B). {
    $this->log("headline level " . strlen(rtrim(A)) . ": " . B);

    $this->addBlock(array(
        'type' => 'headline'
        ,'level' => strlen(rtrim(A))
        ,'content' => B
    ));

    res = B;
}

/**
 * ===================================================
 * ## image
 */
image(res) ::= IMAGE_START IMAGETEXT(A) IMAGE_INNER IMAGETEXT(B) IMAGE_END. {
    $alt_text = A;
    $path = '';
    $title = $alt_text;
    $arr = preg_split('/ +/', B);

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

    res = $content;
}




