<form id="text_edit" method="post" action="?app=<?=$app?>&controller=<?=$controller?>&action=<?=$action?>">
	<input type="hidden" name="questionid" value="<?=$questionid?>" />
    <input type="hidden" name="contentid" value="<?=$contentid?>" />
	<input type="hidden" name="type" value="<?=$type?>" />
	<table border="0" cellspacing="0" cellpadding="0" class="table_form">
	  <tr>
		<th width="80"><span class="c_red">*</span> 标题：</th>
		<td><input type="text" name="subject" id="subject" class="bdr inputtit_focus" size="60" maxlength="80" value="<?=$subject?>" maxlength="80" /></td>
	  </tr>
	  <tr>
		<th>图片：</th>
		<td><table border="0" cellspacing="2" cellpadding="0"><tr><td><input type="text" name="image" id="image" size="30" value="<?=$image?>" /></td><td><span id="uploadimage" class="uploader"></span></td></tr></table></td>
	  </tr>
	  <tr>
		<th>说明：</th>
		<td><input name="description" id="description" type="text" size="60" value="<?=$description?>" /></td>
	  </tr>
	  <tr>
		<th>最大字节数：</th>
		<td><input type="text" name="maxlength" id="maxlength" size="5" value="<?php echo $maxlength;?>" /> MB（0表示不限）</td>
	  </tr>
	  <tr>
		<th>数据校验：</th>
		<td><input type="checkbox" name="validator" value="image/*"<?php if($validator=='image/*'):?>  checked="checked"<?php endif;?> /> 图片</td>
	  </tr>
	  <tr>
		<th>必填：</th>
		<td><input type="checkbox" id="required" name="required" value="1" class="bdr_5" <?=$required ? 'checked' : ''?>/> 是</td>
	  </tr>
	</table>
</form>