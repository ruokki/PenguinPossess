<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Réalisateur')); ?> -
    <?php $this->view('template/complInfo/input/item_universe'); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?> -
    <?php $this->view('template/complInfo/input/item_type'); ?>
</p>
<?php else : ?>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Réalisateur')); ?>
    <?php $this->view('template/complInfo/input/item_universe'); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
    <?php $this->view('template/complInfo/input/item_type'); ?>
<?php endif; ?>