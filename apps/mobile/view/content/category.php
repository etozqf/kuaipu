<div id="categorylist">
    <form action="?app=mobile&controller=content&action=pushmobile" method="POST">
        <input type="hidden" name="contentid" value="<?=$contentid?>" />
        <div class="tree" id="category" idv="tree" style="position:absolute;z-index:3;">
            <ul style="display: block;">
                <?php foreach($data as $key => $value):?>
                <li idv="<?=$value['catid']?>">
                    <div class="itemarea">
                        <b class="bitarea"></b>
                        <span id="<?=$value['catid']?>" class="txtarea"><input type="radio" name="catid" value="<?=$value['catid']?>" class="radio_style"><label><?=$value['catname']?></label></span>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </form>
</div>
