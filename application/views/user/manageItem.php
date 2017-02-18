<form name="manageItem" enctype="multipart/form-data" method="POST" action="" class="row">
    <h1>
        <?php if($cmd === 'create') : ?>
        Création d'un item
        <?php else : ?>
        Modification de l'item 
        <?php endif; ?>
    </h1>
    <?php if(isset($errors)) : ?>
    <ul id="errors">
        <span id="closeError" class="icon-cross"></span>
        <?php foreach($errors as $txt) : ?>
        <li><?php echo $txt; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php if(isset($multiUser) &&  $multiUser === true) : ?>
    <h2>CET ITEM APPARTIENT &Agrave; PLUSIEURS PERSONNES. TOUTE MODIFICATION DEVRA ÊTRE VALIDÉE PAR UN ADMINISTRATEUR</h2>
    <?php endif; ?>
    <div id="imgContainer" class="col-xs-12">
        <?php if(isset($item)) : ?>
        <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
        <?php else : ?>
        <img src="" />
        <?php endif; ?>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <label for="nameItem">Nom</label>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box">
                    <input type="text" name="item_name" id="nameItem" maxlength="255" <?php echo isset($item) ? 'value="' . $item['item_name'] . '"' : ''; ?> />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <label for="imgItem">Image (2Mo max.)</label>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box">
                    <input type="file" name="item_img" id="imgItem" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <label for="categoryItem">Catégorie</label>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box">
                    <select name="category_id" id="categoryItem" >
                        <option value="" selected="selected" disabled=""></option>
                        <?php foreach($categories as $cat) : ?>
                        <option value="<?php echo $cat['category_id']; ?>" <?php echo isset($item) && $item['category_id'] === $cat['category_id'] ? 'selected="selected"' : ''; ?>>
                            <?php echo $cat['category_name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <label for="subcategoryItem">Sous-catégorie</label>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box">
                    <select name="subcategory_id" id="subcategoryItem" >
                        <?php if(isset($subCategories)) : ?>
                            <?php foreach($subCategories as $cat) : ?>
                            <option value="<?php echo $cat['category_id']; ?>" <?php echo isset($item) && $item['subcategory_id'] === $cat['category_id'] ? 'selected="selected"' : ''; ?>>
                                <?php echo $cat['category_name']; ?>
                            </option>
                            <?php endforeach; ?>
                        <?php else : ?>
                        <option value="" selected="selected" disabled=""></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <label for="descriptItem">Description</label>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box">
                    <textarea name="item_descript" id="descriptItem"><?php echo isset($item) ? $item['item_descript'] : ''; ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($item)) : ?>
        <?php $this->load->view('template/complInfo/' . formatCatName($item['sub_category'])); ?>
        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>" />
    <?php endif; ?>
    <div id="submitWrapper" class="col-xs-12">
        <div class="row">
            <div class="col-xs-offset-4 col-xs-8">
                <div class="box">
                    <button type="submit">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
<?php if(isset($result['error']) && $result['error'] === TRUE) : ?>
    var alert = "Erreur lors de l'enregistrement";
    var type = "error";
<?php elseif(isset($result['success']) && $result['success'] === TRUE) : ?>
    var alert = "Item <?php echo isset($item) ? 'modifié' : 'créé'; ?> avec succès";
    var type = "success";
<?php else : ?>
    var alert = null;
    var type = "default";
<?php endif; ?>
</script>
