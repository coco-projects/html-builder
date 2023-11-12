<?php

    declare(strict_types = 1);

    namespace Coco\examples;

    use Coco\htmlBuilder\dom\DomSection;
    use Coco\htmlBuilder\dom\tags\CSSCode;
    use Coco\htmlBuilder\dom\tags\JSCode;
    use Coco\htmlBuilder\dom\tags\Script;
    use Coco\htmlBuilder\dom\tags\Style;

    class ComponentTest1 extends DomSection
    {
        protected array $defaultValue = [
            "btn_color" => "red",
            "btn_msg"   => "default-msg",
            "btn_text"  => "test",
            "btn_id"    => '',
        ];

        public function __construct()
        {
            $template = <<<'CONTENTS'
                <button type="button" class="layui-btn layui-bg-{:btn_color:} " data-msg='{:btn_msg:}' id="coco-layer-btn-msg-{:btn_id:}">{:btn_text:}</button>
CONTENTS;
            parent::__construct($template);
        }


        /**
         * 当这个组件被使用时，希望加上的 js 代码
         *
         * @return void
         */
        protected function makeScriptSection(): void
        {
            $this->scriptSection = new class extends JSCode {
                protected array $defaultValue = [
                    "btn_icon" => 1,
                    "btn_id"   => '',
                ];

                public function __construct()
                {
                    $template = <<<'CONTENTS'
    layui.use(function () {
        let $     = layui.$;
        let layer = layui.layer;
    
        $("#coco-layer-btn-msg-{:btn_id:}").on({
            "click": function () {
                layer.msg($(this).data("msg"), {icon: {:btn_icon:}});
            }
        });
    });
CONTENTS;
                    parent::__construct($template);
                }
            };
        }

        /**
         * 组件对应的自定义css代码
         *
         * @return void
         */
        protected function makeStyleSection(): void
        {
            $this->styleSection = new class extends CSSCode {

                protected array $defaultValue = [
                    "background" => '#9bff9b',
                ];

                public function __construct()
                {
                    $template = <<<'CONTENTS'
        *{
            padding:0px;
            margin: 0px;
            background: {:background:};
        }
CONTENTS;
                    parent::__construct($template);
                }
            };
        }

        protected function init(): void
        {
            $this->setSubsection('btn_id', $this->getId());
            $this->scriptSection->setSubsection('btn_id', $this->getId());

            $this->cssLib('//cdn.staticfile.org/layui/2.8.18/css/layui.css');
            $this->jsLib('//unpkg.com/layui@2.8.18/dist/layui.js');

            //组件被重复调用，此处代码会多次渲染，可以在dom中这样调用动态设置值
            //$this_->getScriptSection()->setSubsection('btn_icon', 5);
            $this->jsCustomDomSection(Script::ins($this->scriptSection, false));

            //组件被重复调用，此处代码只会渲染一次
            //无法在dom中动态设置值
            //            $this->jsCustomRawCode($this->scriptSection->render());

            //组件被重复调用，此处代码会多次渲染，可以在dom中这样调用动态设置值
            //            $this->cssCustomDomSection(Script::ins($this->styleSection,false));

            //组件被重复调用，此处代码只会渲染一次
            $this->cssCustomRawCode($this->styleSection->render());

        }

        protected function initAfterSectionRender(): void
        {
            $this->afterSectionRender['btn_msg'] = function(string $nodeName, mixed &$stringable) {
                $stringable = 'prefix_[' . $stringable . ']_suffix';
            };
        }
    }
