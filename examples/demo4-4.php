<?php

    use Coco\htmlBuilder\dom\DoubleTag;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\SingleTag;

    require '../vendor/autoload.php';

    $dom1 = SingleTag::ins('hr')->process(function(SingleTag $this_, array &$inner) {
        $this_->setIsHidden(!true);

        $this_->getAttr('class')->addAttrsArray([
            "layer",
        ]);
        $this_->getAttr('class')->addAttr("layer-text");

        $this_->getAttrRegistry()->getManagerByLabel('class')->addAttr('layer-padding-1');

        $this_->addAttr('data_pid', DataAttr::class);
        $this_->getAttr('data_pid')->setDataKv('pid')->setValue(20)->setIsEnable(false);

        $this_->addAttr('data_uid', DataAttr::class);
        $this_->getAttr('data_uid')->setDataKv('uid', 25);

        $this_->getAttr('id')->setKey('id')->setValue(15);
        $this_->getAttr('style')->importKv([
            "width"  => "20px",
            "height" => "120px",
        ]);

        $this_->getAttr('selected')->setAttrsString('selected');

        $this_->baseCustomAttrsRegistry->appendClass('layui-show');
        $this_->baseCustomAttrsRegistry->appendClassArr([
            'layui-all',
        ]);

        $this_->getCustomAttrsRegistry()->appendStyleKv('color', '#0f0');
        $this_->getCustomAttrsRegistry()->appendStyleKvArr([
            "background" => "#ccc",
        ]);

        $this_->getCustomAttrsRegistry()->appendAttrRaw('layer-enable');
        $this_->getCustomAttrsRegistry()->appendAttrRawArr([
            'layer-border-red',
        ]);
        $this_->getCustomAttrsRegistry()->appendAttrKv('tid', 250);
        $this_->getCustomAttrsRegistry()->appendAttrKvArr([
            "margin" => 20,
        ]);

//        <hr class="layer layer-text layer-padding-1 layui-show layui-all" data-uid="25" id="15" style="width:20px;height:120px; color:#0f0;background:#ccc;" selected layer-enable layer-border-red tid="250" margin="20" />

    });

    print_r($dom1->render());
