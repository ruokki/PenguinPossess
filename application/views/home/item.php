<?php if(isset($item['error']) && $item['error'] === TRUE) : ?>
<h1>Item inconnu !</h1>
<?php else : ?>
<?php $possessors = $item['user_id_possess'] === NULL ? array() : explode(',', $item['user_id_possess']); ?>
<div id="item">
    <div class="img">
        <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
    </div>
    <div class="info">
        <h1><?php echo $item['item_name']; ?></h1>
        <div class="category">
            <div class="float-left">
                <a href="<?php echo site_url('home/category/' . $item['category_id']); ?>"><?php echo $item['main_category']; ?></a>
                -
                <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>"><?php echo $item['sub_category']; ?></a>
            </div>
            <div class="float-right">
                <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                    class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
                    title="Modifier l'item">
                    <span class="icon-pencil"></span>
                </a>
                <span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                        data-id="<?php echo $item['item_id']; ?>"
                        title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                <?php if(in_array($this->session->user['id'], $possessors)) : ?>
                    <?php $letBorrow = strpos($item['user_let_borrow'], $this->session->user['id'] . '|1') !== FALSE; ?>
                    <span class="<?php echo $letBorrow === TRUE ? 'icon-unlocked' : 'icon-lock' ?> letBorrow"
                           data-id="<?php echo $item['item_id']; ?>"
                           title="<?php echo $letBorrow === TRUE ? 'Prêt possible' : 'Prêt interdit' ?>"></span>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php $this->load->view('template/complInfo/' . formatCatName($item['sub_category'])); ?>
        <p><?php echo preg_replace( "/\r|\n/", "<br/>", $item['item_descript']); ?></p>
        <p>Possesseurs : <?php echo implode(', ', $item['possessors']); ?></p>
    </div>
</div>
<div id="listItem">
    <h1>Items similaires :</h1>
    <div class="item">
        <div class="background">
            <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
        </div>
        <div class="front" data-href="<?php echo 'home/item/' . $item['item_id']; ?>">
            <div>
                <h1 class="text-center"><?php echo $item['item_name']; ?></h1>
                <p class="text-center">
                    <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                        <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                    </a>

                    <?php if(!in_array($this->session->user['id'], $possessors)) : ?>
                    <span class="icon-box-add borrow" 
                           data-id="<?php echo $item['item_id']; ?>"
                           title="Demander l'emprunt de l'item"></span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="icons">
                <div class="float-left">
                    <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                        class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
                        title="Modifier l'item">
                        <span class="icon-pencil"></span>
                    </a>
                </div>
                <div class="float-right">
                    <span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                           data-id="<?php echo $item['item_id']; ?>"
                           title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="background">
            <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
        </div>
        <div class="front" data-href="<?php echo 'home/item/' . $item['item_id']; ?>">
            <div>
                <h1 class="text-center"><?php echo $item['item_name']; ?></h1>
                <p class="text-center">
                    <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                        <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                    </a>

                    <?php if(!in_array($this->session->user['id'], $possessors)) : ?>
                    <span class="icon-box-add borrow" 
                           data-id="<?php echo $item['item_id']; ?>"
                           title="Demander l'emprunt de l'item"></span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="icons">
                <div class="float-left">
                    <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                        class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
                        title="Modifier l'item">
                        <span class="icon-pencil"></span>
                    </a>
                </div>
                <div class="float-right">
                    <span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                           data-id="<?php echo $item['item_id']; ?>"
                           title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="background">
            <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
        </div>
        <div class="front" data-href="<?php echo 'home/item/' . $item['item_id']; ?>">
            <div>
                <h1 class="text-center"><?php echo $item['item_name']; ?></h1>
                <p class="text-center">
                    <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                        <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                    </a>

                    <?php if(!in_array($this->session->user['id'], $possessors)) : ?>
                    <span class="icon-box-add borrow" 
                           data-id="<?php echo $item['item_id']; ?>"
                           title="Demander l'emprunt de l'item"></span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="icons">
                <div class="float-left">
                    <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                        class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
                        title="Modifier l'item">
                        <span class="icon-pencil"></span>
                    </a>
                </div>
                <div class="float-right">
                    <span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                           data-id="<?php echo $item['item_id']; ?>"
                           title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="background">
            <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
        </div>
        <div class="front" data-href="<?php echo 'home/item/' . $item['item_id']; ?>">
            <div>
                <h1 class="text-center"><?php echo $item['item_name']; ?></h1>
                <p class="text-center">
                    <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                        <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                    </a>

                    <?php if(!in_array($this->session->user['id'], $possessors)) : ?>
                    <span class="icon-box-add borrow" 
                           data-id="<?php echo $item['item_id']; ?>"
                           title="Demander l'emprunt de l'item"></span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="icons">
                <div class="float-left">
                    <a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
                        class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
                        title="Modifier l'item">
                        <span class="icon-pencil"></span>
                    </a>
                </div>
                <div class="float-right">
                    <span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
                           data-id="<?php echo $item['item_id']; ?>"
                           title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
