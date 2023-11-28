<?php

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;

    require '../vendor/autoload.php';



    $r = AttrRegistry::ins();

    $r->initManager('id', StandardAttr::class)
        ->initManager('target', StandardAttr::class)
        ->initManager('raw', RawAttr::class)
        ->initManager('class', ClassAttr::class)
        ->initManager('data-pid', DataAttr::class)
        ->initManager('style', StyleAttr::class);

    $r->getManager('id')->setKey('id')->setValue('link1');

    $r->getManager('target')->setKey('target')->setValue('_blank');

    $r->getManager('class')->setAttrsArray([
        'layer',
        'layer-text',
    ])->removeAttr('layer-text');

    $r->getManager('data-pid')->setKey('pid')->setValue(20);

    $r->getManager('style')->importKv([
        "width"  => "20px",
        "height" => "120px",
    ]);

    $r->getManager('raw')->setAttrsString('unselected');

    $r->getManager('id')->setKey('id')->setValue('link3');

//    print_r($r);
    echo PHP_EOL;
    echo $r->evalAttrsToString();
