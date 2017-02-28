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
        <a href="<?php echo site_url('user/index'); ?>">
            <span class="icon-database"></span>
            Ma collection
        </a>
        <a href="" class="disabled">
            <span class="icon-heart"></span>
            Ma wishlist
        </a>
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