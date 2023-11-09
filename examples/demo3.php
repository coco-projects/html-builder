<?php

    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\DomBlock;

    require '../vendor/autoload.php';

    //    $dom1 = new DomBlock();

    $dom1 = DomBlock::ins();
    $dom2 = DomBlock::ins();
    $dom1->appendSubsection('node1',$dom2);
    $dom1['attrRegistry']->id = StandardAttr::class;
    print_r($dom1);