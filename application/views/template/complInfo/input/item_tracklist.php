<?php $tracks = explode('|', $item['item_tracklist']); $nbTrack = count($tracks); ?>
<?php if($typeView === 'form') : ?>
<div class="col-xs-12 compl">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <label for="trackItem">Pistes</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <input type="text" name="track[]" id="trackItem" <?php echo $nbTrack > 0 ? 'value="' . $tracks[0] . '"' : ''; ?> />
            </div>
        </div>
    </div>
    <?php for($i = 1; $i < $nbTrack; $i++) : ?>
    <div class="row">
        <div class="col-xs-offset-4 col-xs-8">
            <div class="box">
                <input type="text" name="track[]" value="<?php echo $tracks[$i]; ?>" />
            </div>
        </div>
    </div>
    <?php endfor; ?>
    <div id="manageTrack" class="row">
        <div class="col-xs-offset-4 col-xs-8">
            <div class="box">
                <button id="addTrack" type="button">Ajouter une piste</button>
                <button id="delTrack" type="button">Supprimer une piste</button>
            </div>
        </div>
    </div>
</div>
<?php elseif($typeView === 'print') : ?>
    <?php for($i = 0; $i < $nbTrack; $i++) : ?>
        <p><?php echo $i + 1; ?> - <?php echo $tracks[$i]; ?></p>
    <?php endfor; ?>
<?php endif; ?>