<h1 class="text-center">
    Création 
    <?php if(isset($isCollec) && $isCollec === TRUE) : ?>
    d'une collection d'items <?php echo $type === 'wish' ? 'désirés' : 'possédés' ?>
    <?php else : ?>
     d'un item <?php echo $type === 'wish' ? 'désiré' : 'possédé' ?>
    <?php endif; ?>
</h1>
<?php if(isset($errors)) : ?>
<?php $this->view('template/form_errors'); ?>
<?php endif; ?>
<h2 id="breadcrumb"></h2>
<form name="manageItem" enctype="multipart/form-data" method="POST" action=""  id="stepWrapper">
    <div id="step1" class="step">
        <h2>Veuillez choisir une catégorie</h2>
        <div>
            <?php foreach($categories as $one) : ?>
            <div class="category text-center" data-id="<?php echo $one['category_id']; ?>">
                <span class="icon icon-<?php echo $one['category_icon']; ?>"></span>
                <p><?php echo $one['category_name'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="step2" class="step">
        <h2>Veuillez choisir une sous-catégorie</h2>
        <div>
            <?php if(isset($subCategories)) : ?>
            <?php foreach($subCategories as $one) : ?>
            <div class="category text-center" data-id="<?php echo $one['category_id']; ?>">
                <span class="icon icon-<?php echo $one['category_icon']; ?>"></span>
                <p><?php echo $one['category_name'] ?></p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div id="step3" class="step">
        <h2>Veuillez remplir les infos item</h2>
        <div>
            <?php if(!(isset($isCollec) && $isCollec === TRUE)) : ?>
            <div id="imgContainer" class="col-xs-12 dontRemove">
                <?php if($entry !== FALSE && isset($entry['item_img'])) : ?>
                <img src="<?php echo base_url('asset/userfile/img/' . $entry['category_id'] . '/' . $entry['subcategory_id'] . '/' . $entry['item_img']) ?>" title="<?php echo $entry['item_name']; ?>" />
                <?php else : ?>
                <img src="" />
                <?php endif; ?>
            </div>
            <div id="imgInput" class="col-xs-12 dontRemove">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="box">
                            <label for="imgItem">Image (<?php echo $maxWidthImg . 'x' . $maxHeightImg; ?>, 2Mo max.)</label>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="box">
                            <input type="file" name="item_img" id="imgItem" />
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-xs-12 dontRemove">
                <div class="floatingLabel">
                    <input type="text" name="item_name" id="nameItem" maxlength="255" <?php echo $entry !== FALSE ? 'value="' . $entry['item_name'] . '"' : ''; ?> />
                    <label for="nameItem">Nom</label>
                </div>
            </div>
            <?php if($entry !== FALSE) : ?>
                <?php $this->load->view('template/complInfo/' . formatCatName($entry['sub_category']), array('item' => $entry)); ?>
            <?php endif; ?>
        </div>
        <button type="submit">Terminer</button>
    </div>
    
    <input type="hidden" id="categoryId" name="category_id"  <?php echo $entry !== FALSE ? 'value="' . $entry['category_id'] . '"' : ''; ?> />
    <input type="hidden" id="subCategoryId" name="subcategory_id" <?php echo $entry !== FALSE ? 'value="' . $entry['subcategory_id'] . '"' : ''; ?> />
    <input type="hidden" id="subCategoryName" name="sub_category" <?php echo $entry !== FALSE ? 'value="' . $entry['sub_category'] . '"' : ''; ?> />
</form>

<script>
<?php if(isset($result['error']) && $result['error'] === TRUE) : ?>
    var alert = "Erreur lors de l'enregistrement";
    var type = "error";
<?php elseif(isset($result['success']) && $result['success'] === TRUE) : ?>
    var alert = "Item créé avec succès";
    var type = "success";
<?php else : ?>
    var alert = null;
    var type = "default";
<?php endif; ?>
    var entry = <?php echo json_encode($entry); ?>;
    var isCollec = <?php echo isset($isCollec) ? json_encode($isCollec) : 'false' ?>;
    var typeItem = <?php echo isset($type) ? json_encode($type) : ''; ?>;
</script>