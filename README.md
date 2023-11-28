
# html builder

##### Document Object Model (DOM) document generator, each attribute of each DOM node contains corresponding API operations.

---

## Installation

You can install the package via composer:

```bash
composer require coco-project/html-builder
```

> For more examples, please refer to the "examples" folder.


### Here's a quick example:

```php
<?php

    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use Coco\htmlBuilder\dom\SingleTag;
    use Coco\htmlBuilder\dom\tags\Meta;

    require '../vendor/autoload.php';

    DomBlock::$var['title'] = 'Bootstrap demo';
    DomBlock::$isDebug      = true;

    $html = Document::ins()->process(function(Document $this_, array &$inner) {

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

            SingleTag::ins('meta')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('name')->setAttrKv('name', 'keywords');
                $this_->getAttr('content')->setAttrKv('content', '关键词1, 关键词2, 关键词3');
            }),

        ]);

        $this_->setSubsection('CSS_LIB', [
            SingleTag::ins('link')->process(function(SingleTag $this_, array &$inner) {
                $this_->getAttr('href')->setAttrKv('href', '//cdn.staticfile.org/layui/2.8.18/css/layui.css');
                $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            }),
        ]);

        $this_->setSubsection('JS_LIB', [
            DoubleTag::ins('script')->process(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('src')->setAttrKv('src', '//unpkg.com/layui@2.8.18/dist/layui.js');
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            }),
        ]);

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

        $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
            $this_->getAttr('class')->addAttrsArray([
                "layui-container",
            ]);

            $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('layui-row');

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $inner[] = 'column 1';
                });

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $inner[] = 'column 2';
                });

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $this_->getAttr('selected')->setAttrsString('selected');
                    $this_->getAttr('disabled')->setAttrsString('disabled');

                    $this_->addAttr('layui-encode', \Coco\htmlBuilder\attrs\RawAttr::class);
                    $this_->getAttr('layui-encode')->setAttrsString('layui-encode');
                    $inner[] = 'column 3';
                });
            });

            $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('layui-row');

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs4')->addAttr('col-12');

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
                        $this_->setIsHidden(true);

                        $inner[] = 'hello h666';
                    });

                });

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
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

                    $this_->baseCustomAttrsRegistry->appendClass('layui-show');
                    $this_->baseCustomAttrsRegistry->appendClassArr([
                        'layui-all',
                    ]);

                    $this_->getCustomAttrsRegistry()->appendStyleKv('color', '#0f0');
                    $this_->getCustomAttrsRegistry()->appendStyleKvArr([
                        "background" => "#ccc",
                    ]);

                    $this_->getCustomAttrsRegistry()->appendAttrRaw('layer-enable');
                    $this_->getCustomAttrsRegistry()->appendAttrRawArr([
                        'layer-border-red',
                    ]);
                    $this_->getCustomAttrsRegistry()->appendAttrKv('tid', 250);
                    $this_->getCustomAttrsRegistry()->appendAttrKvArr([
                        "margin" => 20,
                    ]);

                });
            });
        });
    });

    print_r($html->render());

```
### result

```html
<!doctype html>
<html lang="zh">
	<head>
		<title>Bootstrap demo</title>
		<meta charset="utf-8"/>
		<meta class=" " style=" "/>
		<meta class=" " style=" "/>
		<meta class=" " style=" " name="keywords" content="关键词1, 关键词2, 关键词3"/>
		<link class=" " style=" " href="//cdn.staticfile.org/layui/2.8.18/css/layui.css" rel="stylesheet" crossorigin="anonymous"/>

		<style class=" " style=" ">    *{
			padding : 0;
			margin  : 0;
		}</style>
	</head>
	<body>
		<div class="layui-container " style=" ">
			<div class="layui-row " style=" ">
				<div class="layui-col-xs4 " style=" ">column 1</div>
				<div class="layui-col-xs4 " style=" ">column 2</div>
				<div class="layui-col-xs4 " style=" " selected disabled layui-encode>column 3</div>
			</div>
			<div class="layui-row " style=" ">
				<div class="layui-col-xs4 col-12 " style=" "><h1 class=" " style=" ">hello h1</h1>
					<h2 class=" " style=" ">hello h2</h2>
					<h3 class=" " style=" ">hello h3</h3><h4 class=" " style=" ">hello h4</h4>
					<h5 class=" " style=" ">hello h5</h5></div>
				<div class="layer layer-text layer-padding-1 layui-show layui-all" style="width:20px;height:120px; color:#0f0;background:#ccc;" data-uid="25" id="15" selected layer-enable layer-border-red tid="250" margin="20"></div>
			</div>
		</div>
		<script class=" " style=" " src="//unpkg.com/layui@2.8.18/dist/layui.js" crossorigin="anonymous"></script>
		<script class=" " style=" ">    layui.use(function () {
			let $     = layui.$;
			let layer = layui.layer;

			layer.alert("hello");
		});</script>
	</body>
</html>


```

## Testing

``` bash
composer test
```

## License

---

MIT
