<form name="login" method="POST" action="">
    <div class="text-center logo">
        <img src="<?php echo base_url('asset/logo.png'); ?>" title="Penguin Possess" />
    </div>
    <?php if($error !== FALSE) : ?>
    <div>
        <div class="box"><?php echo $error; ?></div>
    </div>
    <?php endif; ?>
    <div>
        <div class="floatingLabel">
            <input type="text" id="userName" name="userName" />
            <label for="userName">Utilisateur</label>
        </div>
    </div>
    <div>
        <div class="floatingLabel">
            <input type="password" id="userPass" name="userPass" />
            <label for="userPass">Mot de passe</label>
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