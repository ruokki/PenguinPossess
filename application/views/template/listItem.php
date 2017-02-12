<div id="listItem">
    <?php foreach($items as $item) : ?>
    <div class="item">
        <div class="background">
            <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
        </div>
        <div class="front">
            <p><?php echo $item['item_name']; ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>