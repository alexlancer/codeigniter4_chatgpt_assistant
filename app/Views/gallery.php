<div class="row">
  <?php foreach($photos as $photo ) : ?>
    <?= view('components/gallery_item', $photo) ?>
  <?php endforeach; ?>
</div>