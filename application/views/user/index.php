<div id="actions">
    <div class="float-left">
        <a id="addItem" class="button" href="<?php echo site_url('user/manageItem/create'); ?>">Ajouter des items</a>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->view('template/listItem'); ?>
<script>
    var myCollection = true;
</script>