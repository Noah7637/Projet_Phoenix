<?php

ob_start();

$message = $_SESSION['error']['message'] ?? '';
?>
<section class="formRegister">
  <h1>S'inscrire</h1>
  <div class="separateur"></div>

  <?php if ($message): ?>
    <div class="form-error"><?= $message ?></div>
  <?php endif; ?>

  <form action="/register" method="post">
      <label for="username">Nom d'utilisateur :</label>
      <input id="username" name="username" type="text" value="<?= old('username') ?>" placeholder="username" required />
      <div class="error"><?= error('username') ?></div>

      <label for="email">Email :</label>
      <input id="email" name="email" type="email" value="<?= old('email') ?>" placeholder="email" required />
      <div class="error"><?= error('email') ?></div>

      <label for="inputPassword">Mot de passe :</label>
      <input id="inputPassword" name="password" type="password" placeholder="password" required />
      <div class="error"><?= error('password') ?></div>

      <label for="inputPasswordConfirm">Confirmer le mot de passe :</label>
      <input id="inputPasswordConfirm" name="password_confirm" type="password" placeholder="confirmer le mot de passe" required />
      <div class="error"><?= error('password_confirm') ?></div>

      <button type="submit">S'inscrire</button>
  </form>

  <p>Vous avez déjà un compte ? <a href="/login">Identifiez-vous !</a></p>
</section>

<script>
(function(){
  var toggle = function(btnId, inputId){
    var btn = document.getElementById(btnId);
    var input = document.getElementById(inputId);
    if (!btn || !input) return;
    btn.addEventListener('click', function(e){
      e.preventDefault();
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  };
  // create small toggle buttons if you want (optional)
  // toggle('btnPassword','inputPassword');
  // toggle('btnPasswordConfirm','inputPasswordConfirm');
})();
</script>

<?php
// clear session flash data after rendering
unset($_SESSION['error'], $_SESSION['old']);
$content = ob_get_clean();
require VIEWS . 'layout.php';