<div id="actions">
    <div id="filters" class="float-left">
        <div class="floatingLabel">
            <select id="filterType" name="type">
                <option value="item">Mes items</option>
                <option value="collec">Mes collections</option>
            </select>
            <label for="filterType">Type</label>
        </div>
        <div class="floatingLabel">
            <select id="filterCateg" name="category">
                <option disabled="disabled">Catégorie</option>
                <option value="all">Toutes</option>
                <?php foreach($categories as $one) : ?>
                <option value="<?php echo $one['category_id'] ?>"><?php echo $one['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="filterCateg">Catégorie</label>
        </div>
        <div class="floatingLabel">
            <select id="filterSubCateg" name="subcategory">
                <option disabled="disabled">Sous-catégorie</option>
                <option value="all">Toutes</option>
                <?php foreach($subcategories as $one) : ?>
                <option data-parent="<?php echo $one['category_parent_id'] ?>" value="<?php echo $one['category_id'] ?>"><?php echo $one['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="filterSubCateg">Sous-catégorie</label>
        </div>
        <input type="hidden" name="user" value="<?php echo $this->session->user['id']; ?>" />
    </div>
    <div class="float-right">
        <a id="addItem" class="button" href="<?php echo site_url('user/manageItem' . (isset($active) && $active === 'wishlist' ? '/wish' : '')); ?>">Créer un item</a>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->view('template/listItem'); ?>
<script>
    var myCollection = true;
    var isWishlist = <?php echo isset($active) && $active === 'wishlist' ? 'true' : 'false';  ?>
</script>