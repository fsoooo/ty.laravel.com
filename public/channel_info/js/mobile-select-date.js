(function(root, factory) {
    //amd
    if (typeof define === 'function' && define.amd) {
        define([factory], factory);
    } else if (typeof exports === 'object') { //umd
        module.exports = factory();
    } else {
        root.MobileSelectDate = factory(window.Zepto || window.jQuery || $);
    }
})(this, function($) {
    var MobileSelectDate = function() {
        var rnd = Math.random().toString().replace('.', '');
        this.id = 'scroller_' + rnd;
        this.scroller;
        this.data;
        this.index = 0;
        this.value = [0, 0, 0];
        this.oldvalue;
        this.oldtext;
        this.text = ['', '', ''];
        this.level = 3;
        this.mtop = 30;
        this.separator = ' ';
    };
    MobileSelectDate.prototype = {
        init: function(settings) {
            this.settings = $.extend({}, settings);
            this.separator = "-";
            var now = new Date();
            this.settings.value = this.settings.value || $(this.settings.trigger).val() || this.settings.min || now.getFullYear() + "-" + ("0" + (now.getMonth() + 1)).slice(-2) + '-' + ("0" + (now.getDate())).slice(-2);
            this.settings.value = this.settings.value.replace(/-/g, '-');
            this.settings.text = this.settings.value.split('-');
            this.settings.default == undefined ? this.default = 1 : this.default = 0; //0为空,1时默认选中第一项
            this.trigger = $(this.settings.trigger);
            this.trigger.attr("readonly", "readonly");
            this.value = (this.settings.value && this.settings.value.split("-")) || [0, 0, 0];
            this.text = this.settings.text || this.trigger.val().split(' ') || ['', '', ''];
            this.oldvalue = this.value.concat([]);
            this.oldtext = this.text.concat([]);

            if (this.settings.min) {
                this.min = this.settings.min.split("-");
                this.min = new Date(this.min[0], this.min[1], this.min[2]);
            } else {
                this.min = new Date(1990, 0, 1);
            }

            if (this.settings.max) {
                this.max = this.settings.max.split("-");
                this.max = new Date(this.max[0], this.max[1], this.max[2]);
            } else {
				this.max = new Date();
				if(this.settings.serverDate){
					this.max = new Date(this.settings.serverDate);
				}
            }

            this.clientHeight = document.documentElement.clientHeight || document.body.clientHeight;
            this.clientWidth = document.documentElement.clientWidth || document.body.clientWidth;
            this.getData();
            this.bindEvent();
        },
        //覆盖数据方法,so easy
        getData: function() {
            var json = [];
			var minYear = this.min.getFullYear(),minMonth = this.min.getMonth() +1,minDate = this.min.getDate();
			var maxYear = this.max.getFullYear(),maxMonth = this.max.getMonth() +1,maxDate = this.max.getDate();
			
            for (var s = minYear; s <= maxYear; s++) {
                var obj = {};
                obj['id'] = obj['name'] = s;
                obj.child = [];
				
				var m = s == minYear ? minMonth : 1;
                for (; m <= 12; m++) {
                    var o = {};
                    o['id'] = o['name'] = ("0" + m).slice(-2);
                    o.child = [];
                    
                    var days = new Date(s, m, 0).getDate();
                    var d = (m == minMonth && s == minYear) ? minDate : 1;
					
                    for (; d <= days; d++) {
                        var j = {};
                        j['id'] = j['name'] = ("0" + d).slice(-2);
						
                        if (!(m == maxMonth && s == maxYear && d > maxDate)) {
                            o.child.push(j);
                        }
                    }
                    if (!(m > maxMonth && s == maxYear)) {
                        obj.child.push(o);
                    }
                }
                json.push(obj)
            }
            this.data = json;
        },
        updateMax:function(max){
            this.max = max.split("-");
            this.max = new Date(this.max[0], this.max[1]-1, this.max[2]);
            this.getData();
        },
        updateMin:function(min){
            this.min = min.split("-");
            this.min = new Date(this.min[0], this.min[1]-1, this.min[2]);
            this.getData();
        },
        updateCurr:function(curr){
            this.value = curr.split("-");
            this.text = this.value ;
        },
        bindEvent: function() {
            var _this = this;
            this.trigger.click(function(e) {
                $(this).blur();
                var evt = e || window.event; //IE用cancelBubble=true来阻止而FF下需要用stopPropagation方法
                evt.stopPropagation ? evt.stopPropagation() : (evt.cancelBubble = true);
                $.confirm('<div><div class="ui-scroller-mask"><div id="' + _this.id + '" class="ui-scroller"><div></div><div></div><div></div><p></p></div></div></div>', null, function(t, c) {
                    if (t == "yes") {
                        _this.submit()
                    }
                    if (t == 'no') {
                        _this.cancel();
                    }
                    this.dispose();
                }, {
                    fixed: true,
                });
                _this.scroller = $('#' + _this.id);
                _this.format();
                var start = 0,
                    end = 0
                _this.scroller.children().bind('touchstart', function(e) {
                    e.preventDefault();
                    start = (e.changedTouches || e.originalEvent.changedTouches)[0].pageY;
                });
                _this.scroller.children().bind('touchmove', function(e) {
                    e.preventDefault();
                    end = (e.changedTouches || e.originalEvent.changedTouches)[0].pageY;
                    var diff = end - start;
                    var dl = $(e.target).parent();
                    if (dl[0].nodeName != "DL") {
                        return;
                    }
                    var top = parseInt(dl.css('top') || 0) + diff;
                    dl.css('top', top);
                    start = end;
                    return false;
                });
                _this.scroller.children().bind('touchend', function(e) {
                    e.preventDefault();
                    end = (e.changedTouches || e.originalEvent.changedTouches)[0].pageY;
                    var diff = end - start;
                    var dl = $(e.target).parent();
                    if (dl[0].nodeName != "DL") {
                        return;
                    }
                    var i = $(dl.parent()).index();
                    var top = parseInt(dl.css('top') || 0) + diff;
                    if (top > _this.mtop) {
                        top = _this.mtop;
                    }
                    if (top < -$(dl).height() + 60) {
                        top = -$(dl).height() + 60;
                    }
                    var mod = top / _this.mtop;
                    var mode = Math.round(mod);
                    var index = Math.abs(mode) + 1;
                    if (mode == 1) {
                        index = 0;
                    }
                    _this.value[i] = $(dl.children().get(index)).attr('ref');
                    _this.value[i] == 0 ? _this.text[i] = "" : _this.text[i] = $(dl.children().get(index)).html();
                    for (var j = _this.level - 1; j > i; j--) {
                        _this.value[j] = 0;
                        _this.text[j] = "";
                    }
                    if (!$(dl.children().get(index)).hasClass('focus')) {
                        _this.format();
                    }
                    $(dl.children().get(index)).addClass('focus').siblings().removeClass('focus');
                    dl.css('top', mode * _this.mtop);
                    //$("#txt_date_premium").css("pointer-events","none");
                    //$("#buy_condition").css("pointer-events","none");
                    return false;
                });
                return false;
            });
        },
        format: function() {
            var _this = this;
            var child = _this.scroller.children();
            this.f(this.data);
        },
        f: function(data) {
            var _this = this;
            var item = data;
            if (!item) {
                item = [];
            };
            var str = '<dl><dd ref="0">——</dd>';
            var focus = 0,
                childData, top = _this.mtop;
            if (_this.index !== 0 && _this.value[_this.index - 1] == "0" && this.default == 0) {
                str = '<dl><dd ref="0" class="">——</dd>';
                _this.value[_this.index] = 0;
                _this.text[_this.index] = "";
                focus = 0;
            } else {
                if (_this.value[_this.index] == "0") {
                    str = '<dl><dd ref="0" class="">——</dd>';
                    focus = 0;
                }
                if (item.length > 0 && this.default == 1) {
                    str = '<dl>';
                    var pid = item[0].pid || 0;
                    var id = item[0].id || 0;
                    focus = item[0].id;
                    childData = item[0].child;
                    if (!_this.value[this.index]) {
                        _this.value[this.index] = id;
                        _this.text[this.index] = item[0].name;
                    }
                    str += '<dd pid="' + pid + '" class="' + cls + '" ref="' + id + '">' + item[0].name + '</dd>';
                }
                for (var j = _this.default, len = item.length; j < len; j++) {
                    var pid = item[j].pid || 0;
                    var id = item[j].id || 0;
                    var cls = '';
                    if (_this.value[_this.index] == id) {
                        cls = "";
                        focus = id;
                        childData = item[j].child;
                        top = _this.mtop * (-(j - _this.default));
                    };
                    str += '<dd pid="' + pid + '" class="' + cls + '" ref="' + id + '">' + item[j].name + '</dd>';
                }
            }
            str += "</dl>";
            var newdom = $(str);
            newdom.css('top', top);
            var child = _this.scroller.children();
            $(child[_this.index]).html(newdom);
            _this.index++;
            if (_this.index > _this.level - 1) {
                _this.index = 0;
                return;
            }
            _this.f(childData);
        },
        submit: function() {
            this.oldvalue = this.value.concat([]);
            this.oldtext = this.text.concat([]);
            if (this.trigger[0].nodeType == 1) {
                //input
                this.trigger.val(this.text.join(this.separator));
//              this.trigger.attr('data-value', this.value.join(','));
                this.trigger.attr('data-value', this.value.join('-'));
                
                
                if (this.trigger.attr('id') == "txt_date_premium") {
                    premium();
                }
            }
            // $('input[name=insureBirth]').trigger('change') ;
            $(this.settings.trigger).trigger('change');
            this.trigger.next(':hidden').val(this.value.join(','));
            this.settings.callback && this.settings.callback(this.scroller);
        },
        cancel: function() {
            this.value = this.oldvalue.concat([]);
            this.text = this.oldtext.concat([]);
        }
    }
    return MobileSelectDate;
})
