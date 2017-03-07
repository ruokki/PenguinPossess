<form name="login" method="POST" action="">
    <h1>Nouveau mot de passe</h1>
    <?php if(isset($errors)) : ?>
    <?php $this->view('template/form_errors'); ?>
    <?php endif; ?>
    <div>
        <div class="floatingLabel">
            <input type="password" id="userNewPass" name="user_pwd" maxlength="100" />
            <label for="userName">Nouveau mot de passe</label>
        </div>
    </div>
    <div>
        <div class="floatingLabel">
            <input type="password" id="userNewPassConfirm" name="user_pwd_confirm" maxlength="100" />
            <label for="userName">Confirmer le nouveau mot de passe</label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-offset-6 col-xs-6">
            <button type="submit">Changer de mot de passe</button>
        </div>
    </div>
</form>