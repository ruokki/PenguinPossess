<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="item_length" id="lengthItem" <?php echo isset($item) > 0 ? 'value="' . $item['item_length'] . '"' : ''; ?> placeholder="En minutes" />
        <label for="lengthItem">Durée des épisodes</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Durée des épisodes</span><span class="value"><?php echo $item['item_length']; ?></span>
<?php endif; ?>