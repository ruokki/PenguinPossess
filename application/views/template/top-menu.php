<div id="topMenu">
    <div class="menu">
        <?php echo implode('</div><div class="menu">', $categories); ?>
    </div>
    <div class="menu">
        <a href="<?php echo site_url('user/index'); ?>" <?php if($active === 'user') { echo 'class="active"'; } ?>>Mon compte</a>
    </div>
</div>