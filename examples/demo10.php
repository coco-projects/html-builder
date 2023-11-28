<?php

    use Coco\htmlBuilder\dom\DoubleTag;

    require '../vendor/autoload.php';

    $dom1 = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
        $this_->getAttr('class')->addAttr('layui-disabled');
        $this_->getAttr('class')->addAttr('layui-ok');

        $this_->getCustomAttrsRegistry()->appendClass("layui-container");
        $this_->getCustomAttrsRegistry()->appendStyleKv("width", '200px');
        $this_->getCustomAttrsRegistry()->appendAttrRaw("lay-selected");

        $this_->getCustomAttrsRegistry()->appendAttrKvArr([
            "a" => "aa",
            "b" => "bb",
        ]);

    });

    print_r($dom1->render());

