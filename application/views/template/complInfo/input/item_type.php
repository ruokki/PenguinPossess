<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="item_type" id="typeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_type'] . '"' : ''; ?> placeholder="Blu-ray, DVD, PS4, XBox One..." />
        <label for="typeItem">Support</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Support</span><span class="value"><?php echo $item['item_type']; ?></span>
<?php endif; ?>