<?php

    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\RawTag;

    require '../vendor/autoload.php';

    //    $dom1 = new DomBlock();

    $dom1 = RawTag::ins();
    $dom2 = RawTag::ins();
    $dom1->appendSubsection('node1',$dom2);
    $dom1->attrRegistry->id = StandardAttr::class;
    $dom1->attrRegistry->id->setKey('id')->setValue('link1');

    print_r((string)$dom1->attrRegistry);