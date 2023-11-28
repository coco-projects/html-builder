<?php

    use Coco\htmlBuilder\dom\DoubleTag;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;

    require '../vendor/autoload.php';

    $dom1 = DoubleTag::ins('div')->process(function(\Coco\htmlBuilder\dom\DoubleTag $this_, array &$inner) {

        $inner[] = [
            'hello',
            ' ',
            'world',
        ];

        $this_->getAttr('class')->addAttrsArray([
            "layer",
            "layer-text",
        ]);

        $this_->addAttr('data_pid', DataAttr::class);
        $this_->getAttr('data_pid')->setDataKv('pid')->setValue(20)->setIsEnable(false);

        $this_::attrRegister("data_uid", DataAttr::class);
//        $this_->addAttr('data_uid', DataAttr::class);
        $this_->getAttr('data_uid')->setDataKv('uid', 25);

        $this_->getAttr('id')->setKey('id')->setValue(15);
        $this_->getAttr('style')->importKv([
            "width"      => "20px",
            "height"     => "120px",
            "background" => "#ccc",
        ]);

        $this_->getAttr('selected')->setAttrsString('selected');
    });

    print_r($dom1->render());
