(function(){

function createItem(json, i){
	var item = $(
	'<div class="list-item">'+
		'<div class="list-ctrl">'+
			'<span class="num">'+i+'</span>'+
			'<a class="ctrl pick" title="选取数据"></a>'+
			'<a class="ctrl up" title="上移"></a>'+
			'<a class="ctrl down" title="下移"></a>'+
			'<a class="ctrl remove" title="移除"></a>'+
		'</div>'+
		'<div class="list-detail">'+
			'<input type="text" class="title" name="list[title][]" value="'+(json.title||'')+'" />'+
			'<input type="text" class="url" name="list[url][]"  value="'+(json.url||'')+'" />'+
			'<input type="text" class="time" name="list[time][]" value="'+(json.date||json.time||'')+'" />'+
		'</div>'+
		'<div class="clear"></div>'+
	'</div>');
	return item;
}
function fillItem(item, json) {
	var c = item.find('input');
	json.title && c.filter('[name="list[title][]"]').val(json.title);
	json.url && c.filter('[name="list[url][]"]').val(json.url);
	json.date && c.filter('[name="list[time][]"]').val(json.date);
}
var ctrlFunc = {
	up:function(item){
		moveItem(item, -1);
	},
	down:function(item){
		moveItem(item, 1);
	},
	remove:function(item){
		var adder = item.next();
		item.slideUp(160,function(){
			item.remove();
			adder.nextAll('.list-item').each(function(){
				var s = $('span.num', this);
				s.text(parseInt(s.text()) - 1);
			});
			adder.remove();
		});
	},
	pick:function(item){
		$.datapicker({
			picked:function(items){
				fillItem(item, items[0]);
			},
			multiple:false
		});
	}
};
function prepareItem(item) {
	item.after(createAdder());
	item.find('a.ctrl').click(function(){
		ctrlFunc[this.className.substr(5)](item);
	});
	item.find(':text,textarea').focus(function(){
		this.style.cssText = 'background-image:none';
	}).blur(function(){
		this.value == '' && ( this.style.cssText = '');
	}).each(function(){
		this.value != '' && (this.style.cssText = 'background-image:none');
	});
    ct.widget.dragSort(item.parent());
}
function moveItem(item, direct) {
	var tar = item[direct > 0 ? 'nextAll' : 'prevAll']('.list-item:first');
	if (! tar.length || item.is(':animated') || tar.is(':animated')) return;
	var a1 = $(document.createElement('div')).css('height', item[0].offsetHeight),
		a2 = $(document.createElement('div')).css('height', tar[0].offsetHeight),
		s1 = item.find('span.num'), s2 = tar.find('span.num'),
		num1 = s1.text(), num2 = s2.text(),
		pos1 = item.position(), pos2 = tar.position(),
		st = item.offsetParent()[0].scrollTop;
	item.css({position:'absolute',top:pos1.top+st,left:pos1.left,zIndex:2}).after(a1);
	tar.css({position:'absolute',top:pos2.top+st,left:pos2.left,zIndex:1}).after(a2);
	item.animate({top:pos2.top+st},160,function(){
		a2.replaceWith(item);
		s1.text(num2);
		item.css({position:'',zIndex:'',top:'',left:''});
	});
	tar.animate({top:pos1.top+st},160,function(){
		a1.replaceWith(tar);
		s2.text(num1);
		tar.css({position:'',zIndex:'',top:'',left:''});
	});
}
function createAdder(){
	var adder = $('<div class="list-sepr"><div class="list-insert" title="插入一行"></div></div>').click(function(){
		var n = adder.prevAll('.list-item').length + 1;
		adder.nextAll('.list-item').each(function(i){
			$('span.num', this).text(i+1+n);
		});
		var item = createItem({}, n).hide();
		adder.after(item);
		item.slideDown(160);
		prepareItem(item);
	});
	return adder;
}
function setTemplate(dialog, form, engine) {
	var url = '?app=special&controller=online&action=getTemplate&engine='+engine;
	var a = dialog.find('#template').click(function(){
		var textarea = $('<textarea style="width:100%;" wrap="off" name="template" ></textarea>');
		a.replaceWith(textarea);
		textarea.editplus({
			buttons: 'fullscreen,wrap,|,loop,ifelse,elseif',
			height:150
		});
		if (form[0].widgetid && form[0].widgetid.value) {
			url += '&widgetid='+form[0].widgetid.value;
		}
		$.get(url, function(html){
			textarea.val(html);
		});
	});
}
var _init = {
	0:function(form, dialog){},
	1:function(form, dialog){
		var listArea = dialog.find('div.list-area'),
			items = (new Function("return " + listArea.text()))();
		listArea.html(createAdder());
		items && items.length && setTimeout(function(){
			for (var i=0,t;t=items[i++];) {
				var item = createItem(t, i);
				listArea.append(item);
				prepareItem(item);
			}
			dialog.dialog('option','position','center');
		}, 0);
		dialog.find('#adder').click(function(){
			$.datapicker({
				picked:function(items){
					var n = listArea.children('.list-item').length;
					for (var i=0,t;t=items[i++];) {
						var item = createItem(t, n+i);
						listArea.append(item);
						prepareItem(item);
					}
				},
				multiple:true
			});
		});
		dialog.find('#clear').click(function(){
			ct.confirm('确定要清空吗？',function(){
				listArea.empty().append(createAdder());
			});
		});
	},
	2:function(form, dialog, tbody){
		DIY.initPort('list', form, tbody);
	}
};
DIY.registerEngine('list', {
	dialogWidth:500,
    support:['morelist'],
	addFormReady:function(form, dialog) {
		DIY.tabs(dialog,function(i, tbody){
			(i == 1) ? $('#autoListConfig').hide() : $('#autoListConfig').show();
			form[0].method.value = i;
			if (! $.data(this, 'inited')) {
				$.data(this, 'inited', 1);
				_init[i](form, dialog, tbody);
			}
		});
		setTemplate(dialog, form, 'list');
	},
	editFormReady:function(form, dialog) {
		DIY.tabs(dialog,function(i, tbody){
			(i == 1) ? $('#autoListConfig').hide() : $('#autoListConfig').show();
			form[0].method.value = i;
			if (! $.data(this, 'inited')) {
				$.data(this, 'inited', 1);
				_init[i](form, dialog, tbody);
			}
		}, form[0].method.value);
		setTemplate(dialog, form, 'list');
	},
	afterRender:function(widget){},
	beforeSubmit:function(form, dialog) {
		form.find('tbody:hidden')
		.find('input,select,textarea').each(function(){
			if (!this.disabled) {
				this.setAttribute('notsubmit','1');
				this.disabled = true;
			}
		});
	},
	afterSubmit:function(form, dialog){
		form.find('tbody:hidden')
			.find('input,select,textarea')
			.filter('[notsubmit]').removeAttr('disabled');
	}
});
})();