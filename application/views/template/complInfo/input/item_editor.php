<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="editorItem">Éditeur</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_editor" id="editorItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_editor'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p><?php echo $item['item_editor']; ?></p>
<?php endif; ?>