<div id="created_x" class="th_pop" style="display:none;width:150px">
	<div>
		<a href="javascript: tableApp.load('created_min=<?=date('Y-m-d', TIME)?>');">今日</a> |
		<a href="javascript: tableApp.load('created_min=<?=date('Y-m-d', strtotime('yesterday'))?>&created_max=<?=date('Y-m-d', strtotime('yesterday'))?>');">昨日</a> | 
		<a href="javascript: tableApp.load('created_min=<?=date('Y-m-d', date::this_week(true))?>');">本周</a> |
		<a href="javascript: tableApp.load('created_min=<?=date('Y-m-01', strtotime('this month'))?>');">本月</a>
	</div>
	<ul>
		<?php  for ($i=2; $i<=7; $i++) { 
			$createdate = date('Y-m-d', strtotime("-$i day"));?>
		<li><a href="javascript: tableApp.load('created_min=<?=$createdate?>&created_max=<?=$createdate?>');"><?=$createdate?></a></li>
		<?php } ?>
	</ul>
</div>
<table width="98%" cellpadding="0" cellspacing="0" id="item_list" class="tablesorter table_list mar_l_8">
	<thead>
		<tr>
		<th width="30" class="t_l bdr_3"><input type="checkbox" id="check_all" class="checkbox_style"/></th>
		<th>标题</th>
		<th width="80">管理操作</th>
		<th width="80">发布人</th>
		<th width="120" class="ajaxer"><em class="more_pop" name="created_x"></em><div name="published">发布时间</div></th>
		</tr>
	</thead>
	<tbody id="list_body"></tbody>
</table>
<div class="table_foot">
	<div id="pagination" class="pagination f_r"></div>
	<div class="f_r"> 共有<span id="pagetotal">0</span>条记录&nbsp;&nbsp;&nbsp;每页
	<input type="text" name="pagesize" size="3" id="pagesize" value=""/>条&nbsp;&nbsp;</div>
	<p class="f_l">
		<input type="button" name="refresh" onclick="tableApp.load();" value="刷新" class="button_style_1"/>
	</p>
</div>

<script type="text/javascript">
var manage_td = '<a href="{url}" target="_blank"><img src="images/view.gif" alt="访问" width="16" height="16" /></a>';
var row_template  = '<tr id="row_{contributionid}" right_menu_id="right_menu_{status}">';
	row_template += '	<td><input type="checkbox" class="checkbox_style" name="chk_row" id="chk_row_{contributionid}" value="{contributionid}" /></td>';
	row_template += '	<td><a href="javascript:contribution.view({contributionid});" title="查看内容"><div class="icon article"></div></a> <a data-cate="{catid}" href="javascript:tableApp.load(\'catid={catid}\');">[{catname}]</a> <a href="javascript:contribution.view({contributionid});" >{title}</a> </td>';
	row_template += '	<td class="t_c" id="manage_{contributionid}" name="manage" value="manage">'+manage_td+'</td>';
	row_template += '	<td class="t_c"><a href="javascript:url.member({publishedby})">{publishedbyname}</a></td>';
	row_template += '	<td class="t_c">{published}</td>';
	row_template += '</tr>';
</script>