<?php $this->display('header', 'system');?>
<!--tree table-->
<link rel="stylesheet" type="text/css" href="<?php echo IMG_URL?>js/lib/treetable/style.css"/>
<script type="text/javascript" src="<?php echo IMG_URL?>js/lib/cmstop.treetable.js"></script>
<script type="text/javascript" src="<?=IMG_URL?>js/lib/cmstop.table.js"></script>
<!--contextmenu-->
<link rel="stylesheet" type="text/css" href="<?php echo IMG_URL?>js/lib/contextMenu/style.css" />
<script type="text/javascript" src="<?php echo IMG_URL?>js/lib/cmstop.contextMenu.js"></script>
<!--pagination-->
<link rel="stylesheet" type="text/css" href="<?php echo IMG_URL?>js/lib/pagination/style.css" />
<script type="text/javascript" src="<?php echo IMG_URL?>js/lib/jquery.pagination.js"></script>
<!--autocomplete-->
<link rel="stylesheet" type="text/css" href="<?=IMG_URL?>js/lib/autocomplete/style.css" />
<script src="<?=IMG_URL?>js/lib/cmstop.autocomplete.js" type="text/javascript"></script>
<script type="text/javascript" src="js/cmstop.tabnav.js"></script>
<script type="text/javascript" src="apps/system/js/openauth.js"></script>
<div class="bk_10"></div>
<div class="table_head">
	<div class="search_icon search f_r mar_r_8">
		<form id="search_f" onsubmit="return false;">
			<input type="text" size="32" style="width:230px" value="" name="keywords" placeholder="用户名或公钥" />
			<a title="搜索" onclick="App.table.load($('#search_f'));return false;" onfocus="this.blur()" style="outline:none;" href="javascript:;">搜索</a>
		</form>
	</div>
	<button type="button" class="button_style_2 f_l" onclick="App.add();  return false;">添加</button>
</div>
<div class="bk_8"></div>
<table width="98%" id="item_list" cellpadding="0" cellspacing="0"  class="tablesorter table_list mar_l_8" style="empty-cells:show;">
  <thead>
    <tr>
      <th width="30" class="bdr_3 t_c"><input type="checkbox" /></th>
      <th width="60"><div name="userid">ID</div></th>
      <th>用户名</th>
      <th width="260">公钥</th>
      <th width="260">私钥</th>
      <th width="70">状态</th>
      <th width="80">管理操作</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
<div class="table_foot">
  <div id="pagination" class="pagination f_r"></div>
  <p class="f_l">
    <input type="button" onclick="App.reload();" value="刷 新" class="button_style_1"/>
    <input type="button" onclick="App.del();" value="删 除" class="button_style_1"/>
  </p>
</div>
<!--右键菜单-->
<ul id="right_menu" class="contextMenu">
   <li class="edit"><a href="#App.edit">编辑</a></li>
   <li class="delete"><a href="#App.del">删除</a></li>
</ul>
<script type="text/javascript">
$.validate.setConfigs({
    xmlPath:'<?=ADMIN_URL?>apps/<?=$app?>/validators/<?=$controller?>/'
});
App.init('?app=<?=$app?>&controller=<?=$controller?>','<?=$pagesize?>');
</script>
<?php $this->display('footer', 'system');