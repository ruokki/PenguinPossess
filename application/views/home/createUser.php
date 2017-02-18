<form class="row" name="login" method="POST" action="">
    <h1>Demande de création de compte</h1>
    <?php if(isset($errors)) : ?>
    <?php $this->view('template/form_errors'); ?>
    <?php endif; ?>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <label for="userName">Nom d'utilisateur</label>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <input type="text" id="userName" name="user_name" value="<?php echo set_value('user_name'); ?>" maxlength="100" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <label for="userFirst">Prénom</label>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <input type="text" id="userFirst" name="user_firstname" value="<?php echo set_value('user_firstname'); ?>" maxlength="100" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <label for="userEmail">Email</label>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <input type="text" id="userEmail" name="user_email" value="<?php echo set_value('user_email'); ?>" maxlength="255" />
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
                    <input type="password" id="userPass" name="user_pwd" maxlength="255" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                    <button type="submit">Créer</button>
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