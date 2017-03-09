<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="item_seasons" id="seasonItem" <?php echo isset($item) ? 'value="' . $item['item_seasons'] . '"' : ''; ?> />
        <label for="seasonItem">Nb saison</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Nb saison</span><span class="value"><?php echo $item['item_seasons']; ?></span>
<?php endif; ?>