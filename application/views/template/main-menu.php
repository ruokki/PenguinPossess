<div id="mainMenu">
    <div id="logoWrapper" class="text-center">
        <img src="<?php echo base_url('asset/logo.png') ?>" />
    </div>
    <div id="commonMenu" class="text-center">
        <a href="<?php echo site_url('home/index'); ?>" class="icon-home <?php if($active === 'home') { echo 'active'; } ?>" title="Accueil"></a>
        <a href="<?php echo site_url('home/search'); ?>" class="icon-search <?php if($active === 'search') { echo 'active'; } ?>" title="Recherche avancée"></a>
        <a href="<?php echo site_url('home/logout'); ?>" class="icon-switch" title="Déconnexion"></a>
    </div>
    <hr />
    <div class="menuList">
        <h3>Mon compte</h3>
        <div class="menu">
            <a href="<?php echo site_url('user/index'); ?>">
                <span class="icon-database"></span>
                Ma collection
            </a>
            <div class="submenu">
                <a href="<?php echo site_url('user/index'); ?>" <?php if($active === 'user') { echo 'class="active"'; } ?>>Mes items</a>
                <a href="<?php echo site_url('user/manageItem'); ?>" <?php if($active === 'createItem') { echo 'class="active"'; } ?>>Créer un item</a>
                <a href="<?php echo site_url('user/manageCollection'); ?>" <?php if($active === 'createCollec') { echo 'class="active"'; } ?>>Créer une collection</a>
            </div>
        </div>
        <div class="menu">
            <a href="<?php echo site_url('user/index'); ?>">
                <span class="icon-heart"></span>
                Ma wishlist
            </a>
            <div class="submenu">
                <a href="<?php echo site_url('user/wishlist'); ?>" <?php if($active === 'wishlist') { echo 'class="active"'; } ?>>Ma wishlist</a>
                <a href="<?php echo site_url('user/manageItem/wish'); ?>" <?php if($active === 'createWish') { echo 'class="active"'; } ?>>Créer un item</a>
                <a href="<?php echo site_url('user/manageCollection/wish'); ?>" <?php if($active === 'collecWish') { echo 'class="active"'; } ?>>Créer une collection</a>
            </div>
        </div>
        <?php echo getNotification($this->session->user['id']); ?>
        <?php if($this->session->user['role'] === $this->config->item('admin_id')) : ?>
            <a href="<?php echo site_url('admin/index'); ?>" <?php if($active === 'admin') { echo 'class="active"'; } ?>>
                <span class="icon-shield"></span>
                Administration
            </a>
        <?php endif; ?>
    </div>
    <hr />
    <div class="menuList">
        <h3>La Bibliothèque</h3>
        <div class="menu">
        <?php echo implode('</div><div class="menu">', $categories); ?>
        </div>
    </div>
    <div id="footer">
        <p class="text-center">Penguin Possess v<?php echo $this->config->item('version'); ?> &copy; Ruokki</p>
    </div>
</div>