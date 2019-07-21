<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="collection[collection_length]" id="totalCollection" maxlength="4" <?php echo isset($item) ? 'value="' . $item['collection_length'] . '"' : ''; ?> />
        <label for="totalCollection">Nombre de tomes</label>
    </div>
</div>
<div id="gotVolume" class="col-xs-12 compl">
    <p>Tomes possédés</p>
    <div></div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Année</span><span class="value"><?php echo $item['item_release']; ?></span>
<?php endif; ?>