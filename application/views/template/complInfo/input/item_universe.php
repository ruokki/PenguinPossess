<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="item_universe" id="universeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_universe'] . '"' : ''; ?> />
        <label for="universeItem">Série</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Série</span><span class="value"><?php echo $item['item_universe']; ?></span>
<?php endif; ?>