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
                <input type="number" name="item_idx_sibling" id="idxSiblingsItem" <?php echo isset($item) && $item['item_idx_sibling'] > 0 ? 'value="' . $item['item_idx_sibling'] . '"' : ''; ?> />
            </div>
        </div>
        <div class="col-xs-1">/</div>
        <div class="col-xs-4">
            <div class="box">
                <input type="number" name="item_siblings" id="siblingsItem" <?php echo isset($item) && $item['item_siblings'] > 0 ? 'value="' . $item['item_siblings'] . '"' : ''; ?> placeholder="Laisser vide si en cours" />
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<p>Tome : <?php echo $item['item_idx_sibling']; ?> / <?php echo $item['item_siblings']; ?></p>
<?php endif; ?>