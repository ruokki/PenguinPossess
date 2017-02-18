<div id="actions">
    <div class="float-left">
        <h1>Résultat de la recherche : <?php echo count($items) . ' ' . (count($items) > 1 ? 'items trouvés' : 'item trouvé') ?></h1>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->view('template/listItem'); ?>