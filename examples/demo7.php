<?php

    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use Coco\htmlBuilder\dom\SingleTag;
    use Coco\htmlBuilder\dom\tags\Meta;

    require '../vendor/autoload.php';

    DomBlock::$var['title'] = 'layui demo';
    DomBlock::$isDebug      = false;

    $html = Document::ins()->inner(function(Document $this_, array &$inner) {

        $this_->appendSubsection('TITLE', DomBlock::$var['title']);

        $this_->metaRaw('<meta charset="utf-8" />');

        $this_->metaKv([
            "name"    => "viewport",
            "content" => "width=device-width, initial-scale=1",
        ]);

        $this_->metaKv([
            "name"    => "description",
            "content" => "这是网页的描述",
        ]);

        $this_->metaKv([
            "name"    => "keywords",
            "content" => "keyword1, keyword2, keyword3",
        ]);

        $this_->cssLib('//cdn.staticfile.org/layui/2.8.18/css/layui.css');
//        $this_->jsHead('//unpkg.com/layui@2.8.18/dist/layui.js');
        $this_->jsLib('//unpkg.com/layui@2.8.18/dist/layui.js');

        $this_->jsCustomRawCode(<<<AAA
    layui.use(function () {
        let $     = layui.$;
        let layer = layui.layer;
    
        layer.alert('hello')
    });
AAA
        );

        $this_->cssCustomRawCode(<<<AAA
    *{
        padding:0;
        margin: 0;
    }
AAA
        );

        $inner[] = '<hr>';
        $inner[] = '<hr>';
        $inner[] = '<hr>';

    })->inner(function(Document $this_, array &$inner) {

        $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
            $this_->getAttr('class')->addAttrsArray([
                "layui-container",
            ]);

            $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('layui-row');

                $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $inner[] = 'column 1';
                });

                $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $inner[] = 'column 2';
                });

                $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $inner[] = 'column 3';
                });
            });

            $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('layui-row');

                $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4')->addAttr('col-12');

                    $inner[] = DoubleTag::ins('h1')->inner(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h1';
                    });

                    $inner[] = DoubleTag::ins('h2')->inner(function(DoubleTag $this_, array &$inner) {
                        $inner[] = ['hello h2'];
                    });

                    $inner[] = DoubleTag::ins('h3')->inner(function(DoubleTag $this_, array &$inner) {
                        $inner[] = function() {
                            return 'hello h3';
                        };
                    });

                    $inner[] = DoubleTag::ins('h4')->inner(function(DoubleTag $this_, array &$inner) {
                        $this_->setIsHidden(true);

                        $inner[] = 'hello h4';
                    });

                    $inner[] = DoubleTag::ins('h5')->inner(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h5';
                    });

                    $inner[] = DoubleTag::ins('h6')->inner(function(DoubleTag $this_, array &$inner) {

                        $inner[] = 'hello h666';
                    });

                });
            });
        });
    });

    print_r($html->render());


    /*
<!DOCTYPE html>
<html lang="zh">
	<head><title>layui demo</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" test-attr1="" test-attr2="">
		<meta name="description" content="这是网页的描述">
		<meta name="keywords" content="keyword1, keyword2, keyword3">
		<link href="//cdn.staticfile.org/layui/2.8.18/css/layui.css" rel="stylesheet" crossorigin="anonymous">
		<style>*{
			padding : 0;
			margin  : 0
		}</style>
	</head>
	<body>
		<hr>
		<hr>
		<hr>
		<div class="layui-container">
			<div class="layui-row">
				<div class="layui-col-xs4">column 1</div>
				<div class="layui-col-xs4">column 2</div>
				<div class="layui-col-xs4">column 3</div>
			</div>
			<div class="layui-row">
				<div class="layui-col-xs4 col-12">
					<h1>hello h1</h1>
					<h2>hello h2</h2>
					<h3>hello h3</h3>
					<h5>hello h5</h5>
					<h6>hello h666</h6>
				</div>
			</div>
		</div>
		<script src="//unpkg.com/layui@2.8.18/dist/layui.js" crossorigin="anonymous"></script>
		<script>
			layui.use(function () {
				let $     = layui.$;
				let layer = layui.layer;
				layer.alert("hello");
			});
		</script>
	</body>
</html>
     */