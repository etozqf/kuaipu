/**
 * file manager application
 * @needs cmstop.js & cmstop.dialog.js
 */
(function(ct,$){
var re_pre_upurl = new RegExp('^'+UPLOAD_URL);
$.extend(ct,{
	fileManager:function(callback_ok, ext, multi, size) {
		var url = ['?app=system&controller=attachment&action=index&select=1'];
		multi || (url.push('&single=1'));
		ext || (ext = 'jpg,jpeg,png,gif');
		size || (size = 0);
		url.push('&ext_limit='+ext+'&size_limit='+size);

        var win = window;
        try {
            while (win.parent && win.parent.cmstop && win.parent.dialog) {
                if (win.parent == win) break;
                win = win.parent;
            }
        } catch (ex) {}

		var d = win.cmstop.iframe({
			title:url.join(''),
			width:820,
			height:465
		},{
			ok : function(res){
				if (multi) {
					for (var i=0,l=res.length;i<l;i++){
						res[i].src && (res[i].src = res[i].src.replace(re_pre_upurl,''));
					}
				} else {
					res.src && (res.src = res.src.replace(re_pre_upurl,''));
				}
				(ct.func(callback_ok) || function(){})(res);
				d.dialog('close');
			}
		});
		return d;
	},
	editImage:function(file, options, callback_ok) {
        if ($.isFunction(options)) {
            callback_ok = options;
            options = {};
        }
        if (['jpg', 'jpeg', 'gif', 'png', 'bmp'].indexOf(file.split('.').pop()) === -1) {
        	file += file.indexOf('?') ? '&_.png' : '?_.png';
        }
        var width = options && options.width || 0,
            height = options && options.height || 0,
            inst = ImageEditor.open(file, '', width, height);
		inst.bind("saved", callback_ok);
		return inst;
	}
});
function imgUploader(up, url, ok)
{
	up.uploader({
		fileDesc:'图像',
		fileExt:'*.jpg;*.jpeg;*.gif;*.png',
		multi:false,
		script:url,
		jsonType : 1,
		complete:function(json, data){
			if (json) {
				json.state && ok(json.file);
				json.state || ct.error(json.error);
			} else {
				ct.error('上传失败');
			}
		},
		error:function(error){
			ct.warn(error.file.name+'：上传失败，'+error.type+':'+error.info);
		}
	});
}
function imgurl(f, abs){
	return abs ? (re_pre_upurl.test(f) ? f : (UPLOAD_URL+f)) : f.replace(re_pre_upurl, '');
}
$.fn.imageInput = function(thumb, abs){
	return this.each(function(){
		var input = $(this),
			up = $('<span class="button">上传图片</span>').insertAfter(input),
			file = $('<button type="button" class="button_style_1">图片库</button>').insertAfter(up),
			edit = $('<button type="button" class="button_style_1">编辑</button>').insertAfter(file);
		input.floatImg({url:UPLOAD_URL, width:200});
        function listen() {
            if (this.value) {
                edit.show();
            } else {
                edit.hide();
            }
        }
		input.bind('change', listen);
		input.bind('input', listen);
		input.bind('propertychange', listen);
		imgUploader(up, '?app=system&controller=upload&action=image&thumb='+(thumb?1:0), function(img){
			input.val(imgurl(img, abs)).trigger('change');
		});
		edit.click(function(){
            var options = input.data('editor-options') || {};
			ct.editImage(input.val(), options, function(json){
				input.val(imgurl(json.file, abs)).trigger('change');
			});
		});
		input.val() || edit.hide();
		file.click(function(){
			ct.fileManager(function(at){
				var f = at.src;
				input.val(imgurl(f, abs)).trigger('change');
			});
		});
	});
};
$.fn.photoInput = function(){
	return this.each(function(){
		var input = $(this),
			val = this.value,
			up = $('<span class="button">上传图片</span>').insertAfter(input),
			edit = $('<button type="button" class="button_style_1">编辑</button>').insertAfter(up),
			preview = $('<img width="120" src="'+UPLOAD_URL+'avatar/'+val+'" />').insertBefore(input);
		imgUploader(up, '?app=system&controller=upload&action=photo', function(img){
			input.val(img.replace(/^avatar\//,''));
			preview.attr('src', UPLOAD_URL+img).show();
			edit.show();
		});
		edit.click(function(){
			ct.editImage(UPLOAD_URL+'avatar/'+input.val(), function(json){
				var img = json.file;
				input.val(img.replace(/^avatar\//,''));
				preview.attr('src',UPLOAD_URL+img+'?'+Math.random()).show();
			});
		});
		val || (edit.hide(), preview.hide()); 
	});
};
})(cmstop,jQuery);