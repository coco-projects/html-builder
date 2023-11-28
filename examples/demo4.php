<?php

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\DoubleTag;

    require '../vendor/autoload.php';

    $r = AttrRegistry::ins();

    $r->initManager('id', StandardAttr::class)->initManager('target', StandardAttr::class)
        ->initManager('raw', RawAttr::class)->initManager('class', ClassAttr::class)
        ->initManager('data-pid', DataAttr::class)->initManager('style', StyleAttr::class);

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
    ])->removeKv('width');

    $r->getManager('raw')->setAttrsString('unselected');

    $r->getManager('id')->setKey('id')->setValue('link3');

    $r->type = StandardAttr::class;
    $r->type->setKey('type')->setValue('text');

    //    echo $r;

    $dom1 = DoubleTag::ins();
    $dom1->appendSubsection('TAG__NAME', 'div');
    $dom1->appendSubsection('ATTRS', $r);
    $dom1->appendInnerContents('hello');

    print_r($dom1->render());
