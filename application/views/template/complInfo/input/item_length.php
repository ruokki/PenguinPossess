<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="lengthItem">Durée des épisodes</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_length" id="lengthItem" <?php echo isset($item) ? 'value="' . $item['item_length'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>