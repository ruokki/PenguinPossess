<form name="searchItem" method="POST" action="" class="row">
    <h1>Rechercher un item</h1>
    <div class="col-xs-12">
        <div class="floatingLabel">
            <input type="text" name="item_name" id="nameItem" maxlength="255" <?php echo isset($item) ? 'value="' . $item['item_name'] . '"' : ''; ?> />
            <label for="nameItem">Nom</label>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="floatingLabel">
            <select name="category_id" id="categoryItem" >
                <option value="" selected="selected" disabled=""></option>
                <?php foreach($categories as $cat) : ?>
                <option value="<?php echo $cat['category_id']; ?>" <?php echo isset($item) && $item['category_id'] === $cat['category_id'] ? 'selected="selected"' : ''; ?>>
                    <?php echo $cat['category_name']; ?>
                </option>
                <?php endforeach; ?>
            </select>
            <label for="categoryItem">Catégorie</label>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="floatingLabel">
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
            <label for="subcategoryItem">Sous-catégorie</label>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="floatingLabel">
            <textarea name="item_descript" id="descriptItem"><?php echo isset($item) ? $item['item_descript'] : ''; ?></textarea>
            <label for="descriptItem">Description</label>
        </div>
    </div>
    <div class="col-xs-12" id="buttonWrapper">
        <div class="row">
            <div class="col-xs-6">
                <button type="reset">Annuler</button>
            </div>
            <div class="col-xs-6">
                <button type="submit">Rechercher</button>
            </div>
        </div>
    </div>
</form>
<script>
    var alert = null;
</script>