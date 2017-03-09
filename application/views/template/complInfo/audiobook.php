<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Auteur')); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?> -
    <?php $this->view('template/complInfo/input/item_universe'); ?>
</p>
<?php else : ?>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Auteur')); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
    <?php $this->view('template/complInfo/input/item_universe'); ?>
<?php endif; ?>