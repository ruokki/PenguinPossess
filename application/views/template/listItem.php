<div id="listItem">
    <?php if(count($items) === 0) : ?>
        <p>Aucun item à afficher</p>
    <?php else : ?>
        <?php foreach($items as $item) : ?>
        <div class="item">
            <div class="background">
                <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
            </div>
            <div class="front">
                <p><?php echo $item['item_name']; ?></p>
                <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>">Edit</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>