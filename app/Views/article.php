<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="card mt-3">

  <form id="writerForm">
    <div class="card-header">
      AI Writer
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label for="prompt" class="form-label">Write an article about...</label>
        <input type="text" class="form-control" required id="prompt" name="prompt" aria-describedby="promptHelp">
        <div id="promptHelp" class="form-text">provide a prompt about the article you want to write</div>
      </div>
      <div id="postWrapper" class="d-none">
        <div id="articleContent"></div>
        <hr>
        <h4>Meta description</h4>
        <div id="metaDescription" class="border fst-italic p-2"></div>
      </div>

      <div id="articleNotifications"></div>
    </div>
    <div class="card-footer text-center">
      <button id="submit" type="submit" class="btn btn-primary">Generate</button>
      <div id="spinner" class="spinner-border text-light d-none" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </form>
</div>
<div id="imageExplorer" class="card mt-5 d-none">

  <form id="imageExplorerForm">
    <div class="card-header">
      Image Explorer
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label for="prompt" class="form-label">Terms to search images</label>
        <input type="text" class="form-control" required id="keywords" name="keywords" aria-describedby="keywordsHelp">
        <div id="keywordsHelp" class="form-text">you can edit these AI-generated keywords as you like</div>
      </div>
      <div id="imageNotifications"></div>
    </div>
    <div class="card-footer text-center">
      <button id="imageSubmit" type="submit" class="btn btn-primary">Search for images</button>
      <div id="imageSpinner" class="spinner-border text-light d-none" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="/assets/js/ciassistant.js"></script>
<?= $this->endSection() ?>