<?php $this->display('header', 'system'); ?>

<link rel="stylesheet" href="apps/mobile/css/base.css" />
<link rel="stylesheet" type="text/css" href="/apps/mobile/css/style.css">

<script type="text/javascript" src="apps/mobile/js/signature.js"></script>

<div class="mobile-style-sider f_l">
    <div class="mobile-style-sider-title">风格列表</div>
    <div id="sider">
        <a href="?app=mobile&controller=setting&action=style&model=bar" model="bar">上下栏</a>
        <a href="?app=mobile&controller=setting&action=style&model=drawer" model="drawer">抽屉式</a>
        <div class="mobile-style-sider-list">显示设置</div>
        <a href="javascript:;" class="current">列表布局</a>
        <hr />
    </div>
</div>
<div class="f_l">
<form action="?app=mobile&controller=setting&action=display" method="POST" class="validator mar_t_8">
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mar_l_8">
        <caption style="margin-top:0;margin-bottom:0;">新闻列表默认设置</caption>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">缩略图对齐方式：</th>
            <td>
                <label><input type="radio" name="config[thumb_align]" value="left"<?=form_element::checked($setting['thumb_align'] == 'left')?> /> 左对齐</label>
                <label><input type="radio" name="config[thumb_align]" value="right"<?=form_element::checked(!$setting['thumb_align'] || $setting['thumb_align'] == 'right')?> /> 右对齐</label>
            </td>
        </tr>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">组图缩略图方式：</th>
            <td>
                <label><input type="radio" name="config[picture_style]" value="list"<?=form_element::checked(!$setting['picture_style'] || $setting['picture_style'] == 'list')?> /> 图文列表</label>
                <label><input type="radio" name="config[picture_style]" value="banner"<?=form_element::checked($setting['picture_style'] == 'banner')?> /> 多图列表</label>
            </td>
        </tr>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">专题缩略图方式：</th>
            <td>
                <label><input type="radio" name="config[special_style]" value="list"<?=form_element::checked(!$setting['picture_style'] || $setting['special_style'] == 'list')?> /> 图文列表</label>
                <label><input type="radio" name="config[special_style]" value="banner"<?=form_element::checked($setting['special_style'] == 'banner')?> /> 通栏列表</label>
            </td>
        </tr>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">链接缩略图方式：</th>
            <td>
                <label><input type="radio" name="config[link_style]" value="list"<?=form_element::checked(!$setting['picture_style'] || $setting['link_style'] == 'list')?> /> 图文列表</label>
                <label><input type="radio" name="config[link_style]" value="banner"<?=form_element::checked($setting['link_style'] == 'banner')?> /> 通栏列表</label>
            </td>
        </tr>
    </table>
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mar_l_8">
        <caption style="margin-top:0;margin-bottom:0;">标题设置</caption>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">行数：</th>
            <td>
                <select name="config[title_number]">
                    <option value="1" <?php if($setting['title_number'] == 1):?>selected="selected" <?php endif;?>>1行</option>
                    <option value="2" <?php if($setting['title_number'] == 2):?>selected="selected" <?php endif;?>>2行</option>
                    <option value="3" <?php if($setting['title_number'] == 3):?>selected="selected" <?php endif;?>>3行</option>
                </select>
            </td>
        </tr>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">字号：</th>
            <td>
                <label><input type="text" name="config[title_size]" value="<?=$setting['title_size']?>" style="width:30px;" /><span style="margin-left: 10px;">字号要在10~24之间</span></label>
            </td>
        </tr>
    </table>
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mar_l_8">
        <caption style="margin-top:0;margin-bottom:0;">简介设置</caption>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">是否显示简介：</th>
            <td>
                <label><input type="radio" name="config[description_open]" value="1"<?=form_element::checked($setting['description_open'])?> /> 是</label>
                <label><input type="radio" name="config[description_open]" value="0"<?=form_element::checked(!$setting['description_open'])?> /> 否</label>
            </td>
        </tr>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">行数：</th>
            <td>
                <select name="config[description_number]">
                    <option value="1" <?php if($setting['description_number'] == 1):?>selected="selected" <?php endif;?>>1行</option>
                    <option value="2" <?php if($setting['description_number'] == 2):?>selected="selected" <?php endif;?>>2行</option>
                </select>
            </td>
        </tr>
        <tr>
            <th width="160" style="vertical-align: top; padding-top: 5px;">字号：</th>
            <td>
                <label><input type="text" name="config[description_size]" value="<?=$setting['description_size']?>" style="width:30px;" /><span style="margin-left: 10px;">字号要在10~24之间</span></label>
            </td>
        </tr>
    </table>
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mar_l_8">
        <tr>
            <th width="160">&nbsp;</th>
            <td>
                <div class="bk_8"></div>
                <input type="submit" id="submit" value="保存" class="button_style_2"/>
            </td>
        </tr>
    </table>
</form>
</div>

<script type="text/javascript">
    $(function() {
        $('form').ajaxForm(function(json) {
            if (json && json.state) {
                ct.tips('保存成功');
            } else {
                ct.error(json && json.error || '保存失败');
            }
        });
    });
</script>