<?php $this->display('header', 'system'); ?>

<link rel="stylesheet" href="apps/mobile/css/base.css" />
<link rel="stylesheet" href="apps/mobile/css/ad.css" />

<script type="text/javascript" src="uploader/cmstop.uploader.js"></script>
<script type="text/javascript" src="apps/mobile/js/lib/uploader.js"></script>
<script type="text/javascript" src="js/cmstop.filemanager.js"></script>
<script type="text/javascript" src="apps/mobile/js/signature.js"></script>
<script type="text/javascript" src="imageEditor/cmstop.imageEditor.js"></script>

<div class="bk_8"></div>

<?php $this->display('ad/menu');?>

<div class="ad-content">
    <h3>启动画面</h3>
    <form id="form" action="?app=mobile&controller=ad&action=index" method="POST" class="validator">
        <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mobile_adm">
            <caption>手机版</caption>
            <tbody data-role="link">
            <tr>
                <th>广告图片：</th>
                <td>
                    <?php $logo_value = $setting['bootstrap']['mobile']['logo']; ?>
                    <div class="ui-bootstrap-logo-item">
                        <input type="hidden" name="config[bootstrap][mobile][logo]" value="<?=$logo_value?>" />
                        <div class="ui-bootstrap-logo-item-img">
                            <?php if ($logo_value): ?>
                                <img src="<?=abs_uploadurl($logo_value)?>" width="100" height="150" />
                            <?php else: ?>
                                <div class="ui-bootstrap-logo-item-img-empty"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>广告链接：</th>
                <td><input type="text" size="62" name="config[bootstrap][mobile][link]" value="<?=$setting['bootstrap']['mobile']['link']?>" style="width:400px;" /></td>
            </tr>
            </tbody>
        </table>
        <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mobile_adm">
            <caption>Pad版</caption>
            <tbody data-role="link">
            <tr>
                <th>广告图片：</th>
                <td>
                    <?php $logo_value = $setting['bootstrap']['pad']['logo']; ?>
                    <div class="ui-bootstrap-logo-item">
                        <input type="hidden" name="config[bootstrap][pad][logo]" value="<?=$logo_value?>" />
                        <div class="ui-bootstrap-logo-item-img">
                            <?php if ($logo_value): ?>
                                <img src="<?=abs_uploadurl($logo_value)?>" width="100" height="150" />
                            <?php else: ?>
                                <div class="ui-bootstrap-logo-item-img-empty"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>广告链接：</th>
                <td><input type="text" size="62" name="config[bootstrap][pad][link]" value="<?=$setting['bootstrap']['pad']['link']?>" style="width:400px;" /></td>
            </tr>
            </tbody>
        </table>
        <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table_form mobile_adm">
            <caption>Pad横屏版</caption>
            <tbody data-role="link">
            <tr>
                <th>广告图片：</th>
                <td>
                    <?php $logo_value = $setting['bootstrap']['crosspad']['logo']; ?>
                    <div class="ui-bootstrap-logo-item">
                        <input type="hidden" name="config[bootstrap][crosspad][logo]" value="<?=$logo_value?>" />
                        <div class="ui-bootstrap-logo-item-img">
                            <?php if ($logo_value): ?>
                                <img src="<?=abs_uploadurl($logo_value)?>" width="100" height="150" />
                            <?php else: ?>
                                <div class="ui-bootstrap-logo-item-img-empty"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>广告链接：</th>
                <td><input type="text" size="62" name="config[bootstrap][crosspad][link]" value="<?=$setting['bootstrap']['crosspad']['link']?>" style="width:400px;" /></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <th>&nbsp;</th>
                <td><input type="submit" id="submit" value="保存" class="button_style_2"/></td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<script type="text/javascript" src="apps/mobile/js/adm/index.js"></script>
