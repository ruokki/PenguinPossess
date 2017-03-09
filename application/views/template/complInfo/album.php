<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Groupe')); ?> -
    <?php $this->view('template/complInfo/input/item_editor'); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?>
    <?php $this->view('template/complInfo/input/item_tracklist'); ?>
</p>
<?php else : ?>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Groupe')); ?>
    <?php $this->view('template/complInfo/input/item_editor'); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
    <?php $this->view('template/complInfo/input/item_tracklist'); ?>
<?php endif; ?>