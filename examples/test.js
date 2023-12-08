layui.use(getMods(), function () {
    let $ = layui.$;


    (function () {

        // 提交事件
        layui.form.on("submit(layfilter_id_6)", function (data) {
            var field    = data.field; // 获取表单全部字段值
            var elem     = data.elem; // 获取当前触发事件的元素 DOM 对象，一般为 button 标签
            var elemForm = data.form; // 获取当前表单域的 form 元素对象，若容器为 form 标签才会返回。

            console.dir(field);
            console.dir(JSON.stringify(field));

            layer.alert(JSON.stringify(field), {
                title     : "当前填写的字段值",
                anim      : -1,
                isOutAnim : false,
                shadeClose: true,
                shade     : 0.5,
                area      : [
                    "50%",
                    "50%"
                ]
            });

            // 此处可执行 Ajax 等操作

            // 阻止默认 form 跳转
            return false;
        });

    })();


    (function () {
        layui.colorpicker.render({
            elem     : "#id_70",
            color    : "#9bff9b",
            predefine: true,
            colors   : [
                "#fafafa",
                "#c2c2c2",
                "#ff5722",
                "#ffb800",
                "#16baaa",
                "#31bdec",
                "#1e9fff",
                "#16b777",
                "#a233c6",
                "#2f363c"
            ],
            change   : function (color) {
                $("#id_69").val(color);
            }
        });
    })();

    (function () {
        var baseConfig = {elem: "#id_77"};
        var userConfig = {
            shortcuts: [
                {
                    text : "昨天",
                    value: function () {
                        var now = new Date();
                        now.setDate(now.getDate() - 1);
                        return now;
                    }
                },
                {
                    text : "今天",
                    value: function () {
                        return Date.now();
                    }
                },
                {
                    text : "明天",
                    value: function () {
                        var now = new Date();
                        now.setDate(now.getDate() + 1);
                        return now;
                    }
                },
                {
                    text : "上月今天",
                    value: function () {
                        var now   = new Date();
                        var month = now.getMonth() - 1;
                        now.setMonth(month);
                        // 若上个月数不匹配，则表示天数溢出
                        if (now.getMonth() !== month)
                        {
                            now.setDate(0); // 重置天数
                        }
                        return [now];
                    }
                },
                {
                    text : "下月今天",
                    value: function () {
                        var now   = new Date();
                        var month = now.getMonth() + 1;
                        now.setMonth(month);
                        // 若下个月数不匹配，则表示天数溢出
                        if (now.getMonth() !== month)
                        {
                            now.setDate(0); // 重置天数
                        }
                        return [now];
                    }
                }
            ]
        };
        var config     = Object.assign({}, userConfig, baseConfig);
        layui.laydate.render(config);
    })();

    (function () {
        var baseConfig = {
            elem : "#id_84",
            range: true
        };
        var userConfig = {
            shortcuts: [
                {
                    text : "上个月",
                    value: function () {
                        var date  = new Date();
                        var year  = date.getFullYear();
                        var month = date.getMonth();
                        return [
                            new Date(year, month - 1, 1),
                            new Date(year, month, 0)
                        ];
                    }
                },
                {
                    text : "这个月",
                    value: function () {
                        var date  = new Date();
                        var year  = date.getFullYear();
                        var month = date.getMonth();
                        return [
                            new Date(year, month, 1),
                            new Date(year, month + 1, 0)
                        ];
                    }
                },
                {
                    text : "下个月",
                    value: function () {
                        var date  = new Date();
                        var year  = date.getFullYear();
                        var month = date.getMonth();
                        return [
                            new Date(year, month + 1, 1),
                            new Date(year, month + 2, 0)
                        ];
                    }
                }
            ]
        };
        var config     = Object.assign({}, userConfig, baseConfig);
        layui.laydate.render(config);
    })();

    (function () {
        layui.iconPicker.render({
            // 选择器，推荐使用input
            elem: "#id_91",

            // 数据类型：fontClass/unicode，推荐使用fontClass
            type: "fontClass",

            // 是否开启搜索：true/false
            search: true,

            // 是否开启分页
            page: false,

            // 每页显示数量，默认12
            limit: 16,

            cellWidth: "20%",

            // 点击回调
            click: function (data) {
            },

            // 渲染成功后的回调
            success: function (d) {
            }
        });
    })();

    (function () {
        var baseConfig = {elem: "#id_233"};
        var userConfig = {
            "type"    : "default",
            "showstep": true,
            "tips"    : true,
            "input"   : true,
            "range"   : false,
            "value"   : 30,
            "min"     : 10,
            "max"     : 50,
            "step"    : 1,
            "theme"   : "#ffb800",
            "disabled": false,
            change    : function (value) {
                $("#id_98").val(value);
            }
        };

        var config = Object.assign({}, userConfig, baseConfig);
        layui.slider.render(config);
    })();

    (function () {
        var baseConfig = {elem: "#id_234"};
        var userConfig = {
            "type"    : "default",
            "showstep": true,
            "tips"    : true,
            "input"   : true,
            "range"   : true,
            "value"   : [
                25,
                37
            ],
            "min"     : 10,
            "max"     : 80,
            "step"    : 1,
            "theme"   : "#16b777",
            "disabled": false,
            change    : function (value) {
                $("#id_106").val(value[0] + "," + value[1]);

                $("#slider_start_id_234").text(value[0]);
                $("#slider_end_id_234").text(value[1]);
            }
        };

        var config = Object.assign({}, userConfig, baseConfig);
        layui.slider.render(config);
    })();

    (function () {
        var baseConfig = {};
        var userConfig = {};


        let tagRules = {
            "number": {
                "msg"     : "必须为数字",
                "callback": function (input) {
                    return /\d+/ig.test(input);
                }
            }
        };

        let filterName = "layfilter_id_155";

        var config = Object.assign({}, userConfig, baseConfig);
        layui.tag.render(filterName, config);

        layui.tag.on("add(" + filterName + ")", function (data) {
            let inputValue = $(data.othis).text();
            let allValue   = (data.elem).find(".tag_text");

            let rule = ["number"];

            for (let ruleKey in rule)
            {
                let ruleName = rule[ruleKey];
                if (tagRules[ruleName] !== undefined)
                {
                    let result = tagRules[ruleName]["callback"](inputValue);

                    if (result === false)
                    {
                        layui.layer.msg(tagRules[ruleName]["msg"]);
                        return false;
                    }
                }
            }

            let values = [];
            allValue.each(function (k, v) {
                values.push($(v).text());
            });

            let isUnique = true;

            if (isUnique)
            {
                if (values.indexOf(inputValue) !== -1)
                {
                    layui.layer.msg("标签 " + inputValue + " 已经存在，不能重复输入");
                    return false;
                }
            }


            values.push(inputValue);

            $("#id_154").val(values.join());
        });

        layui.tag.on("delete(" + filterName + ")", function (data) {

            let deleteValue = $(this).parents("button").find(".tag_text").text();
            let allValue    = (data.elem).find(".tag_text");

            let values = [];
            allValue.each(function (k, v) {
                values.push($(v).text());
            });

            let index = values.indexOf(deleteValue);
            if (index !== -1)
            {
                values.splice(index, 1);
            }

            $("#id_154").val(values.join());
        });

    })();

    (function () {
        var userConfig = {};

        var baseConfig = {
            elem                         : "#id_196",
            height                       : 500,
            width                        : "auto",
            images_upload_url            : "http://local.deve:6025/admin/test.php",
            resize                       : true,
            automatic_uploads            : true,
            paste                        : true,
            paste_data_images            : true,
            statusbar                    : true,
            paste_webkit_styles          : "all",
            paste_retain_style_properties: "all",
            smart_paste                  : false,
            paste_remove_styles_if_webkit: false,
            autosave_interval            : "5s",
            plugins                      : "autosave code paste kityformula-editor quickbars print preview searchreplace autolink fullscreen image link media codesample table charmap hr advlist lists wordcount imagetools indent2em",
            toolbar                      : "preview_contents preview- code | undo redo | kityformula-editor forecolor backcolor bold italic underline strikethrough | indent2em alignleft aligncenter alignright alignjustify outdent indent | link bullist numlist image table codesample | formatselect fontselect fontsizeselect",
            menubar                      : "file edit insert format table",
            quickbars_selection_toolbar  : "cut copy | bold italic underline strikethrough ",
            menu                         : {
                file  : {
                    title: "文件",
                    items: "fullscreen newdocument | print | wordcount |StoreDraft Restoredraft RemoveDraft"
                },
                edit  : {
                    title: "编辑",
                    items: "undo redo | cut copy paste pastetext selectall | searchreplace"
                },
                format: {
                    title: "格式",
                    items: "bold italic underline strikethrough superscript subscript | formats | forecolor backcolor | removeformat"
                },
                table : {
                    title: "表格",
                    items: "inserttable tableprops deletetable | cell row column"
                }
            },

            form: {
                name: "image_upload",
                data: {"key": "value"}
            },

            init_instance_callback: function (editor) {
                editor.on("NodeChange", function (e) {
                    $("#id_195").text(editor.getContent());
                });
            },


            setup: function (editor) {
                editor.ui.registry.addButton("preview_contents", {
                    // text    : "preview contents",
                    icon    : "preview",
                    onAction: function () {
                        layer.open({
                            type      : 1,
                            anim      : -1,
                            isOutAnim : false,
                            shadeClose: true,
                            shade     : 0.5,
                            area      : [
                                "80%",
                                "80%"
                            ],
                            content   : "<div style=\"padding: 12px;\">" + editor.getContent() + "</div>"
                        });
                    }
                });
            }

            /*
             menu   : {
             custom: {
             title: "Custom Menu",
             items: "undo redo myCustomMenuItem"
             }
             },
             menubar: "file edit custom",
             toolbar: "mysidebar",
             setup  : function (editor) {
             editor.ui.registry.addMenuItem("myCustomMenuItem", {
             text    : "My Custom Menu Item",
             onAction: function () {
             alert("Menu item clicked");
             }
             });

             editor.ui.registry.addSidebar("mysidebar", {
             tooltip: "My sidebar",
             icon   : "comment",
             onSetup: function (api) {
             console.log("Render panel", api.element());
             },
             onShow : function (api) {
             console.log("Show panel", api.element());
             api.element().innerHTML = "Hello world!";
             },
             onHide : function (api) {
             console.log("Hide panel", api.element());
             }
             });
             },*/

        };

        var config = Object.assign({}, userConfig, baseConfig);

        layui.tinymce.render(config);

    })();

    (function () {
        let data = [
            {
                "title"   : "Transfer_label6",
                "value"   : 6,
                "disabled": true,
                "checked" : false
            },
            {
                "title"   : "Transfer_label7",
                "value"   : 7,
                "disabled": false,
                "checked" : false
            },
            {
                "title"   : "Transfer_label8",
                "value"   : 8,
                "disabled": false,
                "checked" : false
            },
            {
                "title"   : "Transfer_label9",
                "value"   : 9,
                "disabled": true,
                "checked" : false
            },
            {
                "title"   : "Transfer_label10",
                "value"   : 10,
                "disabled": false,
                "checked" : false
            },
            {
                "title"   : "Transfer_label11",
                "value"   : 11,
                "disabled": true,
                "checked" : false
            }
        ];

        let insId = "#ins_id_207";

        layui.transfer.render({
            elem      : "#id_207",
            id        : insId,
            data      : data,
            value     : [
                8,
                9,
                10,
                11
            ],
            title     : [
                "左边标题",
                "右边标题"
            ],
            showSearch: true,
            width     : 250,
            height    : 300,
            text      : {
                none      : "无数据",
                searchNone: "无匹配数据"
            },
            onchange  : function (data, index) {
                let getData = layui.transfer.getData(insId);

                let values = getData.map(function (obj) {
                    return obj.value;
                });

                $("#id_206").val(values.join());
            }
        });

    })();

    (function () {

        // tab 切换事件
        layui.element.on("tab(layfilter_id_211)", function (data) {
            console.log(this); // 当前 tab 标题所在的原始 DOM 元素
            console.log(data.index); // 得到当前 tab 项的所在下标
            console.log(data.elem); // 得到当前的 tab 容器

            layer.msg("tab：" + data.index);
        });

    })();

    (function () {

        // 提交事件
        layui.form.on("submit(layfilter_id_217)", function (data) {
            var field    = data.field; // 获取表单全部字段值
            var elem     = data.elem; // 获取当前触发事件的元素 DOM 对象，一般为 button 标签
            var elemForm = data.form; // 获取当前表单域的 form 元素对象，若容器为 form 标签才会返回。

            console.dir(field);
            console.dir(JSON.stringify(field));

            layer.alert(JSON.stringify(field), {
                title     : "当前填写的字段值",
                anim      : -1,
                isOutAnim : false,
                shadeClose: true,
                shade     : 0.5,
                area      : [
                    "50%",
                    "50%"
                ]
            });

            // 此处可执行 Ajax 等操作

            // 阻止默认 form 跳转
            return false;
        });

    })();


});
