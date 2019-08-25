<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-5">
            <div class="floatingLabel">
                <input type="number" name="item_idx_sibling" id="idxSiblingsItem" <?php echo isset($item) && $item['item_idx_sibling'] > 0 ? 'value="' . $item['item_idx_sibling'] . '"' : ''; ?> />
                <label for="idxSiblingsItem">Tomes</label>
            </div>
        </div>
        <div class="col-xs-1">/</div>
        <div class="col-xs-5">
            <div class="floatingLabel">
                <input type="number" name="item_siblings" id="siblingsItem" <?php echo isset($item) && $item['item_siblings'] > 0 ? 'value="' . $item['item_siblings'] . '"' : ''; ?> placeholder="Laisser vide si en cours" />
                <label for="siblingsItem">Nombre total de tome</label>
            </div>
            <div class="box">
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
    <?php if(isset($item['collection_length'])) : ?>
    <span class="label">Tome</span><span class="value"><?php echo $item['item_idx_sibling']; ?> / <?php echo $item['collection_length']; ?></span>
    <?php else : ?>
    One shot
    <?php endif; ?>
<?php endif; ?>