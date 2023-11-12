<?php

    declare(strict_types = 1);

    namespace Coco\Tests\Unit;

    use Coco\examples\ComponentTest1;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use PHPUnit\Framework\TestCase;

final class AttrTest extends TestCase
{
    public function testA()
    {
        DomBlock::$var['title'] = 'layui demo';
        DomBlock::$isDebug      = false;

        $html = Document::ins()->process(function (Document $this_, array &$inner) {

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
        })->process(function (Document $this_, array &$inner) {

            $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->setAttrsArray([
                    "layui-container",
                ]);

                $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 1';
                    });

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 2';
                    });

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 3';
                    });
                });

                $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4')->addAttr('col-12');

                        $inner[] = DoubleTag::ins('h1')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h1';
                        });

                        $inner[] = DoubleTag::ins('h2')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = ['hello h2'];
                        });

                        $inner[] = DoubleTag::ins('h3')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = function () {
                                return 'hello h3';
                            };
                        });

                        $inner[] = DoubleTag::ins('h4')->process(function (DoubleTag $this_, array &$inner) {
                            $this_->setIsHidden(true);

                            $inner[] = 'hello h4';
                        });

                        $inner[] = DoubleTag::ins('h5')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h5';
                        });

                        $inner[] = DoubleTag::ins('h6')->process(function (DoubleTag $this_, array &$inner) {

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
        DomBlock::$isDebug      = false;

        $html = Document::ins()->process(function (Document $this_, array &$inner) {

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
        })->process(function (Document $this_, array &$inner) {

            $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->setAttrsArray([
                    "layui-container",
                ]);

                $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 1';
                    });

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 2';
                    });

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs4');
                        $inner[] = 'column 3';
                    });
                });

                $inner[] = DoubleTag::ins('div')->process(callback: function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('layui-row');

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('layui-col-xs12');

                        $this_->getAttr('style')->importKv([
                            "height"     => "300px",
                            "background" => "#ccc",
                        ]);

                        $this_->addAttr('data_uid', DataAttr::class);
                        $this_->getAttr('data_uid')->setAttrKv('uid', 25);


                        $this_->addAttr('data_cid', DataAttr::class);
                        $this_->getAttr('data_cid')->setDataKv('cid', 122);

                        $this_->getAttr('selected')->setAttrsString('unselected');

                        $inner[] = ComponentTest1::ins()->process(function (ComponentTest1 $this_, array &$inner) {
                            $this_->setSubsection('btn_color', 'orange')->setSubsection('btn_text', '一个按钮')
                                ->setSubsection('btn_msg', '弹出msg')->getScriptSection()
                                ->setSubsection('btn_icon', 4);
                        });

                        $inner[] = ComponentTest1::ins()->process(function (ComponentTest1 $this_, array &$inner) {
                            $this_->setSubsections([
                                'btn_color' => 'blue',
                                'btn_text'  => '一个按钮22',
                                'btn_msg'   => DomBlock::$var['title'],
                            ]);

                            //$this->jsCustomDomSection(Script::ins($this->scriptSection,false));
                            //init中调 jsCustomDomSection，这里才能用 getScriptSection 这个方法
                            $this_->getScriptSection()->setSubsection('btn_icon', 5);
                        });

                        $inner[] = ComponentTest1::ins()->process(function (ComponentTest1 $this_, array &$inner) {
                            $this_->setSubsections([
                                'btn_color' => 'green',
                                'btn_text'  => '一个按钮33',
                                'btn_msg'   => DomBlock::$var['title'],
                            ]);

                            //$this->jsCustomDomSection(Script::ins($this->scriptSection,false));
                            //init中调 jsCustomDomSection，这里才能用 getScriptSection 这个方法
                            $this_->getScriptSection()->setSubsection('btn_icon', 3);
                        });
                    });
                });
            });
        });

        $html->render();
        $this->assertTrue(true);
    }
}
