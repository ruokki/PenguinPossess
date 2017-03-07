<form name="login" method="POST" action="">
    <h1>Réinitialisation du mot de passe</h1>
    <?php if(isset($errors)) : ?>
    <?php $this->view('template/form_errors'); ?>
    <?php endif; ?>
    <div>
        <div class="floatingLabel">
            <input type="text" id="userMail" name="user_email" value="<?php echo set_value('user_email'); ?>" maxlength="100" />
            <label for="userName">Adresse mail</label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div id="crea" class="box">
                <a href="<?php echo site_url('home/login'); ?>" >Retour</a>
            </div>
        </div>
        <div class="col-xs-6">
            <button type="submit">Réinitialiser</button>
        </div>
    </div>
</form>