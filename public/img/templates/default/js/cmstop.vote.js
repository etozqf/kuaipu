/**
 * V4模板投票脚本
 * 从模板中分离出后修改, 并非原作
 */
$(function () {


    // 固定住单选验证码面板，使之浮动于父元素之上，若不这样做，面板会顶出一段，非常难看
    function fixSignleButton(elem, type, button) {
        var _parent = elem.parent();
        var offset = _parent.offset();
        elem.addClass('pos-a').removeClass('hidden');
        if (type === 'radio') {
            elem.appendTo(document.body);
            elem.css({
                left:offset.left,
                top: offset.top + 177,
                width: _parent.width()
            });
        } else {
            button.after(elem);
            button.hide();
            elem.css({
                position: 'relative',
                marginTop: '10px'
            }).find('.vote-seccode').removeClass('vote-seccode');
        }
    }

    var init = {
        normal: function (elem) {
            var src = APP_URL + '?app=system&controller=seccode&action=image&length=11';
            elem.find('.seccodeImage')
                .attr('src', src + '&_=' + (new Date()).getTime())
                .attr('data-src', src);
        },
        advanced: function (elem) {
            var src = APP_URL + '?app=system&controller=seccode&action=image_pro&length=11&no_border=1&_=' + (new Date()).getTime();
            elem.find('.seccodeImage')
                .attr('src', src + '&_=' + (new Date()).getTime())
                .attr('data-src', src)
                .bind('load', function () {
                    elem.find('.seccodeColor').html(decodeURI($.cookie(COOKIE_PRE+'seccode_color')).replace('+', ' '));
                });
        }
    }

    function vote (url, params, callback) {
        var data = [];
        $.each(params, function (k, v) {
            if (v instanceof Array) {
                for (var i = 0; i < v.length; i++)
                    data.push(k+'[]='+v[i]);
            } else {
                data.push(k + '=' + v);
            }
        });
        data = data.join('&');
        $.getJSON(url + (url.indexOf('?') > -1 ? '&' : '?') + 'jsoncallback=?&' + data, function(json) {
            $.isFunction(callback) && callback(json);
        });
    }

    function updateResult(form, data) {
        $.each(data, function(i, n) {
            console.log(n.optionid, $('[data-optionid='+n.optionid+']'))
            $('[data-optionid='+n.optionid+']').find('.nums').removeClass('hidden');
            $('[data-optionid='+n.optionid+']').find('[data-role=count]').text(n.votes || 0);
        });
    }

    $('.js-vote-panel').find('.vote-btn').unbind('click').bind('click', function(e) {
        var _target = $(e.target);
        var next = _target.parent().next();
        var parent = next.parent();
        var form = parent.parents('form');

        form = form.length ? form : parent;
        next.data('parent', parent);
        next.data('form', form);

        $('.cancel').trigger('click');

        fixSignleButton(next, form.find('[name="type"]').val(), _target);
        next.data('optionid', parent.attr('data-optionid'));
        next.find('input:text').val('');
        init[form.find('[name="seccode_type"]').val()](next);
        e.preventDefault();
    });

    $(document.body).find('.seccodePanel .cancel').unbind('click').bind('click', function(e) { 
        var _target = $(e.target);
        var parent = _target.parents('.seccodePanel');
        try {
            parent.data('form').find('.vote-btn').show();
            parent.appendTo(parent.data('parent'));
        } catch (e) {}
        parent.addClass('hidden');
        e.preventDefault();
    });

    $(document.body).find('.seccodePanel [type="submit"]').unbind('click').bind('click', function (e) {
        e.preventDefault();
        var parent = $(this).parents('.seccodePanel');
        var optionid = parent.data('optionid');
        var value = parent.find('[name="seccode"]').val();
        var form = parent.data('form');
        var type = form.find('[name="type"]').val();

        if (type === 'checkbox') {
            optionid = [];
            form.find('[name="optionid"]:checked').each(function () {
                optionid.push(this.value);
            });
            if (!optionid.length) return alert('请选择选项');
        }

        if (!value) {
            return alert('请填写验证码');
        }
        vote(form.attr('action'), {
            contentid: form.find('[name="contentid"]').val(),
            optionid: optionid,
            seccode: value
        }, function (res) {
            if (!res.state) {
                return alert(res.error);
            }
            parent.data('parent').find('.vote-btn').text('已投票').unbind();
            updateResult(form, res.data);
            parent.remove();
            form.addClass('voted');
        });

    });

    $(document.body).find('.seccodePanel .seccodeImage').unbind('click').bind('click', function () {
        var elem = $(this);
        elem.attr('src', elem.attr('data-src') + '&_=' + (new Date()).getTime());
    });

})