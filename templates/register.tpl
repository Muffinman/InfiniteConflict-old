<h1>Registration</h1>
<div class="formdiv">
  <form action="" method="post">
    <p>Complete the registration form below to create your empire.</p>
    <div class="login-box">
      <p>
        <label for="email">Email:</label>
        <input type="email" name="email" autofocus="autofocus" required="required" value="{$formdata.email}"{if $errors.email} class="error"{/if}>  {if $errors.email} <span class="error">{$errors.email}</span>{/if}
      </p>
      <p>
        <label for="email2">Email (confirm):</label>
        <input type="email" name="email2" required="required" value="{$formdata.email2}"{if $errors.email2} class="error"{/if}> {if $errors.email2} <span class="error">{$errors.email2}</span>{/if}
      </p>
      <p>
        <label for="password">Password:</label>
        <input type="password" minlength="6" name="password" required="required" {if $errors.password} class="error"{/if}>  {if $errors.password} <span class="error">{$errors.password}</span>{/if}
      </p>
      <p>
        <label for="password2">Password (confirm):</label>
        <input type="password" minlength="6" name="password2" required="required" {if $errors.password2} class="error"{/if}>  {if $errors.password2} <span class="error">{$errors.password2}</span>{/if}
      </p>
      <p class="submit"><input type="submit" value="Register"></p>
      <p class="form-options"><a href="/login">Login</a> | <a href="/forgotten">Forgotten your login?</a> | <a href="/support">Support</a></p>

    </div>
  </form>
</div>