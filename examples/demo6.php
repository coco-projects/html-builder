<?php

    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use Coco\htmlBuilder\dom\SingleTag;
    use Coco\htmlBuilder\dom\tags\Meta;

    require '../vendor/autoload.php';

    DomBlock::$var['title'] = 'Bootstrap demo';
    DomBlock::$isDebug      = !true;

    $html = Document::ins()->inner(function(Document $this_, array &$inner) {

        $this_->appendSubsection('TITLE', DomBlock::$var['title']);

        $this_->appendSubsection('HEAD', [

            '<meta charset="utf-8" />',

            Meta::ins([
                "name"    => "viewport",
                "content" => "width=device-width, initial-scale=1",
            ]),

            Meta::ins([
                "name"    => "description",
                "content" => "这是网页的描述",
            ]),

            SingleTag::ins('meta')->inner(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('name')->setAttrKv('name', 'keywords');
                $this_->getAttr('content')->setAttrKv('content', '关键词1, 关键词2, 关键词3');
            }),

        ]);

        $this_->setSubsection('CSS_LIB', [
            SingleTag::ins('link')->inner(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('href')->setAttrKv('href', '//cdn.staticfile.org/layui/2.8.18/css/layui.css');
                $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            }),
        ]);

        $this_->setSubsection('JS_LIB', [
            DoubleTag::ins('script')->inner(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('src')->setAttrKv('src', '//unpkg.com/layui@2.8.18/dist/layui.js');
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            }),
        ]);

        $this_->jsCustomRawCode(<<<AAA
    layui.use(function () {
        let $     = layui.$;
        let layer = layui.layer;
    
        layer.alert('hello');
        
        (function () {
           
        })();
        
        (function () {
           
        })();
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
                    $this_->getAttr('selected')->setAttrsString('selected');
                    $this_->getAttr('disabled')->setAttrsString('disabled');

                    $this_->addAttr('layui-encode', \Coco\htmlBuilder\attrs\RawAttr::class);
                    $this_->getAttr('layui-encode')->setAttrsString('layui-encode');
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
                        $inner[] = 'hello h4';
                    });

                    $inner[] = DoubleTag::ins('h5')->inner(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h5';
                    });

                    $inner[] = DoubleTag::ins('h6')->inner(function(DoubleTag $this_, array &$inner) {
                        $this_->setIsHidden(true);

                        $inner[] = 'hello h666';
                    });

                });

                $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
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

                    $this_->attrsRegistry->appendClass('layui-show');
                    $this_->attrsRegistry->appendClassArr([
                        'layui-all',
                    ]);

                    $this_->attrsRegistry->appendStyleKv('color', '#0f0');
                    $this_->attrsRegistry->appendStyleKvArr([
                        "background" => "#ccc",
                    ]);

                    $this_->attrsRegistry->appendAttrRaw('layer-enable');
                    $this_->attrsRegistry->appendAttrRawArr([
                        'layer-border-red',
                    ]);
                    $this_->attrsRegistry->appendAttrKv('tid', 250);
                    $this_->attrsRegistry->appendAttrKvArr([
                        "margin" => 20,
                    ]);

                });
            });
        });
    });

    print_r($html->render());


    /*
<!doctype html>
<html lang="zh">
	<head>
		<title>Bootstrap demo - test</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="description" content="这是网页的描述"/>
		<meta name="keywords" content="关键词1, 关键词2, 关键词3"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
		<link href="https://baidu.com/style.css" rel="stylesheet" crossorigin="anonymous"/>
	</head>
	<body>
		<div class="container text-center">
			<div class="row">
				<div class="col">column 1</div>
				<div class="col">column 2</div>
				<div class="col">column 3</div>
			</div>
			<div class="row">
				<div class="col col-12">
					<h1>hello h1</h1>
					<h2>hello h2</h2>
					<h3>hello h3</h3>
					<h4>hello h4</h4>
					<h5>hello h5</h5>
					<h6>hello h6</h6>
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	</body>
</html>
     */