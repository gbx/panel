<div class="form">

  <h1 class="user-profile-headline">User</h1>

  <div class="user-profile">

    <dl>
      <dt>Username</dt>
      <dd><?php echo html($user->username()) ?></dd>

      <dt>Email</dt>
      
      <?php if($user->email() == ''): ?>
      <dd>(no email)</dd>
      <?php else: ?>
      <dd><?php echo html::email($user->email()) ?></dd>
      <?php endif ?>

      <dt>Group</dt>
      <dd><?php echo html($user->group()) ?></dd>
    </dl>

    <figure>
      <img src="<?php echo $user->avatar()->url(50) ?>" alt="<?php echo html($user->username()) ?>" />
    </figure>

  </div>

  <?php echo PanelForm::buttons(array('cancel' => 'Close', 'submit' => false)) ?>

</div>