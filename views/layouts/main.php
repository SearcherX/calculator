<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>

</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>

        <?php
            NavBar::begin(
                [
                    'brandLabel' => \Yii::$app->name,
                    'brandUrl'   => \Yii::$app->homeUrl,
                    'options'    => [
                        'class' => 'navbar-inverse navbar-fixed-top navbar-light bg-warning',
                    ],
                ]
            );

            echo Nav::widget([
                'encodeLabels' => false,
                'options'      => ['class' => 'navbar-nav navbar-right'],
                'items'        => [
                    [
                        'label' => 'Вход',
                        'url' => [
                            '#',
                        ],
                    ],
                ],
            ]);

            NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0 mt-4" role="main">
        <div class="container">
            <?php if (empty($this->params['breadcrumbs']) === false): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="navbar fixed-bottom navbar-light bg-light">
        <div class="container">
            <span class="navbar-text">
              &copy; Практикум "ЭФКО Цифровые решения" <?= date('Y') ?>
            </span>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>