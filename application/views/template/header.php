<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        
        <!-- Désactivation du cache pour le dév -->
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        
        <title>Penguin Possess<?php echo isset($title) ? ' - ' . $title : ''; ?></title>
        
        <!-- CSS par défaut -->
        <link href="<?php echo base_url('asset/css/lib/reset.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('asset/css/lib/flexboxgrid.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('asset/css/all.css'); ?>" rel="stylesheet" />
        
        <!-- Chargement des CSS de la vue -->
        <?php if(isset($css)) : ?>
            <?php if(is_array($css)) : ?>
                <?php foreach($css as $file) : ?>
                <link href="<?php echo base_url('asset/css/' . $file); ?>" rel="stylesheet" />
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
        
    </head>
    <body <?php echo $this->session->user !== NULL ? 'class="topMenu"' : ''; ?>>
<?php if($this->session->user !== NULL) : ?>
    <?php echo generateMainMenu(isset($active) ? $active : ''); ?>
<?php endif; ?>
        <div id="wrapper">