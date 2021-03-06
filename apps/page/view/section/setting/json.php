<form method="POST" action="?app=page&controller=section&action=property">
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form">
        <tr>
            <th width="72"><span class="c_red">*</span> 名称：</th>
            <td>
                <input type="text" name="name" value="<?=$section['name']?>" maxlength="30" size="20"/>
                <input type="hidden" name="sectionid" value="<?=$section['sectionid']?>" />
            </td>
        </tr>
        <tr>
            <th><span class="c_red">*</span> JSON 源：</th>
            <td><input type="text" name="url" style="width:345px;" value="<?=$section['url']?>" /></td>
        </tr>
        <tr>
            <th><span class="c_red">*</span> 模板代码：</th>
            <td>
                <textarea name="data" class="code" wrap="off" style="overflow-x:auto;width:345px;height:100px;"><?=htmlspecialchars($section['data'])?></textarea>
            </td>
        </tr>
        <tr>
            <th>更新频率：</th>
            <td>
                <input type="text" name="frequency" value="<?=$section['frequency']?>" size="5" /> 秒 （0表示手动）
            </td>
        </tr>
        <tr>
            <th>备注：</th>
            <td><textarea placeholder="备注用于在编辑维护区块时提示区块所需数据的规格参数，如缩略图大小，标题长度等" name="description" style="width:345px;height:35px;padding:0;margin:0;"><?=$section['description']?></textarea></td>
        </tr>
    </table>
</form>
<div class="bk_5"></div>