$(function() {
    /* 表单相关 */
    $('#form').ajaxForm(function(json) {
        if (json && json.state) {
            ct.tips('保存成功');
        } else {
            ct.error(json && json.error || '保存失败');
        }
    });

    /* 上传相关 */
    function saveLogo(elem, success, error) {
        $.post('?app=mobile&controller=ad&action=index', elem.find(':input').serialize(), function(json) {
            if (json && json.state) {
                $.isFunction(success) && success(json);
            } else {
                $.isFunction(error) && success(error);
            }
        }, 'json');
    }
    function appendReuploadBtn(elem) {
        var btn = $('<div class="mobile-style-bg-upload"></div>').appendTo(elem.find('.ui-bootstrap-logo-item-img'));
        btn.mobileUploader(function(json) {
            elem.find('input').val(json.file);
            elem.find('.ui-bootstrap-logo-item-img img').replaceWith('<img src="'+UPLOAD_URL+json.file+'" width="100" height="150" />');
        });
    }
    $('.ui-bootstrap-logo-item').each(function() {
        var logo = $(this);
        var addImg = logo.find('.ui-bootstrap-logo-item-img-empty').mobileUploader(function(json) {
            logo.find('input').val(json.file);
            addImg.replaceWith('<img src="'+UPLOAD_URL+json.file+'" width="100" height="150" />');
            appendReuploadBtn(logo);
        });
        if (!addImg.length) {
            appendReuploadBtn(logo);
        }
    });
});