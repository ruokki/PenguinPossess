<a href="<?php echo site_url('home/category/' . $id); ?>" <?php if($active === $id) { echo 'class="active"'; } ?>>
    <?php if($icon !== '') : ?>
    <span class="icon-<?php echo $icon; ?>"></span>
    <?php endif; ?>
    <?php echo $name; ?>
</a>