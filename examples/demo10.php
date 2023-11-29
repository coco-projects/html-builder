<?php

    use Coco\htmlBuilder\dom\DoubleTag;

    require '../vendor/autoload.php';

    $dom1 = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {

        $this_->getAttr('class')->addAttr('layui-disabled');
        $this_->getAttr('class')->addAttr('layui-ok');
        $this_->getAttr('style')->setAttrKv('background', '#f0f')->clearValue();


        $this_->attrsRegistry->appendClass("layui-container");
        $this_->attrsRegistry->appendStyleKv("width", '200px');

        $this_->attrsRegistry->appendAttrRawArr([
            "lay-selected",
            "lay-disabled",
        ]);

        $this_->attrsRegistry->appendAttrKvArr([
            "a" => "aa",
            "b" => "bb",
        ]);

        $this_->attrsRegistry->removeAttr('lay-selected');
        $this_->attrsRegistry->removeAttr('a');

        $this_->attrsRegistry->clearAttrs();
        $this_->attrsRegistry->clearClass();
        $this_->attrsRegistry->clearStyle();

        $this_->attrsRegistry->appendClass("layui-container1111");

        $this_->attrsRegistry->appendAttrKvArr([
            "c" => "cc",
        ]);

    });

    print_r($dom1->render());

