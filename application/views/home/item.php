<?php if(isset($item['error']) && $item['error'] === TRUE) : ?>
<h1>Item inconnu !</h1>
<?php else : ?>
<div class="img">
    <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/' . $item['item_img']) ?>" title="<?php echo $item['item_name']; ?>" />
</div>
<div class="info">
    <h1><?php echo $item['item_name']; ?></h1>
    <h3>Catégorie : 
        <a href="<?php echo site_url('home/category/' . $item['category_id']); ?>"><?php echo $item['main_category']; ?></a>
        -
        <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>"><?php echo $item['sub_category']; ?></a>
    </h3>
    <p>Description : <br /><?php echo $item['item_descript']; ?></p>
    <?php $this->load->view('template/complInfo/' . formatCatName($item['sub_category'])); ?>
    <p>Possesseurs : <?php echo implode(', ', $item['possessors']); ?></p>
</div>
<?php endif; ?>
