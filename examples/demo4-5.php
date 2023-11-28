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

    $dom1 = DoubleTag::ins('div')->process(function(\Coco\htmlBuilder\dom\DoubleTag $this_, array &$inner) {

        $s = SingleTag::ins('hr');

        $d1 = $this_->getCopy();

        $this_->getAttr('class')->addAttrsArray([
            "layer",
            "layer-text",
        ]);
        $d1->getAttr('class')->addAttrsArray([
            "aaa",
            "bbb",
        ]);

        $inner[][][][][] = [
            'hello1',
            $s,
            $d1,
            function() {
                return [
                    "(111)",
                    "(222)",
                ];
            },
            function() {
                return function() {
                    return [
                        "(333)",
                        "(444)",
                    ];
                };
            },

            [
                'hello4',
                $s,
                'hello5',
            ],
            $s,

            $s,
        ];
    });

    print_r($dom1->render());
    //    print_r($dom1->toArrayAll());
    //        print_r($dom1->toJson());
    //        print_r($dom1->toRaw());

