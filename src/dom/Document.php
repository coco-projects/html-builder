<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

class Document extends DomSection
{
    protected bool $isRootNode = true;

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
		{:CSS_CUSTOM:}
		{:JS_HEAD:}
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
}
