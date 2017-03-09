<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="item_siblings" id="totalItem" <?php echo isset($item) && $item['item_siblings'] > 0 ? 'value="' . $item['item_siblings'] . '"' : ''; ?> placeholder="Par saison" />
        <label for="totalItem">Nb <?php echo isset($players) ? 'joueurs' : 'épisode'; ?></label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Nb <?php echo isset($players) ? 'joueurs' : 'épisode'; ?></span><span class="value"><?php echo $item['item_siblings']; ?></span>
<?php endif; ?>