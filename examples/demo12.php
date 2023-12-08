<?php

    use MatthiasMullie\Minify\JS;

    require '../vendor/autoload.php';

    $js = file_get_contents('test.js');

    $minifier = new JS();
    $minifier->add($js);
    $sectionContents = $minifier->minify();
    echo $sectionContents;