<div id="listItem">
    <?php if(count($items) === 0) : ?>
        <p>Aucun item à afficher</p>
    <?php else : ?>
        <?php foreach($items as $item) : ?>
        <?php 
            $possessors = explode(',', $item['user_id_possess']); 
            $borrowers = explode(',', $item['borrowers_id']);
        ?>
        <div class="item">
            <div class="background">
                <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
            </div>
            <div class="front" data-href="<?php echo 'home/item/' . $item['item_id']; ?>">
                <div class="info">
                    <p><?php echo $item['item_name']; ?></p>
                    <p><?php echo $item['item_descript']; ?></p>
                </div>
                <div class="icons">
                    <div class="float-left">
                        <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                            <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                        </a>
                    </div>
                    <div class="float-right">
                        <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                           class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
                           title="Modifier l'item">
                            <span class="icon-pencil"></span>
                        </a>
                        <?php if(!in_array($this->session->user['id'], $possessors)) : ?>
                        <span class="icon-box-add borrow <?php echo !in_array($this->session->user['id'], $borrowers) ? '' : 'disabled'; ?>" 
                              data-id="<?php echo $item['item_id']; ?>"
                              title="Demander l'emprunt de l'item"></span>
                        <?php endif; ?>
                        <span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                              data-id="<?php echo $item['item_id']; ?>"
                              title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>