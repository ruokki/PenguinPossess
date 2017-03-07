<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="item_editor" id="editorItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_editor'] . '"' : ''; ?> />
        <label for="editorItem">Éditeur</label>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<h3>Éditeur :</h3>
<p><?php echo $item['item_editor']; ?></p>
<?php endif; ?>