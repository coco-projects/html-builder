<?php

    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use Coco\htmlBuilder\dom\SingleTag;

    require '../vendor/autoload.php';

    DomBlock::$var['title'] = 'Bootstrap demo';

    $html = Document::ins()->process(function(Document $this_, array &$inner) {

        $this_->appendSubsection('TITLE', DomBlock::$var['title']);
        $this_->appendSubsection('TITLE', ' - test');

        $this_->appendSubsection('HEAD', [

            SingleTag::ins('meta')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('charset')->setAttrKv('charset', 'utf-8');
            }),

            SingleTag::ins('meta')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('name')->setAttrKv('name', 'viewport');
                $this_->getAttr('content')->setAttrKv('content', 'width=device-width, initial-scale=1');
            }),

            SingleTag::ins('meta')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('name')->setAttrKv('name', 'description');
                $this_->getAttr('content')->setAttrKv('content', '这是网页的描述');
            }),

            SingleTag::ins('meta')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('name')->setAttrKv('name', 'keywords');
                $this_->getAttr('content')->setAttrKv('content', '关键词1, 关键词2, 关键词3');
            }),
        ]);

        $this_->appendSubsection('CSS_LIB', [
            SingleTag::ins('link')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('href')
                    ->setAttrKv('href', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
                $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            }),
        ]);

        $this_->appendSubsection('JS_LIB', [
            DoubleTag::ins('script')->process(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('src')
                    ->setAttrKv('src', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js');
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            }),
        ]);

        $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
            $this_->getAttr('class')->setAttrsArray([
                "container",
                "text-center",
            ]);

            $this_->appendParentSection('CSS_LIB', [
                SingleTag::ins('link')->process(function(SingleTag $this_, array &$inner) {
                    $this_->getAttr('href')->setAttrKv('href', 'https://baidu.com/style.css');
                    $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);

            $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('row');

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('col');
                    $inner[] = 'column 1';
                });

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('col');
                    $inner[] = 'column 2';
                });

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('col');
                    $inner[] = 'column 3';
                });
            });

            $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('row');

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('col')->addAttr('col-12');

                    $inner[] = DoubleTag::ins('h1')->process(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h1';
                    });

                    $inner[] = DoubleTag::ins('h2')->process(function(DoubleTag $this_, array &$inner) {
                        $inner[] = ['hello h2'];
                    });

                    $inner[] = DoubleTag::ins('h3')->process(function(DoubleTag $this_, array &$inner) {
                        $inner[] = function() {
                            return 'hello h3';
                        };
                    });

                    $inner[] = DoubleTag::ins('h4')->process(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h4';
                    });

                    $inner[] = DoubleTag::ins('h5')->process(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h5';
                    });

                    $inner[] = DoubleTag::ins('h6')->process(function(DoubleTag $this_, array &$inner) {
                        $inner[] = 'hello h6';
                    });

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