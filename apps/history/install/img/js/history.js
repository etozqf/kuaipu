//js文件只运行一次
$(function (){
	if($('#history_index').length < 1) {
		//js调用方式,首次加载
		includeCalendar();
	}else{
		history_init();	//include shtml方式
	}
	if($('#calendarBox:hidden').length > 0){

	}
});
function includeCalendar()
{
	var alias = false;
	var sc;
	$('script[src]').each(function (i, e){
		if(e.src.indexOf('history.js#') != -1)
		{
			alias = /history.js\#([\w]+)/.exec(e.src);
			alias = alias[1];
			if(alias) {
				sc = $(e);
			}
		}
	});
	if(!alias) return;
	var url = '/section/history/' + alias + '/calendar.html';
	$.get(url, function (data){
		if(data.length > 1000) {
			sc.replaceWith(data);
			history_init();
		}
	});
}
function history_init()
{
	$('#history_index').click(function (){
		if($('#calendarBox:hidden').length > 0) {
			var boxleft = $(window).width()-(($(window).width()-1000)/2+$('.js-headsearch').width()+$('.m-header-rss').width()+$('.m-header-user').width()+$('#history_index').width()+35);
			if ($('.header-search-input:visible').length > 0) {
				boxleft = boxleft-$('#head_wd').width()-6;
			}
			$('#calendarBox:hidden').css('left', boxleft+'px').css('width', '350px').css('height', '220px');
			$(document).unbind('click');
			$('#calendarBox').fadeIn('normal', function (){
				$(document).one('click', function (){
					$('#calendarBox').fadeOut('normal');
					$('#history_index').removeClass('active');
				});				
				$('#history_index').addClass('active');
			});
		}
	});
	$('#calendarBox').click(function (e){
		e.stopPropagation();	//点击日历框内部时,不触发$(document).click事件
	});
	$('#calendarList>li>a').click(function (){
		if(this.href == 'javascript:;') return false;
	});
	$('#preMonth, #nextMonth, #preYear, #nextYear').click(function (){
		loadCalendar(this.href);
		return false;
	});
	
	//加载小时段
	hourDiv();
}
function hourDiv()
{
	var path = location.pathname;
	if(path.indexOf('history') > 0) {
		// /2010-03/04-10.shtml
		var regex = /(\d{4})-(\d\d)\/(\d+)-(\d+)/;
		var date = regex.exec(path);
			
		var url = APP_URL+'?app=history&controller=history&action=getHours&jsoncallback=?';
		var get = {alias: $('#history_index').attr('alias'), year: date[1], month: date[2], day: [date[3]]};
		$.getJSON(url, get, function (data){
			if(data.length < 2) return ;
			$('#hoursDiv').remove();
			$('body').prepend('<div id="hoursDiv">'+date[1]+'年'+date[2]+'月'+date[3]+'日:</div>');
			for(k in data) {
				var url = path.replace(/\d\d\.shtml/, data[k] + '.shtml');
				var a = $('<a></a>').text(data[k]).attr('href', url).attr('target', '_self');
				$('#hoursDiv').append(a);
				if(data[k] == date[4]) a.addClass('current');
			}
			if(date[1] + '年' + date[2] + '月' == $('#calendarBox div.cu_month').text()) {
				return ;
			}
			
			//var url = WWW_URL + 'section/history/' + $('#history_index').attr('alias') + '/' + date[1] + '-' + date[2] + '.html';
			//loadCalendar(url);
		});
	}
}

//载入月份片段
function loadCalendar(url)
{
	$.get(url, function (data){
		if(data.length > 1000) {
			var calendarBox = document.getElementById('calendarBox');
			var cparent = calendarBox.parentNode;
			cparent.removeChild(calendarBox);
			cparent.innerHTML += data;
			history_init();
			var boxleft = $(window).width()-(($(window).width()-1000)/2+$('.js-headsearch').width()+$('.m-header-rss').width()+$('.m-header-user').width()+$('#history_index').width()+35);
			$('#calendarBox:hidden').css('left', boxleft+'px').css('width', '350px').css('height', '220px');
			$('#calendarBox').fadeIn('normal');
		}
	});
}