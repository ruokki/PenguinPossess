<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="item_seasons" id="seasonItem" <?php echo isset($item) ? 'value="' . $item['item_seasons'] . '"' : ''; ?> />
        <label for="seasonItem">Nb saison</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Nb saison : <?php echo $item['item_seasons']; ?></p>
<?php endif; ?>