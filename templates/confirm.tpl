<h1>Create your empire</h1>
<div class="formdiv">
  <form action="" method="post">
    <p>Complete the registration form below to create your empire.</p>
    <div class="login-box">
      <p>
        <label for="rulername">Ruler Name:</label>
        <input type="text" name="rulername" autofocus="autofocus" required="required" value="{$formdata.rulername}"{if $errors.rulername} class="error"{/if}>  {if $errors.rulername} <span class="error">{$errors.rulername}</span>{/if}
      </p>
      <p>
        <label for="planetname">Planet Name:</label>
        <input type="text" name="planetname" required="required" value="{$formdata.planetname}"{if $errors.planetname} class="error"{/if}> {if $errors.planetname} <span class="error">{$errors.planetname}</span>{/if}
      </p>
      <p class="submit"><input type="submit" value="Let's Rule!"></p>
      <p class="form-options"><a href="/login">Login</a> | <a href="/register">Register homeworld</a> | <a href="/forgotten">Forgotten?</a> | <a href="/support">Support</a></p>

    </div>
  </form>
</div>