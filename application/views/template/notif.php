<a href="<?php echo site_url('user/lent'); ?>">
    <span class="icon-box-remove"></span>
    Mes prêts
    <?php if($exp !== 0) : ?>
    <span class="nb"><?php echo $exp; ?></span>
    <?php endif; ?>
</a>
<a href="<?php echo site_url('user/borrowed'); ?>">
    <span class="icon-box-add"></span>
    Mes emprunts
    <?php if($borrow !== 0) : ?>
    <span class="nb"><?php echo $borrow; ?></span>
    <?php endif; ?>
</a>