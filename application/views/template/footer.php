    </div>
    <!-- JS par défaut -->
    <script type="text/javascript" src="<?php echo base_url('asset/js/lib/jquery-3.1.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('asset/js/lib/jquery-ui-1.12.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('asset/js/mainMenu.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('asset/js/lib/showAlertBox.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('asset/js/lib/floatingLabel.js'); ?>"></script>
    <script>
        var baseUrl = "<?php echo base_url(); ?>";
        var siteUrl = "<?php echo site_url(); ?>";
    </script>
    <!-- Chargement des JS de la vue -->
    <?php if(isset($js)) : ?>
        <?php if(is_array($js)) : ?>
            <?php foreach($js as $file) : ?>
            <script type="text/javascript" src="<?php echo base_url('asset/js/' . $file . '?version=' . $this->config->item('version')); ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
    </body>
</html>
