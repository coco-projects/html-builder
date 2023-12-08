<?php

    require '../vendor/autoload.php';

    $js = file_get_contents('test.js');

//    $minifiedCode = \JShrink\Minifier::minify($js);
    $minifiedCode = \JShrink\Minifier::minify($js, ['flaggedComments' => true]);

    echo $minifiedCode;