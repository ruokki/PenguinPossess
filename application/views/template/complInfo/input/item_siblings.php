<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="number" name="item_siblings" id="totalItem" <?php echo isset($item) && $item['item_siblings'] > 0 ? 'value="' . $item['item_siblings'] . '"' : ''; ?> placeholder="Par saison" />
        <label for="totalItem">Nb épisode</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<h3>Nb épisode :</h3>
<p><?php echo $item['item_siblings']; ?></p>
<?php endif; ?>