<?php

    declare(strict_types = 1);

    namespace Coco\Tests\Unit;

    use Coco\htmlBuilder\dom\DomSection;

class ComponentTest extends DomSection
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

    protected function makeScriptSection(): void
    {
        $this->scriptSection = new class extends DomSection {

            protected array $defaultValue = [
                "btn_icon" => 1,
                "btn_id"   => '',
            ];

            public function __construct()
            {
                $template = <<<'CONTENTS'
<script>
    layui.use(function () {
        let $     = layui.$;
        let layer = layui.layer;
    
        $("#coco-layer-btn-msg-{:btn_id:}").on({
            "click": function () {
                layer.msg($(this).data("msg"), {icon: {:btn_icon:}});
            }
        });
    });
</script> 
CONTENTS;
                parent::__construct($template);
            }
        };
    }


    protected function makeStyleSection(): void
    {
        $this->styleSection = new class extends DomSection {

            protected array $defaultValue = [];

            public function __construct()
            {
                $template = <<<'CONTENTS'
                <style>
                    *{
                        padding:0;
                        margin: 0;
                    }
                </style> 
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

        $this->jsCustomDomSection($this->scriptSection);
        $this->cssCustomRawCode($this->styleSection->render());
    }
}
