<a href="<?php echo site_url('user/borrowed'); ?>" <?php if($active === 'borrow') { echo 'class="active"'; } ?>>
    <span class="icon-box-add"></span>
    Mes emprunts
    <?php if($exp !== 0) : ?>
    <span class="nb"><?php echo $exp; ?></span>
    <?php endif; ?>
</a>
<div class="menu">
    <a href="<?php echo site_url('user/lent'); ?>" <?php if($active === 'lent') { echo 'class="active"'; } ?>>
        <span class="icon-box-remove"></span>
        Prêts
        <?php if($borrow !== 0) : ?>
        <span class="nb"><?php echo $borrow; ?></span>
        <?php endif; ?>
    </a>
    <div class="submenu">
        <a href="<?php echo site_url('user/lent'); ?>" <?php if($active === 'lent') { echo 'class="active"'; } ?>>
            <span class="icon-box-remove"></span>
            Prêts en cours
        </a>
        <a href="<?php echo site_url('user/oldLent'); ?>" <?php if($active === 'oldLent') { echo 'class="active"'; } ?>>
            <span class="icon-history"></span>
            Historique des prêts
        </a>
    </div>
</div>