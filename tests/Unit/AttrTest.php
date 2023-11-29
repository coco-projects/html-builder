<?php

    declare(strict_types = 1);

    namespace Coco\Tests\Unit;

    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use Coco\htmlBuilder\dom\SingleTag;
    use Coco\htmlBuilder\dom\tags\Meta;
    use PHPUnit\Framework\TestCase;

final class AttrTest extends TestCase
{
    public function testA()
    {
        DomBlock::$var['title'] = 'layui demo';
        DomBlock::$isDebug      = false;

        $html = Document::ins()->inner(function (Document $this_, array &$inner) {

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
        })->inner(function (Document $this_, array &$inner) {

            $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttrsArray([
                    "layui-container",
                ]);

                $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 1';
                    });

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 2';
                    });

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 3';
                    });
                });

                $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4')->addAttr('col-12');

                        $inner[] = DoubleTag::ins('h1')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h1';
                        });

                        $inner[] = DoubleTag::ins('h2')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = ['hello h2'];
                        });

                        $inner[] = DoubleTag::ins('h3')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = function () {
                                return 'hello h3';
                            };
                        });

                        $inner[] = DoubleTag::ins('h4')->inner(function (DoubleTag $this_, array &$inner) {
                            $this_->setIsHidden(true);

                            $inner[] = 'hello h4';
                        });

                        $inner[] = DoubleTag::ins('h5')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h5';
                        });

                        $inner[] = DoubleTag::ins('h6')->inner(function (DoubleTag $this_, array &$inner) {

                            $inner[] = 'hello h666';
                        });
                    });
                });
            });
        });

        $html->render();

        $this->assertTrue(true);
    }

    public function testB()
    {

        DomBlock::$var['title'] = 'layui demo';
        DomBlock::$isDebug      = !false;
        $html                   = Document::ins()->inner(function (Document $this_, array &$inner) {

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

                SingleTag::ins('meta')->inner(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'keywords');
                    $this_->getAttr('content')->setAttrKv('content', '关键词1, 关键词2, 关键词3');
                }),

            ]);

            $this_->setSubsection('CSS_LIB', [
                SingleTag::ins('link')->inner(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('href')->setAttrKv('href', '//cdn.staticfile.org/layui/2.8.18/css/layui.css');
                    $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);

            $this_->setSubsection('JS_LIB', [
                DoubleTag::ins('script')->inner(function (DoubleTag $this_, array &$inner) {
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

            $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->addAttrsArray([
                    "layui-container",
                ]);

                $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 1';
                    });

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 2';
                    });

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $this_->getAttr('selected')->setAttrsString('selected');
                        $this_->getAttr('disabled')->setAttrsString('disabled');

                        $this_->addAttr('layui-encode', \Coco\htmlBuilder\attrs\RawAttr::class);
                        $this_->getAttr('layui-encode')->setAttrsString('layui-encode');
                        $inner[] = 'column 3';
                    });
                });

                $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4')->addAttr('col-12');

                        $inner[] = DoubleTag::ins('h1')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h1';
                        });

                        $inner[] = DoubleTag::ins('h2')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = ['hello h2'];
                        });

                        $inner[] = DoubleTag::ins('h3')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = function () {
                                return 'hello h3';
                            };
                        });

                        $inner[] = DoubleTag::ins('h4')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h4';
                        });

                        $inner[] = DoubleTag::ins('h5')->inner(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h5';
                        });

                        $inner[] = DoubleTag::ins('h6')->inner(function (DoubleTag $this_, array &$inner) {
                            $this_->setIsHidden(true);

                            $inner[] = 'hello h666';
                        });
                    });

                    $inner[] = DoubleTag::ins('div')->inner(function (DoubleTag $this_, array &$inner) {
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

//        <hr class="layer layer-text layer-padding-1 layui-show layui-all" data-uid="25" id="15" style="width:20px;height:120px; color:#0f0;background:#ccc;" selected layer-enable layer-border-red tid="250" margin="20" />
                    });
                });
            });
        });

        $html->render();
        $this->assertTrue(true);
    }
}
