<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="item_type" id="typeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_type'] . '"' : ''; ?> placeholder="<?php echo isset($jv) && $jv === TRUE ? 'PS4, XBox One' : 'Blu-ray, DVD'; ?>..." />
        <label for="typeItem"><?php echo isset($jv) && $jv === TRUE ? 'Console' : 'Support'; ?></label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label"><?php echo isset($jv) && $jv === TRUE ? 'Console' : 'Support'; ?></span><span class="value"><?php echo $item['item_type']; ?></span>
<?php endif; ?>