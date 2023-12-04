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
        $this_->appendSubsection('INNER_CONTENTS', '({:hello1000:})');

        $t = DoubleTag::ins('div');

        $this_->appendSubsectionWithoutEval('INNER_CONTENTS', $t->setInnerContents('div1'));
        $this_->appendSubsectionWithoutEval('INNER_CONTENTS', '(aaa{:hello1:}bbb)');
        $this_->appendSubsectionWithoutEval('INNER_CONTENTS', '(ccc{:hello1:}ddd)');

        $this_->prependSubsectionWithoutEval('INNER_CONTENTS', '(eee{:hello2:}fff)');

//        $this_->setSubsectionWithoutEval('INNER_CONTENTS', '（ggg{:hello2:}hhh）');

        $this_->appendSubsection('hello1', '<hello11111>');
        $this_->appendSubsection('hello2', '<hello22222>');

        $this_->prependToNode('1');
        $this_->prependToNode('2');
        $this_->prependToNode('3');


        $this_->appendToNode('a');
        $this_->appendToNode('b');
        $this_->appendToNode('c');
    });

    print_r($dom1->render());

