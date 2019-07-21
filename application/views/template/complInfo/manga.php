<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Auteur')); ?> -
    <?php $this->view('template/complInfo/input/item_idx_sibling'); ?> -
    <?php $this->view('template/complInfo/input/item_editor'); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?>
</p>
<?php else : ?>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Auteur')); ?>
    <?php $this->view('template/complInfo/input/item_editor'); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
<?php endif; ?>