<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/static/css/person.css">
    <link rel="stylesheet" type="text/css" href="/static/css/login.css">
    <link rel="stylesheet" type="text/css" href="/static/css/register.css">
    <link rel="stylesheet" type="text/css" href="/static/css/update.css">
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <title></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

 <?= $content ?>

</body>
    <script type="text/javascript" src="/static/js/show.js"></script>
    <script type="text/javascript" src="/static/js/user.js"></script>
</html>

