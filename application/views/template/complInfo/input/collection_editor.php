<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="collection[collection_editor]" id="editorCollection" maxlength="100" <?php echo isset($item) ? 'value="' . $item['collection_editor'] . '"' : ''; ?> />
        <label for="editorItem">Éditeur</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<span class="label">Éditeur</span><span class="value"><?php echo $item['item_editor']; ?></span>
<?php endif; ?>