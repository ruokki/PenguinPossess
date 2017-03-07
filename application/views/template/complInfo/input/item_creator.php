<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
            <input type="text" name="item_creator" id="creatorItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_creator'] . '"' : ''; ?>" />
            <label for="creatorItem"><?php echo $label; ?></label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<h3><?php echo $label; ?> :</h3>
<p> <?php echo $item['item_creator']; ?></p>
<?php endif; ?>