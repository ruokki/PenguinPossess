<?php 
    if(isset($item)) {
        $tracks = explode('|', $item['item_tracklist']); 
        $nbTrack = count($tracks); 
    }
?>
<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="floatingLabel">
        <input type="text" name="track[]" id="trackItem" <?php echo isset($item) && $nbTrack > 0 ? 'value="' . $tracks[0] . '"' : ''; ?> />
        <label for="trackItem">Pistes</label>
    </div>
    <?php if(isset($item)) : ?>
        <?php for($i = 1; $i < $nbTrack; $i++) : ?>
        <div class="floatingLabel track">
            <input type="text" name="track[]" value="<?php echo $tracks[$i]; ?>" />
        </div>
        <?php endfor; ?>
    <?php endif; ?>
    <div id="manageTrack" class="row">
        <div class="text-right col-xs-12">
            <div class="box">
                <button id="delTrack" type="button">Supprimer une piste</button>
                <button id="addTrack" type="button">Ajouter une piste</button>
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
<h3>Pistes :</h3>
    <?php for($i = 0; $i < $nbTrack; $i++) : ?>
        <p><?php echo $i + 1; ?> - <?php echo $tracks[$i]; ?></p>
    <?php endfor; ?>
<?php endif; ?>