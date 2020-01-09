<div class="listItem">
    <?php if(count($items) === 0) : ?>
        <p>Aucun item à afficher</p>
    <?php else : ?>
        <?php foreach($items as $item) {
            $this->load->view('template/' . (isset($item['is_collection']) && intval($item['is_collection']) === 1 ? 'oneCollec' : 'oneItem'), array('item' => $item)); 
        } ?>
    <?php endif; ?>
</div>
<?php if(!(isset($noModal) && $noModal === TRUE)) : ?>
<div id="modalBorrow">
    <p>Veuiller choisir auprès de qui faire la demande (un choix possible)</p>
    <div class="listUser">
        <div class="clearfix"></div>
    </div>
</div>
<?php endif; ?>