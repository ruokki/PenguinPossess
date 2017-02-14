<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="creatorItem">Éditeur</label>
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
                <label for="siblingsItem">Nb joueurs</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_siblings" id="siblingsItem" <?php echo isset($item) ? 'value="' . $item['item_siblings'] . '"' : ''; ?> />
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