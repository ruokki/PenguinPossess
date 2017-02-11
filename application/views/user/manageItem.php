<form name="manageItem" method="POST" action="" class="row">
    <h1>
        <?php if($cmd === 'create') : ?>
        Création d'un item
        <?php else : ?>
        Modification de l'item 
        <?php endif; ?>
    </h1>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <label for="nameItem">Nom</label>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box">
                    <input type="text" name="item_name" id="nameItem" />
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
                        <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
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
                        <option value="" selected="selected" disabled=""></option>
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
                    <textarea name="item_descript" id="descriptItem"></textarea>
                </div>
            </div>
        </div>
    </div>
</form>