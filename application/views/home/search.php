<form name="searchItem" method="POST" action="" class="row">
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
    <div id="submitWrapper" class="col-xs-12">
        <div class="row">
            <div class="col-xs-offset-4 col-xs-8">
                <div class="box">
                    <button type="submit">Rechercher</button>
                </div>
            </div>
        </div>
    </div>
</form>