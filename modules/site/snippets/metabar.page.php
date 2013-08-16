<section class="metabar-section url">
  <h1 class="metabar-section-headline">URL</h1>
  <?php echo html::a($page->url(), url::short($page->url())) ?></a>
</section>

<section class="metabar-section url">
  <h1 class="metabar-section-headline">Options</h1>
  <ul>
    <li><a data-event="action" data-action="iframe" href="<?php echo url('site > page::url', array('uri' => $page->uri())) ?>">Change the URL…</a></li>
    <li><a data-event="action" data-action="iframe" href="<?php echo url('site > page::template', array('uri' => $page->uri())) ?>" href="">Change the Template…</a></li>
    <li><a data-event="action" data-action="iframe" href="<?php echo url('site > page::delete', array('uri' => $page->uri())) ?>" href="">Delete this page…</a></li>
  </ul>
</section>

<!--
<?php if($files->count()): ?>
<section class="metabar-section url">

  <h1 class="metabar-section-headline">Files</h1>

  <ul class="files">
    <?php foreach($files as $file): ?>  
    <li><a href="" data-tag="(image: <?php echo $file->filename() ?>)"><strong><?php echo html($file->filename()) ?></strong> <small><?php echo $file->niceSize() ?></small></a></li>
    <?php endforeach ?>
  </ul>

</section>
<?php endif ?>


<section class="metabar-section url">
  <h1 class="metabar-section-headline">Upload</h1>  
  <div class="empty dropzone">
    Click or drag a file here
  </div>
</section>

-->