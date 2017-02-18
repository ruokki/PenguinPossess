<form class="row" name="login" method="POST" action="">
    <div class="text-center logo">
        <img src="<?php echo base_url('asset/logo.png'); ?>" title="Penguin Possess" />
    </div>
    <?php if($error !== FALSE) : ?>
    <div class="col-xs-12">
        <div class="box"><?php echo $error; ?></div>
    </div>
    <?php endif; ?>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <label for="userName">Utilisateur</label>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <input type="text" id="userName" name="userName" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <label for="userPass">Mot de passe</label>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <input type="password" id="userPass" name="userPass" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <button type="submit">Connexion</button>
                </div>
            </div>
            <div class="col-xs-9">
                <div id="crea" class="box">
                    <a href="<?php echo site_url('home/createUser'); ?>">Création de compte</a>
                </div>
            </div>
        </div>
    </div>
</form>