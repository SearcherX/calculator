<?php
use app\assets\AppAsset;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100 overflow-y-auto overflow-x-hidden">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<header id="header">
    <nav id="w0" class="navbar-expand-md navbar-dark bg-dark navbar">
        <div class="container">
            <a href="/" class="navbar-brand">
                <?= Html::img('@web/img/logo.png', ['class' => 'logo', 'alt' => 'ЭФКО'])?>
            </a>
        </div>
    </nav>

    <div class="container-fluid bg-blue">
        <?php
        NavBar::begin([
            'brandLabel' => Html::tag('div', '', ['class' => 'logo']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md menu-container'],
            'containerOptions' => ['class' => ' justify-content-end ']
        ]);

        $items = [
            ['label' => 'Расчет доставки', 'url' => ['/calculator']],
            ['label' => 'Войти в систему', 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest],
            Yii::$app->user->isGuest ? '' : ['label' => Yii::$app->user->identity->username,
                'items' => [
                    ['label' => 'Профиль', 'url' => ['/user/profile?id=' . Yii::$app->user->id]],
                    ['label' => 'История расчётов', 'url' => ['/history']],
                    ['label' => 'Пользователи', 'url' => ['/admin/user'], 'visible' => Yii::$app->user->can('viewProfile')],
                    ['label' => 'Выход', 'url' => ['/user/logout'], 'linkOptions' => ['data-method' => 'post']],
                ],
                'visible' => Yii::$app->user->isGuest === false
            ]
        ];
        echo Nav::widget([
            'options' => ['class' => 'navbar-right d-flex gap-3'],
            'items' => $items
        ]);
        NavBar::end();
        ?>
    </div>

</header>

<?= $content ?>

<footer id="footer " class="mt-auto py-3 bg-light ">
    <div class="container ">
        <div class="row text-muted ">
            <div class="col-md-6 text-center text-md-start ">
                &copy; ЭФКО 2024
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>