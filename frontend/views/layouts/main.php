<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'ItLadder',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (\Yii::$app->user->can('dashboad')) {
        $menuItems = [
            ['label' => Yii::t('app/menu','Feed'), 'url' => ['/feed']],
            ['label' => Yii::t('app/menu','Users'), 'url' => ['/user/index']],
            ['label' => Yii::t('app/profile','All blog'), 'url' => ['/blog/list']],
            ['label' => Yii::t('app/menu','Mailer'), 'url' => ['/mailer/index']],
            ['label' => Yii::t('app/menu','Tools'), 'url' => ['/tools/index'], 'items' =>[
                ['label' => Yii::t('app/menu','Grid'), 'url' => ['/grid/index']],
                ['label' => Yii::t('app/menu','Stage'), 'url' => ['/stage/index']],
                ['label' => Yii::t('app/menu','Position'), 'url' => ['/position/index']],
                ['label' => Yii::t('app/menu','Group'), 'url' => ['/group/index']],
                ['label' => Yii::t('app/menu','Profession'), 'url' => ['/profession/index']],
                ['label' => Yii::t('app/menu','Resource'), 'url' => ['/resource/index']],
            ]],

        ];
    } else
    if (\Yii::$app->user->can('user')) {
        $menuItems = [
            ['label' => Yii::t('app/menu','Feed'), 'url' => ['/feed']],
            ['label' => Yii::t('app/menu','Users'), 'url' => ['/profile']],
            ['label' => Yii::t('app/profile','All blog'), 'url' => ['/blog/list']],
        ];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app/menu','Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app/menu','Login'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => Yii::t('app/menu','Logout') . ' (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; IT Ladder <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
