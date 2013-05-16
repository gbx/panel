<ul class="users items clear">

  <?php $n=0; foreach($users as $user): $n++; ?>
  <li>
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
        <ul id="user-options-<?php echo $n ?>" class="dropdown">
          <li><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/edit') ?>">Edit user</a></li>
          <li><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/picture/upload') ?>">Change picture…</a></li>
          <?php if($user->avatar()->exists()): ?>
          <li><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/picture/delete') ?>">Delete picture…</a></li>
          <?php endif ?>
          <li><a data-event="action" data-action="iframe" href="<?php echo module()->url($user->username() . '/delete') ?>">Delete user</a></li>
        </ul>
      </nav>

    </article>
  </li>
  <?php endforeach ?>

</ul>

<nav role="navigation" class="editbar is-collapsable is-static">

  <h1 class="is-hidden">Edit-Bar</h1>

  <div class="editbar-content">  
    <div class="editbar-content-left">
      <button data-event="action" data-action="iframe" href="<?php echo module()->url('add') ?>" class="round button">+ New User</button>
    </div>
  </div>

</nav>
