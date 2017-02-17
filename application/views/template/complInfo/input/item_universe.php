<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
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
<?php elseif($typeView === 'print') : ?>
<p>Série : <?php echo $item['item_universe']; ?></p>
<?php endif; ?>