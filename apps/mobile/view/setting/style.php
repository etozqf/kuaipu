<?php $this->display('header', 'system'); ?>

<!-- color picker -->
<link href="<?php echo IMG_URL;?>js/lib/colorInput/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo IMG_URL;?>js/lib/cmstop.colorInput.js" type="text/javascript"></script>

<!-- uploader -->
<script type="text/javascript" src="uploader/cmstop.uploader.js"></script>
<script type="text/javascript" src="apps/mobile/js/lib/uploader.js"></script>

<link rel="stylesheet" type="text/css" href="/apps/mobile/css/base.css">
<link rel="stylesheet" type="text/css" href="/apps/mobile/css/style.css">

<link rel="stylesheet" type="text/css" href="<?php echo IMG_URL;?>js/lib/jquery-ui/dialog.css">
<script type="text/javascript" src="<?php echo IMG_URL;?>js/lib/json2.js"></script>

<script type="text/javascript" src="apps/mobile/js/signature.js"></script>

<script type="text/javascript">
	var styles = <?php echo json_encode(array_values($styles));?>;
    var colorstyle = "<?php echo $setting['style']['nav']?>";
    var model = "<?php echo $setting['id'];?>";
</script>

<div class="mobile-style-sider f_l">
	<div class="mobile-style-sider-title">风格列表</div>
	<div id="sider">
        <a href="javascript:;" model="bar" <?php if ($setting['id'] == 'bar'): ?>class="current"<?php endif;?>>上下栏</a>
        <a href="javascript:;" model="drawer" <?php if ($setting['id'] == 'drawer'): ?>class="current"<?php endif;?>>抽屉式</a>
        <div class="mobile-style-sider-list">显示设置</div>
        <a href="?app=mobile&controller=setting&action=display" class="">列表布局</a>
        <hr />
	</div>
</div>
<div class="mobile-style-main f_l">
    <div class="mobile-style-color">
        <div class="color-title">主题颜色</div>
        <div class="color-content">
            <?php foreach ($styles as $value) :?>
            <?php $val = json_decode($value['data'], true);
                $colors[] = $val['nav'];
            ?>
            <span style="background-color:<?=$val['nav']?>;border-color:<?=$val['nav']?>;"  class="<?php if ($setting['style']['nav'] == $val['nav'] || !$setting['style']['nav']): ?> now<?php endif;?>" color="<?=$val['nav']?>"><img style="display: none;" src="apps/mobile/images/checked.png" /></span>
            <?php endforeach;?>
        </div>
        <div class="color-custom">
            <div class="f_l">自定义：</div>
            <div class="f_l">
                <a class="other color" color="<?php if($setting['style']['nav'] && !in_array($setting['style']['nav'], $colors)){ echo $setting['style']['nav']; }?>"></a>
            </div>
        </div>
    </div>
    <div class="mobile-style-demo f_l">
        <div id="demo" class="mobile-style-iphone">
            <div id="demo-nav">
                <img class="nav_bar" <?php if ($setting['id'] != 'bar'): ?>style="display:none;"<?php endif;?> src="apps/mobile/images/bar.png" width="250" height="42" />
                <img class="nav_drawer" <?php if ($setting['id'] != 'drawer'): ?>style="display:none;"<?php endif;?>src="apps/mobile/images/drawer.png" width="250" height="42" />
            </div>
            <div class="mobile-style-demo-thumb">
                <img class="bg_drawer" <?php if ($setting['id'] != 'drawer'): ?>style="display:none;"<?php endif;?> src="apps/mobile/images/drawer_background.png" alt="" width="252" height="359" />
                <img class="bg_bar" <?php if ($setting['id'] != 'bar'): ?>style="display:none;"<?php endif;?> src="apps/mobile/images/bar_background.png" alt="" width="252" height="359" />
            </div>
        </div>
    </div>
    <div class="mobile-style-setting f_l">
        <div class="bk_20"></div>
        <form id="style-form">
            <input type="hidden" name="id" value="" />
            <input type="hidden" name="style[nav]" data-role="nav" class="mar_l_8" value="<?=$setting['style']['nav']?>" />
            <input type="hidden" name="style[button0]" data-role="button0" class="mar_l_8" value="<?=$setting['style']['button0']?>" />
            <input type="hidden" name="style[button1]" data-role="button1" class="mar_l_8" value="<?=$setting['style']['button1']?>" />

                <div class="background" <?php if($setting['id'] != 'drawer'):?>style="display:none;"<?php endif;?>>
                    <div class="bgtitle">背景图片</div>
                    <div class="bgcontent">
                        <?php foreach ($styles as $value) :?>
                        <?php $val = json_decode($value['data'], true);
                            $bakground=$val['background']['1242*2208'];
                            $idcolor = str_replace('#', '', $val['nav']);
                            if ($setting['style']['nav'] == $val['nav'] && is_array($setting['style']['background']) && $setting['style']['background'][$idcolor]) {
                                $nowbackground = thumb($setting['style']['background'][$idcolor]);
                            }
                        ?>
                        <div class="mobile-style-bg-panel" id="<?=$idcolor?>" <?php if($setting['style']['nav'] && $setting['style']['nav'] != $val['nav']):?>style="display:none;"<?php endif;?>>
                            <input type="hidden" name="style[background][<?=$idcolor?>]" value="<?php if($nowbackground){echo $nowbackground;}else{echo $bakground;}?>" />
                            <img src="<?php if($nowbackground){echo $nowbackground;}else{echo $bakground;}?>" alt="" />
                            <div class="mobile-style-bg-upload"></div>
                        </div>
                        <?php $nowbackground = '';?>
                        <?php endforeach;?>
                        <?php
                            if ($setting['style']['background']['othercolor']) {
                                $nowbackground = thumb($setting['style']['background']['othercolor']);
                            }
                        ?>
                        <div class="mobile-style-bg-panel" id="othercolor" <?php if($setting['style']['nav'] && in_array($setting['style']['nav'], $colors)):?>style="display:none;"<?php endif;?>>
                            <input type="hidden" name="style[background][othercolor]" value="<?php if($nowbackground){echo $nowbackground;}else{echo $bakground;}?>" />
                            <img src="<?php if($nowbackground){echo $nowbackground;}else{echo $bakground;}?>" alt="" />
                            <div class="mobile-style-bg-upload"></div>
                        </div>
                    </div>
                </div>
            <div id="save" class="mobile-style-save">保存并使用</div>
        </form>
    </div>
    <div id="new-style-name" style="display:none;">
        <p>新增风格名称 <input type="text" id="newstylename" style="width:235px;" /></p>
    </div>
</div>

<script type="text/javascript" src="apps/mobile/js/setting.style.js"></script>  