<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="item_type" id="typeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_type'] . '"' : ''; ?> placeholder="Blu-ray, DVD, CD..." />
        <label for="typeItem">Support</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Support : <?php echo $item['item_type']; ?></p>
<?php endif; ?>