<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="releaseItem">Année</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="number" name="item_release" id="releaseItem" maxlength="4" <?php echo isset($item) && $item['item_release'] > 0 ? 'value="' . $item['item_release'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Année : <?php echo $item['item_release']; ?></p>
<?php endif; ?>