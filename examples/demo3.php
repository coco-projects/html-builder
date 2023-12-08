<?php

    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\RawTag;
    use Coco\htmlBuilder\dom\tags\Div;

    require '../vendor/autoload.php';

    //    $dom1 = new DomBlock();

    $dom1 = Div::ins();
    $dom2 = Div::ins();
    $dom1->setInnerContents($dom2);

    $dom1->addAttr('id', StandardAttr::class);
    $dom1->getAttr('id')->setKey('id')->setValue('link1');

    print_r($dom1->render());