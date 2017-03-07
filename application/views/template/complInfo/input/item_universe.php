<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="item_universe" id="universeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_universe'] . '"' : ''; ?> />
        <label for="universeItem">Série</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<h3>Série :</h3>
<p><?php echo $item['item_universe']; ?></p>
<?php endif; ?>