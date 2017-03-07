<form name="login" method="POST" action="">
    <div class="text-center logo">
        <img src="<?php echo base_url('asset/logo.png'); ?>" title="Penguin Possess" />
    </div>
    <?php if($errors !== FALSE) : ?>
    <?php $this->view('template/form_errors'); ?>
    <?php endif; ?>
    <div>
        <div class="floatingLabel">
            <input type="text" id="userName" name="userName" />
            <label for="userName">Utilisateur</label>
        </div>
    </div>
    <div id="passWrapper">
        <div class="floatingLabel">
            <input type="password" id="userPass" name="userPass" />
            <label for="userPass">Mot de passe</label>
        </div>
        <div class="text-right">
            <a href="<?php echo site_url('home/forgotPass'); ?>">Mot de passe oublié ?</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div id="crea" class="box">
                <a href="<?php echo site_url('home/createUser'); ?>">Création de compte</a>
            </div>
        </div>
        <div class="col-xs-6">
            <button type="submit">Connexion</button>
        </div>
    </div>
</form>

<?php if($msg !== '') : ?>
<script>
    var msg = "<?php echo $msg ?>";
</script>
<?php endif; ?>
