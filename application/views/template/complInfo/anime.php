<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="creatorItem">Studio</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_creator" id="creatorItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_creator'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="releaseItem">Année</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_release" id="releaseItem" maxlength="4" <?php echo isset($item) ? 'value="' . $item['item_release'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="totalItem">Nb épisode</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_siblings" id="totalItem" <?php echo isset($item) ? 'value="' . $item['item_siblings'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12">
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
<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="seasonItem">Nb saison</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_seasons" id="seasonItem" <?php echo isset($item) ? 'value="' . $item['item_seasons'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="typeItem">Support</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_type" id="typeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_type'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>