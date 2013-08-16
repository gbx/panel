<section class="items with-small-previews">

  <header class="items-header">
    <h1 class="items-headline">Users</h1>
  </header>

  <?php $n=0; foreach($users as $user): $n++; ?>
  <article class="item user">

    <figure class="item-preview">
      <a data-event="action" data-action="iframe" href="<?php echo url('users > pictures::upload', $user->username()) ?>">
        <?php if($user->avatar()->exists()): ?>
        <?php echo $user->avatar()->thumb('50|50|crop') ?>
        <?php else: ?>
        <img src="<?php echo url('assets/images/users/avatar.png') ?>" />
        <?php endif ?>
      </a>
    </figure>

    <header class="item-info">
      <h1 class="item-title"><a href="<?php echo url('users > users::edit', $user->username()) ?>" class="item-headline user-headline"><?php echo $user->username() ?></a></h1>
      <h2 class="item-subtitle"><a href="<?php echo url('users > users::edit', $user->username()) ?>" class="item-subheadline user-subheadline"><?php e($user->email() == '', 'no email', $user->email()) ?></a></h2>
    </header>

    <nav class="item-options" role="navigation">
      <h1 class="is-hidden">User Options</h1>

      <a class="item-options-toggle" href="#user-options-<?php echo $n ?>" data-event="action" data-action="dropdown">Toggle Options</a>

      <ul id="user-options-<?php echo $n ?>" class="dropdown has-no-bullets">
        <li class="dropdown-item">
          <a href="<?php echo url('users > users::edit', $user->username()) ?>">Edit user</a>
        </li>
        <li class="dropdown-item">
          <a data-event="action" data-action="iframe" href="<?php echo url('users > pictures::upload', $user->username()) ?>">Change picture…</a>
        </li>
        <?php if($user->avatar()->exists()): ?>
        <li class="dropdown-item">
          <a data-event="action" data-action="iframe" href="<?php echo url('users > pictures::delete', $user->username()) ?>">Delete picture…</a>
        </li>
        <?php endif ?>
        <li class="dropdown-item">
          <a data-event="action" data-action="iframe" href="<?php echo url('users > users::delete', $user->username()) ?>">Delete user</a>
        </li>
      </ul>

    </nav>

  </article>
  <?php endforeach ?>

  <a href="<?php echo url('users > users::add') ?>" class="empty">Click to add a new user…</a>

</section>