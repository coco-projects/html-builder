<?php

    use Coco\examples\ComponentTest1;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;

    require '../vendor/autoload.php';

    DomBlock::$var['title'] = 'layui demo';
    DomBlock::$isDebug      = false;

    $html = Document::ins()->process(function(Document $this_, array &$inner) {

        $this_->appendSubsection('TITLE', DomBlock::$var['title']);

        $this_->meta('<meta charset="utf-8" />');

        $this_->meta([
            "name"    => "viewport",
            "content" => "width=device-width, initial-scale=1",
        ], [
            'test-attr1',
            'test-attr2',
        ]);

        $this_->meta([
            "name"    => "description",
            "content" => "这是网页的描述",
        ]);

        $this_->meta([
            "name"    => "keywords",
            "content" => "keyword1, keyword2, keyword3",
        ]);

        $inner[] = '<hr>';
        $inner[] = '<hr>';
        $inner[] = '<hr>';

    })->process(function(Document $this_, array &$inner) {

        $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
            $this_->getAttr('class')->setAttrsArray([
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
                    $inner[] = 'column 3';
                });
            });

            $inner[] = DoubleTag::ins('div')->process(callback: function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('layui-row');

                $inner[] = DoubleTag::ins('div')->process(function(DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-col-xs12');

                    $this_->getAttr('style')->importKv([
                        "height"     => "600px",
                        "background" => "#ccc",
                    ]);

                    $this_->addAttr('data_uid', DataAttr::class);
                    $this_->getAttr('data_uid')->setAttrKv('uid', 25);

                    $this_->addAttr('data_cid', DataAttr::class);
                    $this_->getAttr('data_cid')->setDataKv('cid', 122);

                    $this_->getAttr('selected')->setAttrsString('unselected');

                    $inner[] = ComponentTest1::ins()->process(function(ComponentTest1 $this_, array &$inner) {
                        $this_->setSubsection('btn_color', 'orange')->setSubsection('btn_text', '一个按钮')
                            ->setSubsection('btn_msg', '弹出msg')->getScriptSection()->setSubsection('btn_icon', 4);
                    });

                    $inner[] = ComponentTest1::ins()->process(function(ComponentTest1 $this_, array &$inner) {
                        $this_->setSubsections([
                            'btn_color' => 'blue',
                            'btn_text'  => '一个按钮22',
                            'btn_msg'   => DomBlock::$var['title'],
                        ]);

                        //$this->jsCustomDomSection(Script::ins($this->scriptSection,false));
                        //init中调 jsCustomDomSection，这里才能用 getScriptSection 这个方法
                        $this_->getScriptSection()->setSubsection('btn_icon', 5);
                    });

                    $inner[] = ComponentTest1::ins()->process(function(ComponentTest1 $this_, array &$inner) {
                        $this_->setSubsections([
                            'btn_color' => 'green',
                            'btn_text'  => '一个按钮33',
                            'btn_msg'   => DomBlock::$var['title'],
                        ]);

                        //$this->jsCustomDomSection(Script::ins($this->scriptSection,false));
                        //init中调 jsCustomDomSection，这里才能用 getScriptSection 这个方法
                        $this_->getScriptSection()->setSubsections([
                                'btn_icon' => 3,
                            ]);
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
			padding    : 0;
			margin     : 0;
			background : #9bff9b
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
				<div class="layui-col-xs12" style="height:600px;background:#ccc;" data-uid="25" data-cid="122" unselected="">
					<button type="button" class="layui-btn layui-bg-orange " data-msg="弹出msg" id="coco-layer-btn-msg-42">一个按钮</button>
					<button type="button" class="layui-btn layui-bg-blue " data-msg="layui demo" id="coco-layer-btn-msg-84">一个按钮22</button>
					<button type="button" class="layui-btn layui-bg-green " data-msg="layui demo" id="coco-layer-btn-msg-109">一个按钮33</button>
				</div>
			</div>
		</div>
		<script src="//unpkg.com/layui@2.8.18/dist/layui.js" crossorigin="anonymous"></script>
		<script>
			layui.use(function () {
				let $     = layui.$;
				let layer = layui.layer;
				$("#coco-layer-btn-msg-42").on({
					"click": function () {
						layer.msg($(this).data("msg"), {icon: 4});
					}
				});
			});
		</script>
		<script>
			layui.use(function () {
				let $     = layui.$;
				let layer = layui.layer;
				$("#coco-layer-btn-msg-84").on({
					"click": function () {
						layer.msg($(this).data("msg"), {icon: 5});
					}
				});
			});
		</script>
		<script>
			layui.use(function () {
				let $     = layui.$;
				let layer = layui.layer;
				$("#coco-layer-btn-msg-109").on({
					"click": function () {
						layer.msg($(this).data("msg"), {icon: 3});
					}
				});
			});
		</script>
	</body>
</html>

 */