<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use voku\helper\HtmlMin;

class Document extends DomSection
{
    protected bool  $isRootNode  = true;
    protected array $commonAttrs = [
        'TITLE',
        'HEAD',
        'CSS_LIB',
        'CSS_CUSTOM',
        'JS_HEAD',
        'JS_LIB',
        'JS_CUSTOM',
    ];

    public function __construct()
    {
        $templateString = <<<'CONTENTS'
<!doctype html>
<html lang="zh">
	<head>
	    <title>{:TITLE:}</title>
		{:HEAD:}
		{:CSS_LIB:}
		{:JS_HEAD:}
		{:CSS_CUSTOM:}
	</head>
	<body  {:BODY_ATTR:} >
		{:INNER_CONTENTS:}
		{:JS_LIB:}
		{:JS_CUSTOM:}
	</body>
</html>
CONTENTS;

        parent::__construct($templateString);
    }


    /**
     * 渲染节点计算完之后，返回之前对值做一些处理
     *
     * 在字节点中自己定义后写业务逻辑
     *
     */
    protected function initAfterSectionRender(): void
    {
        parent::initAfterSectionRender();
    }

    /**
     * 渲染完成后的回调，子类中完善处理
     * 对js或者css 做mini 操作
     *
     * @param string $sectionContents
     *
     * @return void
     */

    public function afterRender(string &$sectionContents): void
    {
        if (!$this::$isDebug) {
            $htmlMin = new HtmlMin();

            $htmlMin->doOptimizeViaHtmlDomParser(true);                   // 通过 "HtmlDomParser()" 优化HTML
            $htmlMin->doRemoveComments(true);                             // 移除HTML中的注释
            $htmlMin->doSumUpWhitespace(true);                            // 合并DOM中多余的空格
            $htmlMin->doRemoveWhitespaceAroundTags(true);                 // 移除标签周围的空格
            $htmlMin->doOptimizeAttributes(false);                        // 优化HTML属性

            $htmlMin->doRemoveHttpPrefixFromAttributes(false);            // 移除属性中可选的 "http:" 前缀
            $htmlMin->doRemoveHttpsPrefixFromAttributes(false);           // 移除属性中可选的 "https:" 前缀
            $htmlMin->doKeepHttpAndHttpsPrefixOnExternalAttributes(false);// 保留所有外部链接的 "http:" 和 "https:" 前缀
            $htmlMin->doRemoveDefaultAttributes(false);                   // 移除默认属性
            $htmlMin->doRemoveDeprecatedAnchorName(false);                // 移除过时的锚点跳转
            $htmlMin->doRemoveDeprecatedScriptCharsetAttribute(false);    // 移除过时的脚本字符集属性
            $htmlMin->doRemoveDeprecatedTypeFromScriptTag(false);         // 移除脚本标签中过时的MIME类型
            $htmlMin->doRemoveDeprecatedTypeFromStylesheetLink(false);    // 移除CSS链接中的 "type=text/css"
            $htmlMin->doRemoveDeprecatedTypeFromStyleAndLinkTag(false);   // 移除所有链接和样式中的 "type=text/css"
            $htmlMin->doRemoveDefaultMediaTypeFromStyleAndLinkTag(false); // 移除所有链接和样式中的 "media=all"
            $htmlMin->doRemoveDefaultTypeFromButton(false);               // 移除按钮标签中的 type="submit"
            $htmlMin->doRemoveEmptyAttributes(false);                     // 移除一些空属性
            $htmlMin->doRemoveValueFromEmptyInput(true);                  // 移除空<input>标签中的 'value=""'
            $htmlMin->doSortCssClassNames(false);                         // 对CSS类名进行排序，以获得更好的gzip结果
            $htmlMin->doSortHtmlAttributes(false);                        // 对HTML属性进行排序，以获得更好的gzip结果
            $htmlMin->doRemoveSpacesBetweenTags(false);                   // 移除DOM中更多（更激进的）空格（默认情况下禁用）
            $htmlMin->doRemoveOmittedQuotes(false);                       // 移除引号，例如将 class="lall" 改为 class=lall
            $htmlMin->doRemoveOmittedHtmlTags(false);                     // 移除省略的HTML标签，例如 <p>lall</p> => <p>lall

            //      $htmlMin->doMakeSameDomainsLinksRelative(['example.com']);    // 使某些链接相对化，去掉属性中的域名部分
            $sectionContents = $htmlMin->minify($sectionContents);
        }
        parent::afterRender($sectionContents);
    }

    /**
     * 渲染之前回调
     *
     * 在类中自定义方法拼接属性后，在这个回调中调 setSubsection 设置属性
     *
     * @return void
     */
    public function beforeRender(): void
    {
        parent::beforeRender();
    }
}
