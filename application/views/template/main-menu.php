<div id="mainMenu">
    <div>
        <div class="menu">
            <a href="<?php echo site_url('home/index'); ?>" <?php if($active === 'home') { echo 'class="active"'; } ?>>
                <span class="icon-home"></span>
                Accueil
            </a>
        </div>
        <div class="menu">
            <a href="<?php echo site_url('user/index'); ?>" <?php if($active === 'user') { echo 'class="active"'; } ?>>
                <span class="icon-user"></span>
                Mon compte
            </a>
            <div class="submenu">
                <a href="<?php echo site_url('user/index'); ?>">
                    <span class="icon-database"></span>
                    Ma collection
                </a>
                <a href="" class="disabled">
                    <span class="icon-heart"></span>
                    Ma wishlist
                </a>
                <a href="<?php echo site_url('user/lent'); ?>">
                    <span class="icon-box-remove"></span>
                    Mes prêts
                </a>
                <a href="<?php echo site_url('user/borrowed'); ?>">
                    <span class="icon-box-add"></span>
                    Mes emprunts
                </a>
            </div>
        </div>
        <div class="menu">
            <a href="<?php echo site_url('home/search'); ?>" <?php if($active === 'search') { echo 'class="active"'; } ?>>
                <span class="icon-search"></span>
                Recherche avancée
            </a>
        </div>
        <div class="menu">
            <?php echo implode('</div><div class="menu">', $categories); ?>
        </div>
        <?php if($this->session->user['role'] === $this->config->item('admin_id')) : ?>
        <div class="menu">
            <a href="<?php echo site_url('admin/index'); ?>" <?php if($active === 'admin') { echo 'class="active"'; } ?>>
                <span class="icon-shield"></span>
                Administration
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>