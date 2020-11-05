<!doctype html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?> | CakePHP 3.x autocomplete input
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css') ?>
    <?= $this->Html->css('demo.css') ?>
    <?= $this->Html->css('style.css') ?>
</head>

<body>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col col-lg-3">
            <div class="demo">
                <div class="demo-middle">

                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js') ?>
<?= $this->Html->script('scripts.js') ?>
</body>

</html>
