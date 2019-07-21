<?php if($typeView === 'print') : ?>
<p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Auteur')); ?> -
    <?php $this->view('template/complInfo/input/item_idx_sibling'); ?> -
    <?php $this->view('template/complInfo/input/item_editor'); ?> -
    <?php $this->view('template/complInfo/input/item_release'); ?>
</p>
<?php else : ?>
    <p class="col-xs-12 compl attention">! Attention ! La BD doit être un one-shot. <a href="<?php echo site_url('user/manageCollection'); ?>">Pour créer une collection, cliquer ici</a></p>
    <?php $this->view('template/complInfo/input/item_creator', array('label' => 'Auteur')); ?>
    <?php $this->view('template/complInfo/input/item_editor'); ?>
    <?php $this->view('template/complInfo/input/item_release'); ?>
<?php endif; ?>