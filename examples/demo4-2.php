<?php

    use Coco\htmlBuilder\dom\DoubleTag;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;

    require '../vendor/autoload.php';

    $dom1 = DoubleTag::ins('div')->setInnerContents('hello');

    $dom1->setInnerContents([
        'hello',
        ' ',
        'world',
    ]);

    $dom1->getAttr('class')->setAttrsArray([
        "layer",
        "layer-text",
    ]);

    $dom1->addAttr('data_pid', DataAttr::class);
    $dom1->getAttr('data_pid')->setKey('pid')->setValue(20)->setIsEnable(false);

    DoubleTag::attrRegister('data_uid', DataAttr::class);
    //    $dom1->addAttr('data_uid', DataAttr::class);
    $dom1->getAttr('data_uid')->setAttrKv('uid', 25);

    $dom1->getAttr('id')->setKey('id')->setValue(15);
    $dom1->getAttr('style')->importKv([
        "width"      => "20px",
        "height"     => "120px",
        "background" => "#ccc",
    ]);

    $dom1->getAttr('selected')->setAttrsString('selected');

    print_r($dom1->render());
