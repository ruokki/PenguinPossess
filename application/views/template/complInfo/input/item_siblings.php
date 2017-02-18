<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="totalItem">Nb épisode</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="number" name="item_siblings" id="totalItem" <?php echo isset($item) && $item['item_siblings'] > 0 ? 'value="' . $item['item_siblings'] . '"' : ''; ?> placeholder="Par saison" />
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Nb épisode : <?php echo $item['item_siblings']; ?></p>
<?php endif; ?>