<h1 class="text-center">Création d'un item</h1>
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
            
        </div>
    </div>
    <div id="step3" class="step">
        <h2>Veuillez remplir les infos item</h2>
        <div>
            <div id="imgContainer" class="col-xs-12">
                <img src="" />
            </div>
            <div id="imgInput" class="col-xs-12">
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
            <div class="col-xs-12">
                <div class="floatingLabel">
                    <input type="text" name="item_name" id="nameItem" maxlength="255" <?php echo isset($item) ? 'value="' . $item['item_name'] . '"' : ''; ?> />
                    <label for="nameItem">Nom</label>
                </div>
            </div>
        </div>
        <button type="submit">Terminer</button>
    </div>
    
    <input type="hidden" id="categoryId" name="category_id" />
    <input type="hidden" id="subCategoryId" name="subcategory_id" />
</form>