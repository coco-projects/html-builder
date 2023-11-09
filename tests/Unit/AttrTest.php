<?php

    declare(strict_types = 1);

    namespace Coco\Tests\Unit;

    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\dom\Document;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DoubleTag;
    use Coco\htmlBuilder\dom\SingleTag;

    use PHPUnit\Framework\TestCase;

final class AttrTest extends TestCase
{
    public function testA()
    {
        DomBlock::$var['title'] = 'Bootstrap demo';

        $inner1 = Document::ins()->process(function (Document $this_, array &$inner) {

            $this_->appendSubsection('TITLE', DomBlock::$var['title']);

            $this_->appendSubsection('HEAD', [

                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('charset')->setAttrKv('charset', 'utf-8');
                }),

                PHP_EOL,
                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'viewport');
                    $this_->getAttr('content')->setAttrKv('content', 'width=device-width, initial-scale=1');
                }),

                PHP_EOL,
                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'description');
                    $this_->getAttr('content')->setAttrKv('content', '这是网页的描述');
                }),

                PHP_EOL,
                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'keywords');
                    $this_->getAttr('content')->setAttrKv('content', '关键词1, 关键词2, 关键词3');
                }),
            ]);

            $this_->appendSubsection('CSS', [
                SingleTag::ins('link')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('href')
                        ->setAttrKv('href', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
                    $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);

            $this_->appendSubsection('JS_LIB', [
                DoubleTag::ins('script')->process(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('src')
                        ->setAttrKv('src', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js');
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);

            $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->setAttrsArray([
                    "container",
                    "text-center",
                ]);

                $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('row');

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('col');
                        $inner[] = 'column 1';
                    });

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('col');
                        $inner[] = 'column 2';
                    });

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('col');
                        $inner[] = 'column 3';
                    });
                });

                $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                    $this_->getAttr('class')->addAttr('row');

                    $inner[] = DoubleTag::ins('div')->process(function (DoubleTag $this_, array &$inner) {
                        $this_->getAttr('class')->addAttr('col');
                        $this_->getAttr('class')->addAttr('col-12');

                        $inner[] = DoubleTag::ins('h1')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h1';
                        });

                        $inner[] = DoubleTag::ins('h2')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h2';
                        });

                        $inner[] = DoubleTag::ins('h3')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h3';
                        });

                        $inner[] = DoubleTag::ins('h4')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h4';
                        });

                        $inner[] = DoubleTag::ins('h5')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h5';
                        });

                        $inner[] = DoubleTag::ins('h6')->process(function (DoubleTag $this_, array &$inner) {
                            $inner[] = 'hello h6';
                        });
                    });
                });
            });
        });
        $inner1->render();

        $this->assertTrue(true);
    }

    public function testB()
    {
        DomBlock::$var['title'] = 'component demo';

        $inner1 = Document::ins()->process(function (Document $this_, array &$inner) {

            $this_->appendSubsection('TITLE', DomBlock::$var['title']);

            $this_->appendSubsection('HEAD', [

                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('charset')->setAttrKv('charset', 'utf-8');
                }),

                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'viewport');
                    $this_->getAttr('content')->setAttrKv('content', 'width=device-width, initial-scale=1');
                }),

                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'description');
                    $this_->getAttr('content')->setAttrKv('content', '这是网页的描述');
                }),

                SingleTag::ins('meta')->process(function (SingleTag $this_, array &$inner) {
                    $this_->getAttr('name')->setAttrKv('name', 'keywords');
                    $this_->getAttr('content')->setAttrKv('content', '关键词1, 关键词2, 关键词3');
                }),
            ]);

            $inner[] = DoubleTag::ins('div')->process(callback: function (DoubleTag $this_, array &$inner) {
                $this_->getAttr('class')->setAttrsArray([
                    "layui-container",
                ]);

                $this_->getAttr('style')->importKv([
                    "width"      => "80%",
                    "height"     => "3000px",
                    "background" => "#ccc",
                ]);

                $this_->addAttr('data_uid', DataAttr::class);
                $this_->getAttr('data_uid')->setAttrKv('uid', 25);

                $this_->getAttr('selected')->setAttrsString('unselected');

                $inner[] = ComponentTest::ins()->process(function (ComponentTest $this_, array &$inner) {
                    $this_->setSubsection('btn_color', 'orange')->setSubsection('btn_text', '一个按钮')
                        ->setSubsection('btn_msg', '弹出msg')->getScriptSection()->setSubsection('btn_icon', 4);
                });

                $inner[] = ComponentTest::ins()->process(function (ComponentTest $this_, array &$inner) {
                    $this_->setSubsections([
                        'btn_color' => 'blue',
                        'btn_text'  => '一个按钮22',
                        'btn_msg'   => DomBlock::$var['title'],
                    ]);
                    $this_->getScriptSection()->setSubsection('btn_icon', 5);
                });
            });
        });
        $inner1->render();
        $this->assertTrue(true);
    }
}
