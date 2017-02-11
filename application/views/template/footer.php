    
    <!-- JS par défaut -->
    <script type="text/javascript" src="<?php echo base_url('asset/js/lib/jquery-3.1.1.min.js'); ?>"></script>
    <!-- Chargement des JS de la vue -->
    <?php if(isset($js)) : ?>
        <?php if(is_array($js)) : ?>
            <?php foreach($js as $file) : ?>
            <script type="text/javascript" src="<?php echo base_url('asset/js/' . $js); ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
    </body>
</html>
