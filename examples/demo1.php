<?php

    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;

    require '../vendor/autoload.php';

    $attr1 = ClassAttr::ins([
        "layer",
        "layer-text",
    ]);
    echo $attr1;
    echo PHP_EOL;

    $attr2 = DataAttr::ins('parentid', '1');
    echo $attr2;
    echo PHP_EOL;

    $attr3 = RawAttr::ins('layer-unselected');
    echo $attr3;
    echo PHP_EOL;

    $attr4 = StandardAttr::ins('id', 'div1');
    echo $attr4;
    echo PHP_EOL;

    $attr5 = StyleAttr::ins([
        "width"  => "20px",
        "height" => "120px",
    ]);
    echo $attr5->getAttrsString();
    echo PHP_EOL;
