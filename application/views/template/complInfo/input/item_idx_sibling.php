<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="idxSiblingsItem">Tomes</label>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="box">
                <input type="text" name="item_idx_sibling" id="idxSiblingsItem" <?php echo isset($item) ? 'value="' . $item['item_idx_sibling'] . '"' : ''; ?> />
            </div>
        </div>
        <div class="col-xs-1">/</div>
        <div class="col-xs-4">
            <div class="box">
                <input type="text" name="item_siblings" id="siblingsItem" <?php echo isset($item) ? 'value="' . $item['item_siblings'] . '"' : ''; ?> />
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Tome : <?php echo $item['item_idx_sibling']; ?> / <?php echo $item['item_siblings']; ?></p>
<?php endif; ?>