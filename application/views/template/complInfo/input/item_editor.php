<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="labelItem">Label</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_editor" id="labelItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_editor'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>