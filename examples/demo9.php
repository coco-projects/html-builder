<?php

    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\SingleTag;

    require '../vendor/autoload.php';

    DomBlock::$var['name'] = '哈哈哈哈哈';

    $dom1 = Document::ins()->inner(function(\Coco\htmlBuilder\dom\Document $this_, array &$inner) {
        $this_->appendSubsection('TITLE', DomBlock::$var['name']);

        $this_->appendSubsection('INNER_CONTENTS', '(hello111)');

        $this_->appendSubsectionWithoutEval('INNER_CONTENTS', 'aaa{:hello1:}bbb');
        $this_->prependSubsectionWithoutEval('INNER_CONTENTS', 'ccc{:hello2:}ddd');

        $this_->appendSubsection('hello1', '<hellohello1>');
        $this_->appendSubsection('hello2', '<hellohello2>');

    });

    print_r($dom1->render());

