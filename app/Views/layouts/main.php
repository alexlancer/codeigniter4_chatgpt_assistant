<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CiAssistant w/ ChatGPT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
    .alert-success,
    .alert-primary,
    .alert-danger {
      color: #fff;
    }

    .alert-warning {
      color: #000;
    }

    #articleNotifications .alert,
    #imageNotifications .alert {
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
    }
    
    #imageNotifications .btn-close,
    #articleNotifications .btn-close {
      display: none;
    }
  </style>
</head>

<body>


  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
        <?= view('components/nav') ?>
        <?= view_cell('Components::alerts') ?>
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <?= $this->renderSection('js') ?>

</body>

</html>