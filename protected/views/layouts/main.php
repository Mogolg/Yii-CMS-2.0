<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><? echo $this->meta_title ?></title>
    <meta name="description" content="<? echo $this->meta_description ?>">
    <meta name="keywords" content="<? echo $this->meta_keywords ?>">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.ico">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?
    $params = Yii::app()->params;
    $base   = Yii::app()->baseUrl;
    $cs     = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');

    //NodeJS only for loginned users
    if (!Yii::app()->user->isGuest)
    {
        /*
        $cs->registerScriptFile(
            'http://' . $params['nodejs']['host'] . ':' . $params['nodejs']['port'] . '/socket.io/socket.io.js'
        );
        $cs->registerScriptFile(
            Yii::app()->assetManager->publish(APP_PATH . 'components' . DS . 'nodejs' . DS . 'NodeJSClient.js')
        );
        $cs->registerScript('some_id',
            "$('body').coreNodeJSClient(".CJSON::encode($params['nodejs']).")"
        );
        */
    }

    Yii::app()->bootstrap->registerScripts();

    $cs->registerScriptFile('/js/coreFunctions.js');

    $cs->registerCssFile($base . '/css/icons.css');
    $cs->registerCssFile($base . '/css/site/form.css');
    $cs->registerCssFile($base . '/css/site/style.css');
    $cs->registerCssFile($base . '/css/site/menu.css');
    $cs->registerCssFile($base . '/css/site/page.css');
    $cs->registerCssFile($base . '/css/site/comments.css');
    $cs->registerCssFile($base . '/css/site/favorites.css');
    $cs->registerCssFile($base . '/css/site/rating.css');
    $cs->registerCssFile($base . '/css/site/user.css');
    $cs->registerCssFile($base . '/css/site/fighters.css');
    $cs->registerCssFile($base . '/css/site/tags.css');

    $cs->registerScriptFile($base . '/js/site/modal-windows.js');

    #toasmessage plugin, message notifier
    $cs->registerScriptFile('/js/plugins/toastmessage/javascript/jquery.toastmessage.js');
    $cs->registerCssFile('/js/plugins/toastmessage/resources/css/jquery.toastmessage.css');
    $cs->registerScriptFile('/js/plugins/ajaxSetup.js');
    $cs->registerScriptFile('/js/plugins/jquery.checkRights.js');

    #social
    $cs->registerScriptFile('/js/social/favorites.js');
    $cs->registerScriptFile('/js/social/rating.js');

    #comments
    $cs->registerScriptFile('/js/comments/commentsPortlet.js');

    $cs->registerScriptFile('/js/site/ready.js');


    ?>
</head>

<body>
    <?
    //user id
    if (!Yii::app()->user->isGuest)
    {
        echo CHtml::hiddenField('app_user_id', Yii::app()->user->id);
    }
    ?>

    <div id='main-wrapper'>
        <? $this->widget('main.portlets.MainMenu'); ?>
        <? $this->widget('main.portlets.SubMenu'); ?>

        <div class="container-fluid">
            <div class="row-fluid">
                <?
                $sidebars = $this->widget('main.portlets.SidebarManager', array(), true);
                $class    = $sidebars ? 'span8' : 'span12';
                ?>

                <div class="<?= $class ?> well">
                    <? if ($this->page_title): ?>
                    <h1><?= $this->page_title ?></h1>
                    <? endif ?>

                    <? foreach (Yii::app()->user->getFlashes() as $type => $msg): ?>
                    <div class="alert alert-<?= $type ?>"><?= $msg ?></div>
                    <? endforeach ?>

                    <?= $content ?>
                </div>

                <? if ($sidebars): ?>
                    <div class="span4 sidebar-manager">
                        <?= $sidebars  ?>
                    </div>
                <? endif ?>
            </div>
            <hr>

            <footer>
                <p>&copy; Company 2012</p>
            </footer>
        </div>

    </div>
</body>
</html>
