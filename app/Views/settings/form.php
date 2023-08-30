<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php session(); ?>
<div class="card mt-3">

  <form method="post">
    <div class="card-header">
      OpenAi Settings
    </div>
    <div class="card-body">

      <div class="mb-3">
        <label for="behavior" class="form-label">Behavior</label>
        <textarea required class="form-control" name="behavior" id="behavior" rows="5"><?= set_value('behavior', $behavior) ?></textarea>
        <div id="behaviorHelp" class="form-text">Describe how you want OpenAi to behave when creating the article.</div>
      </div>
      <div class="mb-3">
        <label for="append" class="form-label">Append</label>
        <textarea required class="form-control" name="append" id="append" rows="5"><?= set_value('append', $append) ?></textarea>
        <div id="appendHelp" class="form-text">This text will be appended to all of the requests. </div>
      </div>
      <div class="mb-3">
        <label for="model" class="form-label">Model</label>
        <select required id="model" class="form-select" name="model" aria-label="Default select example">
          <?php foreach (OPEN_AI_MODELS as  $oam) : ?>
            <option value="<?= $oam ?>" <?= set_select('model', $oam, ($oam == $model)) ?>><?= $oam ?></option>
          <?php endforeach; ?>
        </select>
        <div id="modelHelp" class="form-text">Choose OpenAi model</div>
      </div>
      <div class="mb-3">
        <label for="tokens" class="form-label">Tokens</label>
        <input required id="tokens" class="form-control" type="number" step="1" name="tokens" value="<?= set_value('tokens', ($tokens ? $tokens : 1000)) ?>"></input>
        <div id="tokensHelp" class="form-text">This will define the max allowed length of context (request & response combined)</div>
      </div>
      <div class="mb-3">
        <label for="temperature" class="form-label">Temperature</label>
        <select required id="temperature" class="form-select" name="temperature" aria-label="Default select example">
          <?php $i = 0.0;
          while ($i <= 1) :  ?>
            <option value="<?= $i ?>" <?= set_select('temperature', $i, (number_format($i, 1) == $temperature)) ?>><?= number_format($i, 1) ?></option>
          <?php $i = $i + 0.1;
          endwhile; ?>
        </select>
        <div id="temperatureHelp" required class="form-text">Select how creative you want OpenAi to be. 0.0 is less creative than 1.0</div>
      </div>
    </div>

    <div class="card-footer text-center">
      <button type="submit" class="btn btn-primary">Submit</button>

    </div>
  </form>
</div>

<?= $this->endSection() ?>