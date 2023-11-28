<?php

    use Coco\htmlBuilder\dom\DoubleTag;

    require '../vendor/autoload.php';

    $dom1 = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {

        $this_->getAttr('class')->addAttr('layui-disabled');
        $this_->getAttr('class')->addAttr('layui-ok');
        $this_->getAttr('style')->setAttrKv('background', '#f0f');

        $this_->getCustomAttrsRegistry()->appendClass("layui-container");
        $this_->getCustomAttrsRegistry()->appendStyleKv("width", '200px');

        $this_->getCustomAttrsRegistry()->appendAttrRawArr([
            "lay-selected",
            "lay-disabled",
        ]);

        $this_->getCustomAttrsRegistry()->appendAttrKvArr([
            "a" => "aa",
            "b" => "bb",
        ]);

        $this_->getCustomAttrsRegistry()->removeAttr('lay-selected');
        $this_->getCustomAttrsRegistry()->removeAttr('a');

//        $this_->getCustomAttrsRegistry()->clearAttrs();
//        $this_->getCustomAttrsRegistry()->clearClass();
//        $this_->getCustomAttrsRegistry()->clearStyle();

    });

    print_r($dom1->render());

