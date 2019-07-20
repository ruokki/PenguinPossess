<h1 class="text-center">Création d'un item</h1>
<div id="stepWrapper">
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
</div>