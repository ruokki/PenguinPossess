<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="collection[collection_release]" id="releaseCollection" maxlength="4" <?php echo isset($item) && $item['item_release'] > 0 ? 'value="' . $item['collection_release'] . '"' : ''; ?> />
        <label for="releaseItem">Année</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Année</span><span class="value"><?php echo $item['item_release']; ?></span>
<?php endif; ?>