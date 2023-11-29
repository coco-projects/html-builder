<?php

    use Coco\examples\ComponentTest1;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;

    require '../vendor/autoload.php';

    DomBlock::$var['title'] = 'layui demo';
    DomBlock::$isDebug      = !false;

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

        $inner[] = '<hr>';
        $inner[] = '<hr>';

    })->inner(function(Document $this_, array &$inner) {

        $inner[] = DomBlock::$var['test_div'] = DoubleTag::ins('div');
        DomBlock::$var['test_div']->inner(function(DoubleTag $this_, array &$inner) {
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

                    $this_->appendDesignatedSection(DomBlock::$var['test_div'], 'ATTRS', ' data-pid="123"');

                    $this_->getAttr('class')->addAttr('layui-col-xs4');
                    $inner[] = 'column 3';
                });
            });

            $inner[] = DoubleTag::ins('div')->inner(callback: function(DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttr('layui-row');

                $inner[] = DoubleTag::ins('div')->inner(function(DoubleTag $this_, array &$inner) {
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

                    $inner[] = ComponentTest1::ins()->inner(function(ComponentTest1 $this_, array &$inner) {
                        $this_->setSubsection('btn_color', 'orange')->setSubsection('btn_text', '一个按钮')
                            ->setSubsection('btn_msg', '弹出msg')->getScriptSection()->setSubsection('btn_icon', 4);
                    });

                    $inner[] = ComponentTest1::ins()->inner(function(ComponentTest1 $this_, array &$inner) {
                        $this_->setSubsections([
                            'btn_color' => 'blue',
                            'btn_text'  => '一个按钮22',
                            'btn_msg'   => DomBlock::$var['title'],
                        ]);

                        //$this->jsCustomDomSection(Script::ins($this->scriptSection,false));
                        //init中调 jsCustomDomSection，这里才能用 getScriptSection 这个方法
                        $this_->getScriptSection()->setSubsection('btn_icon', 5);
                    });

                    $inner[] = ComponentTest1::ins()->inner(function(ComponentTest1 $this_, array &$inner) {

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
<html lang="zh">
	<head>
		<title>layui demo</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="description" content="这是网页的描述"/>
		<meta name="keywords" content="keyword1, keyword2, keyword3"/>
		<link href="//cdn.staticfile.org/layui/2.8.18/css/layui.css" rel="stylesheet" crossorigin="anonymous"/>

		<style>        *{
			padding    : 0px;
			margin     : 0px;
			background : #9bff9b;
		}</style>
	</head>
	<body>
		<hr>
		<hr>
		<div data-pid="123" class="layui-container ">
			<div class="layui-row ">
				<div class="layui-col-xs4 ">column 1</div>
				<div class="layui-col-xs4 ">column 2</div>
				<div class="layui-col-xs4 ">column 3</div>
			</div>
			<div class="layui-row ">
				<div class="layui-col-xs12 " style="height:600px;background:#ccc; " data-uid="25" data-cid="122" unselected>
					<button type="button" class="layui-btn layui-bg-orange " data-msg='prefix_[弹出msg]_suffix' id="coco-layer-btn-msg-32 " style="">一个按钮</button>
					<button type="button" class="layui-btn layui-bg-blue " data-msg='prefix_[layui demo]_suffix' id="coco-layer-btn-msg-68 " style="">一个按钮22</button>
					<button type="button" class="layui-btn layui-bg-green " data-msg='prefix_[layui demo]_suffix' id="coco-layer-btn-msg-92 layui-show layui-all" style="color:#0f0;background:#ccc;" layer-enable layer-border-red tid="250" margin="20">一个按钮33</button>
				</div>
			</div>
		</div>
		<script src="//unpkg.com/layui@2.8.18/dist/layui.js" crossorigin="anonymous"></script>
		<script>    layui.use(function () {
			let $     = layui.$;
			let layer = layui.layer;

			$("#coco-layer-btn-msg-32").on({
				"click": function () {
					layer.msg($(this).data("msg"), {icon: 4});
				}
			});
		});</script>
		<script>    layui.use(function () {
			let $     = layui.$;
			let layer = layui.layer;

			$("#coco-layer-btn-msg-68").on({
				"click": function () {
					layer.msg($(this).data("msg"), {icon: 5});
				}
			});
		});</script>
		<script>    layui.use(function () {
			let $     = layui.$;
			let layer = layui.layer;

			$("#coco-layer-btn-msg-92").on({
				"click": function () {
					layer.msg($(this).data("msg"), {icon: 3});
				}
			});
		});</script>
	</body>
</html>


     */