<div class="bk_8"></div>
<form>
<table width="95%" border="0" cellspacing="0" cellpadding="0">
	<input type="hidden" name="style" value="<?php echo $data['style'];?>"/>
	<input type="hidden" name="number" value="<?php echo $data['number'];?>"/>
	<tbody>
		<tr>
			<th width="60">类型：</th>
			<td>
				<input name="data[type]" type="radio" id="share_bshare" value="bshare" <?php if($data['style'] == 'bshare') {echo 'checked';} ?>/>云平台分享代码
				<input name="data[type]" type="radio" id="share_cmstop" value="cmstop" <?php if($data['style'] == 'cmstop') {echo 'checked';} ?>/>CmsTop内置分享
			</td>
		</tr>
	</tbody>
	<tbody class="cmstop_share_panel">
		<tr>
			<th width="60">样式：</th>
			<td>
				<input name="data[style]" type="radio" id="share_button" value="button" <?php if($data['style'] == 'button' || $data['style'] == '') {echo 'checked';} ?>/> 按钮 
				<input name="data[style]" type="radio" id="share_float" value="float" <?php if($data['style'] == 'float') {echo 'checked';} ?>/> 浮动
				<input id="share_bshare_btn" name="data[style]" type="radio" <?php if($data['style'] == 'bshare') {echo 'checked';} ?> value="bshare" style="visibility:hidden;" />
			</td>
		</tr>
		<tr>
			<th>样式选择：</th>
			<td>
				<table width="95%" border="0" cellspacing="0" cellpadding="0">
					<tbody rel="button" <?php echo ($data['style'] == 'button' || $data['style'] == '')?'':'style="display:none;"'; ?>>
						<tr>
							<td><input type="radio" name="data[number]" value="b2" /> <label><img src="<?php echo $path.'b2.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="b1"/> <label><img src="<?php echo $path.'b1.gif';?>"/></label></td>
						</tr>
						<tr>
							<td><input type="radio" name="data[number]" value="b0"/> <label><img src="<?php echo $path.'b0.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="b3"/> <label><img src="<?php echo $path.'b3.gif';?>"/></label></td>
						</tr>
					</tbody>
					<tbody  rel="float" <?php if($data['style'] != 'float') {echo 'style="display:none;"';} ?>>
						<tr>
							<td><input type="radio" name="data[number]" value="f0"/></td>
							<td><label><img src="<?php echo $path.'f0.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="f1"/></td>
							<td><label><img src="<?php echo $path.'f1.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="f2"/></td>
							<td><label><img src="<?php echo $path.'f2.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="f3"/></td>
							<td><label><img src="<?php echo $path.'f3.gif';?>"/></label></td>
						</tr>
						<tr>
							<td><input type="radio" name="data[number]" value="f4"/></td>
							<td><label><img src="<?php echo $path.'f4.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="f5"/></td>
							<td><label><img src="<?php echo $path.'f5.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="f6"/></td>
							<td><label><img src="<?php echo $path.'f6.gif';?>"/></label></td>
							<td><input type="radio" name="data[number]" value="f7"/></td>
							<td><label><img src="<?php echo $path.'f7.gif';?>"/></label></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</form>
<script type="text/javascript">
var cloud_share = <?php echo $cloud_share ? 'true' : 'false';?>;
var share_type = $('[name=data[type]]');
if (share_type.eq(':checked').length == 0) {
	if (cloud_share) {
		share_type.eq(0).click();
		$('tbody.cmstop_share_panel').hide();
		$('#share_bshare_btn').click();
	} else {
		share_type.eq(1).click();
	}
}
</script>