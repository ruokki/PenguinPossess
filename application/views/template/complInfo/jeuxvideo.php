<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Studio')); ?> -
    <?php $this->view('template/complInfo/input/item_universe'); ?> -
    <?php $this->view('template/complInfo/input/item_editor'); ?> -
    <?php $this->view('template/complInfo/input/item_type'); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?>
</p>
<?php else : ?>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Studio')); ?>
    <?php $this->view('template/complInfo/input/item_universe'); ?>
    <?php $this->view('template/complInfo/input/item_editor'); ?>
    <?php $this->view('template/complInfo/input/item_type'); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
<?php endif; ?>