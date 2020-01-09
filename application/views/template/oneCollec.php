<div class="item">
    <div class="background">
        <img src="<?php echo base_url('asset/userfile/img/' . $item['category_id'] . '/' . $item['subcategory_id'] . '/efzerzer.png') ?>" title="<?php echo $item['collection_name']; ?>" />
    </div>
    <div class="front" data-href="<?php echo 'home/collection/' . $item['collection_id']; ?>">
        <div>
            <h1 class="text-center"><?php echo $item['collection_name']; ?></h1>
            <p class="text-center">
                <a href="<?php echo site_url('home/category/' . $item['subcategory_id']); ?>">
                    <span class="icon-<?php echo $item['category_icon']; ?>" title="<?php echo $item['main_category'] . ' - ' . $item['sub_category']; ?>"></span>
                </a>

                <!--<?php if(!in_array($this->session->user['id'], $possessors)) : ?>
                <span class="icon-box-add borrow" 
                       data-id="<?php echo $item['item_id']; ?>"
                       title="Emprunter"></span>
                <?php endif; ?>-->
            </p>
        </div>
        <div class="icons">
            <div class="actionItem float-right">
                <?php // $this->load->view('template/actionItem', array('item' => $item)); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>