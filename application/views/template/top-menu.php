<div id="mainMenu">
    <div>
        <div class="menu">
            <a href="<?php echo site_url('home/index'); ?>" <?php if($active === 'home') { echo 'class="active"'; } ?>>Accueil</a>
        </div>
        <div class="menu">
            <a href="<?php echo site_url('user/index'); ?>" <?php if($active === 'user') { echo 'class="active"'; } ?>>Mon compte</a>
        </div>
        <div class="menu">
            <?php echo implode('</div><div class="menu">', $categories); ?>
        </div>
    </div>
</div>