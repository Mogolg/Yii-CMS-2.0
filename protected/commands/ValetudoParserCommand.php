<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.10.12
 * Time: 22:38
 * To change this template use File | Settings | File Templates.
 */

class ValetudoParserCommand extends CConsoleCommand
{
    public function actionParsePosts()
    {
        Yii::import('application.modules.mma.components.*');

        $parser = new ValetudoParser();
        $parser->parsePosts();
    }
}