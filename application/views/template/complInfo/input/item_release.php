<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="item_release" id="releaseItem" maxlength="4" <?php echo isset($item) && $item['item_release'] > 0 ? 'value="' . $item['item_release'] . '"' : ''; ?> />
        <label for="releaseItem">Année</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Année : <?php echo $item['item_release']; ?></p>
<?php endif; ?>