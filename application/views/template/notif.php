<div class="float-left">
    <?php if($exp === 0) : ?>
    <span class="icon-bell disabled" title="Aucun emprunt bientôt à expiration"></span>
    <?php else : ?>
    <a href="<?php echo site_url('user/borrowed'); ?>" class="icon-bell" title="<?php echo $exp . ' ' . ($exp > 1 ? 'emprunts' : 'emprunt') ?> bientôt à expiration">
        <span class="nb"><?php echo $exp; ?></span>
    </a>
    <?php endif; ?>
</div>
<div class="float-left">
    <?php if($borrow === 0) : ?>
    <span class="icon-drawer2 disabled" title="Aucune demande de prêt"></span>
    <?php else : ?>
    <a href="<?php echo site_url('user/lent'); ?>" class="icon-drawer2" title="<?php echo $borrow . ' ' . ($borrow > 1 ? ' nouvelles demandes' : 'nouvelle demande') ?> de prêt">
        <span class="nb"><?php echo $borrow; ?></span>
    </a>
    <?php endif; ?>
</div>