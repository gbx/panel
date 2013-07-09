<h2 class="main-subheadline for-items">
  All users
  <button class="round submit button" data-event="action" data-action="iframe" href="<?php echo module()->url('add') ?>"><i class="icon plus">✚</i> New</button>
</h2>

<ul class="users items columns">

  <?php $n=0; foreach($users as $user): $n++; ?>
  <li class="column three<?php e($n%2 == 0, ' last') ?>">
    <article class="item user">

      <figure class="user-preview">
        <a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/picture/upload') ?>"><img src="<?php echo $user->avatar()->url() ?>" /></a>
      </figure>

      <div class="item-info user-info">
        <h1><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/edit') ?>" class="item-headline user-headline"><?php echo $user->username() ?></a></h1>
        <p><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/edit') ?>" class="item-subheadline user-subheadline"><?php e($user->email() == '', 'no email', $user->email()) ?></a></p>
      </div>

      <nav class="item-options user-options" role="navigation">
        <h1 class="is-hidden">User Options</h1>
        <a class="toggle" href="#user-options-<?php echo $n ?>" data-event="action" data-action="dropdown">Toggle Options</a>
        <ul id="user-options-<?php echo $n ?>" class="dropdown has-no-bullets">
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/edit') ?>">Edit user</a></li>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/picture/upload') ?>">Change picture…</a></li>
          <?php if($user->avatar()->exists()): ?>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/picture/delete') ?>">Delete picture…</a></li>
          <?php endif ?>
          <li class="dropdown-item"><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/delete') ?>">Delete user</a></li>
        </ul>
      </nav>

    </article>
  </li>
  <?php endforeach ?>

</ul>

