<div class="listItem">
    <?php if(count($items) === 0) : ?>
        <p>Aucun item à afficher</p>
    <?php else : ?>
        <?php foreach($items as $item) : ?>
        <?php $this->load->view('template/oneItem', array('item' => $item)); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div id="modalBorrow">
    <p>Veuiller choisir auprès de qui faire la demande (un choix possible)</p>
    <div class="listUser">
        <div class="clearfix"></div>
    </div>
</div>