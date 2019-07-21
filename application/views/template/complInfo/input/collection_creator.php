<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
            <input type="text" name="collection[collection_creator]" id="creatorCollection" maxlength="100" <?php echo isset($item) ? 'value="' . $item['collection_creator'] . '"' : ''; ?>" />
            <label for="creatorItem"><?php echo $label; ?></label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label"><?php echo $label; ?></span><span class="value"><?php echo $item['item_creator']; ?></span>
<?php endif; ?>