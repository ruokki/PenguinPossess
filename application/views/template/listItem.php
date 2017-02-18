<div id="listItem">
    <?php if(count($items) === 0) : ?>
        <p>Aucun item à afficher</p>
    <?php else : ?>
        <?php foreach($items as $item) : ?>
        <?php $tmp = explode(',', $item['user_id_possess']); ?>
        <div class="item">
            <div class="background">
                <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
            </div>
            <div class="front" data-href="<?php echo 'home/item/' . $item['item_id']; ?>">
                <p><?php echo $item['item_name']; ?></p>
                <div class="icon-misc">
                    <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                        <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                    </a>
                </div>
                <div class="icon-action">
                    <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                       class="edit <?php echo in_array($this->session->user['id'], $tmp) ? '' : 'hidden'; ?>"
                       title="Modifier l'item">
                        <span class="icon-pencil"></span>
                    </a>
                    <span class="<?php echo in_array($this->session->user['id'], $tmp) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                          data-id="<?php echo $item['item_id']; ?>"
                          title="<?php echo in_array($this->session->user['id'], $tmp) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>