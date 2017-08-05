<div class="bk_8"></div>
<form id="setting_form" action="?app=baoliao&controller=setting&action=editfield" method="post">
	<table class="table_form" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<th width="120">字段名称</th>
			<td><input class="w_160" type="text" name="name" value="<?=$name?>" /></td>
		</tr>
        <tr>
            <th width="120">变量名</th>
            <td><input class="w_160" type="text" name="key" value="<?=$key?>" /></td>
        </tr>
	</table>
</form>