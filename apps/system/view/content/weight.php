<title>修改权重</title>
<link rel="stylesheet" type="text/css" href="css/admin.css"/>
<script type="text/javascript" src="<?php echo IMG_URL?>js/lib/jquery.js"></script>
<script type="text/javascript" src="<?php echo IMG_URL?>js/cmstop.js"></script>
<link href="<?=IMG_URL?>js/lib/autocomplete/style.css" rel="stylesheet" type="text/css" />
<link href="<?=IMG_URL?>js/lib/colorInput/style.css" rel="stylesheet" type="text/css" />

<div class="bk_8"></div>
<div style="margin:20px 0px 25px 15px;text-align:center">
<table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form" >
		<th><?=element::tips('权重将决定文章在哪里显示和排序')?> 权重：</th>
		<td><?=element::weight(60);?></td>
</table>		
<div id="errorbox" style="margin:8px;"></div>
</div>

<div class="btn_area">
    <button type="button" action="ok" class="button_style_1">确定</button>
    <button type="button" action="cancel" class="button_style_1">取消</button>
</div>

<script type="text/javascript">
$(function(){
	var weight = $("input[name=weight]").val();
	$('.tips').attrTips('tips', 'tips_green', 160, 'top');
	$("input[name=weight]").bind('change',function(){
		weight = $(this).val();
	});
	$('.btn_area [action=ok]').click(function() {
		var weight = $("input[name=weight]").val();
	    if (window.dialogCallback && dialogCallback.picked) dialogCallback.picked(weight);
	    return false;
	});
	$('.btn_area [action=cancel]').click(function() {
	    getDialog().dialog('close');
	    return false;
	});
	$('.bubble').attr('style','width:122px;left:16px;top:70px');
	$('.point').attr('class','point SW');
});	
</script>