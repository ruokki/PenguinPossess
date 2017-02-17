<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
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
<?php elseif($typeView === 'print') : ?>
<p>Nb saison : <?php echo $item['item_seasons']; ?></p>
<?php endif; ?>