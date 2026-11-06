  <div class="abm-info"><span><small>Current login email</small><br><strong><?= abh_e($uname) ?></strong></span><span><small>Current password</small><br><strong>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</strong></span><small>Passwords are stored encrypted, so the saved password cannot be shown. Type it below to confirm any change.</small></div>
  <form class="abm-form abm-form-narrow" method="post" autocomplete="off"><input type="hidden" name="csrf" value="<?= $tok ?>">
    <label>Login email<input name="username" value="<?= abh_e($uname) ?>" required maxlength="100" autocomplete="username"></label>
    <label>Current password<span class="abm-pw"><input type="password" name="current" required autocomplete="current-password"><button type="button" class="abm-eye" data-eye>Show</button></span></label>
    <label>New password (optional, 12+ characters)<span class="abm-pw"><input type="password" name="new" minlength="12" autocomplete="new-password"><button type="button" class="abm-eye" data-eye>Show</button></span></label>
    <label>Confirm new password<span class="abm-pw"><input type="password" name="confirm" minlength="12" autocomplete="new-password"><button type="button" class="abm-eye" data-eye>Show</button></span></label>
    <button class="abm-btn abm-btn-acc" style="justify-self:start">Save changes</button></form>
