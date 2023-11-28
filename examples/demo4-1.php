<?php

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;

    require '../vendor/autoload.php';

    $r = AttrRegistry::ins();

    $r->href     = StandardAttr::class;
    $r->src      = StandardAttr::class;
    $r->alt      = StandardAttr::class;
    $r->width    = StandardAttr::class;
    $r->height   = StandardAttr::class;
    $r->action   = StandardAttr::class;
    $r->method   = StandardAttr::class;
    $r->type     = StandardAttr::class;
    $r->name     = StandardAttr::class;
    $r->value    = StandardAttr::class;
    $r->rows     = StandardAttr::class;
    $r->cols     = StandardAttr::class;
    $r->for      = StandardAttr::class;
    $r->target   = StandardAttr::class;
    $r->selected = RawAttr::class;
    $r->disabled = RawAttr::class;
    $r->class    = ClassAttr::class;
    $r->style    = StyleAttr::class;
    $r->id       = StandardAttr::class;
    $r->data_pid = DataAttr::class;

    $r->id->setKey('id')->setValue('link1');

    $r->target->setKey('target')->setValue('_blank')->setIsEnable(!false);

    $r->class->setAttrsArray([
        'layer',
        'layer-text',
    ])->removeAttr('layer-text');

    $r->data_pid->setKey('pid')->setValue(20);

    $r->style->importKv([
        "width"  => "20px",
        "height" => "120px",
    ]);

    $r->selected->setAttrsString('selected');

    $r->id->setKey('id')->setValue('link3');

    $r->type = StandardAttr::class;
    $r->type->setKey('type')->setValue('text');

    //    echo $r;

    $dom1 = \Coco\htmlBuilder\dom\DoubleTag::ins();
    $dom1->appendSubsection('TAG__NAME', 'div');
    $dom1->appendSubsection('ATTRS', $r);
    $dom1->setInnerContents('hello');

    print_r($dom1->render());
