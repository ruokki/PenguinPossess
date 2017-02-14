<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="creatorItem">Auteur</label>
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
                <label for="universeItem">Série</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="item_universe" id="universeItem" maxlength="100" <?php echo isset($item) ? 'value="' . $item['item_universe'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>