<form class="row" name="login" method="POST" action="">
    <?php if($error !== FALSE) : ?>
    <div class="col-xs-12">
        <div class="box"><?php echo $error; ?></div>
    </div>
    <?php endif; ?>
    <h1>Demande de création de compte</h1>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <label for="userName">Nom d'utilisateur</label>
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
                    <button type="submit">Demander</button>
                </div>
            </div>
            <div class="col-xs-9">
                <div id="crea" class="box">
                    <a href="<?php echo site_url('home/login'); ?>" class="button">Retour</a>
                </div>
            </div>
        </div>
    </div>
</form>