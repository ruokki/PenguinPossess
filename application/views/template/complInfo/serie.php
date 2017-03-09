<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Créateur')); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?> -
    <?php $this->view('template/complInfo/input/item_type'); ?>
</p>
<p>
    <?php $this->view('template/complInfo/input/item_siblings'); ?> -
    <?php $this->view('template/complInfo/input/item_length'); ?> -
    <?php $this->view('template/complInfo/input/item_seasons'); ?>
</p>
<?php else : ?>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Créateur')); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
    <?php $this->view('template/complInfo/input/item_siblings'); ?>
    <?php $this->view('template/complInfo/input/item_length'); ?>
    <?php $this->view('template/complInfo/input/item_seasons'); ?>
    <?php $this->view('template/complInfo/input/item_type'); ?>
<?php endif; ?>