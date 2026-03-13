<?php

ob_start();

$message = $_SESSION['error']['message'] ?? '';
?>
<section class="formLogin">
  <h1>S'identifier</h1>

  <?php if ($message): ?>
    <div class="form-error"><?= $message ?></div>
  <?php endif; ?>

  <form action="/login" method="POST">
      <label for="username">Nom d'utilisateur :</label>
      <input id="username" name="username" type="text" value="<?= old('username') ?>" placeholder="username" required />
      <div class="error"><?= error('username') ?></div>

      <label for="password">Mot de passe :</label>
      <input id="password" name="password" type="password" placeholder="password" required />
      <div class="error"><?= error('password') ?></div>

      <button type="submit">S'identifier</button>
  </form>

  <p>Vous n'avez pas de compte ? <a href="/register">Inscrivez-vous !</a></p>
</section>

<?php
unset($_SESSION['error'], $_SESSION['old']);
$content = ob_get_clean();
require VIEWS . 'layout.php';
