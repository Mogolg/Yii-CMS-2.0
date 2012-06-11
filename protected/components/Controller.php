<?

/**
 * TODO: убить интерфес он тут не нужен
 */
abstract class Controller extends CController implements ControllerInterface
{
    const MSG_SUCCESS = 'success';
    const MSG_DANGER  = 'danger';
    const MSG_ERROR   = 'error';
    const MSG_INFO    = 'info';

    public static $msg_types = array(self::MSG_DANGER, self::MSG_ERROR, self::MSG_INFO, self::MSG_SUCCESS);

    public $layout = '//layouts/main';

    public $page_title;

    public $meta_title;

    public $meta_description;

    public $meta_keywords;

    public $crumbs = array();

    public $is_ssl_protected = false;

    public $system_actions = array(
        'captcha','help','error'
    );

    public function filters()
    {
        return array(
            array('application.components.filters.LanguageFilter'),
            array('application.components.filters.SiteEnableFilter'),
            array('application.components.filters.HttpsFilter'),
            array('application.components.filters.XssFilter'),
            array('application.components.filters.MetaTagsFilter + view'),
            array('application.components.filters.StatisticFilter'),
            array('application.components.filters.ThemeFilter'),
            array('application.components.filters.ReturnUrlFilter'),
        );
    }


    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'CCaptchaAction',
                'testLimit' => 6,
                'minLength' => 4,
                'maxLength' => 5,
                'offset'    => 1,
                'width'     => 68,
                'height'    => 30,
                'backColor' => 0xBBBBBB,
                'foreColor' => 0x222222
            )
        );
    }


    public function beforeAction($action)
    {
        $action_name = lcfirst($action->id);

        if (in_array($action_name, $this->system_actions))
        {
            return true;
        }
        else
        {
            $item_name = AuthItem::constructName(Yii::app()->controller->id, $action_name);
        }

        $this->setTitle($this->actionsTitles(), $action_name);

        return true;
    }

    public function afterAction($action)
    {
        if (isset(Yii::app()->params->save_site_actions) && Yii::app()->params->save_site_actions)
        {
            MainModule::saveSiteAction();
        }
    }


    public function getModelClass()
    {
        return ucfirst(str_replace('Admin', '', $this->id));
    }


    /**
     * Set pageTitle if empty.
     * Support actionProviders, see {@link CController::actions}
     *
     * @param array $action_titles
     * @param string $action_name
     *
     * @return mixed
     * @throws CException
     */
    public function setTitle($action_titles, $action_name)
    {
        $pos=strpos($action_name, '.');
        if($pos===false && isset($action_titles[$action_name]))
        {
            return $this->page_title = $action_titles[$action_name];
        }
        else if($pos===false)
        {
            throw new CException('Не найден заголовок для дейсвия ' . $action_name);
        }

		// the action is defined in a provider
		$prefix = substr($action_name, 0, $pos+1);
        $actions = $this->actions();
        if (!isset($actions[$prefix]))
        {
            throw new CException('Не найден заголовок для дейсвия ' . $action_name);
        }

		$action_name = (string)substr($action_name, $pos+1);

		$provider = $actions[$prefix];
        $provider_alias = is_string($provider) ? $provider : $provider['class'];

		$class = Yii::import($provider_alias, true);
		$map = call_user_func(array($class, 'actionsTitles'));

		$this->setTitle($map, $action_name);
    }


    protected function pageNotFound()
    {
        throw new CHttpException(404, t('Страница не найдена!'));
    }


    protected function forbidden($auth_item = null)
    {
        $msg = t('Запрещено!');
        if (YII_DEBUG && $auth_item)
        {
            $msg.= ' AuthItem : ' .$auth_item;
        }
    
        throw new CHttpException(403, $msg);
    }


    protected function badRequest()
    {
        throw new CHttpException(400, t('Неверный запрос!'));
    }


    public function getRequest()
    {
        return Yii::app()->request;
    }


    public static function msg($msg, $type)
    {
        return CHtml::tag('div', array('class'=>"alert alert-{$type}"), $msg);
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Возвращает модель по атрибуту и удовлетворяющую скоупам,
     * или выбрасывает 404
     *
     * @param string     $class  имя класса модели
     * @param int|string $value  значение атрибута
     * @param array      $scopes массив скоупов
     * @param string     $attribute
     *
     * @return CActiveRecord
     */
    public function loadModel($value, $scopes = array(), $attribute = null)
    {
        $model = CActiveRecord::model($this->getModelClass());

        foreach ($scopes as $scope)
        {
            $model->$scope();
        }

        if ($attribute === null)
        {
            $model = $model->findByPk($value);
        }
        else
        {
            $model = $model->findByAttributes(array(
                $attribute => $value
            ));
        }

        if ($model === null)
        {
            $this->pageNotFound();
        }

        return $model;
    }


    public function isRootUrl($url = null)
    {
        if (!$url)
        {
            $url = $_SERVER["REQUEST_URI"];
        }

        $languages = Language::getList();
        return isset($languages[trim($url, "/")]);
    }

    /**
     * add profile information to std widget call
     *
     * @param string $className
     * @param array $properties
     * @param bool $captureOutput
     * @return mixed
     */
    public function widget($className,$properties=array(),$captureOutput=false)
    {
        $profile_id = 'Widget::'.$className;

        //profile widget
        Yii::beginProfile($profile_id);
        $res = parent::widget($className,$properties,$captureOutput);
        Yii::endProfile($profile_id);
        return $res;
    }


    public function render($view, $params = array())
    {
        if (isset($_GET['popup']))
        {
            $this->layout = false;
        }

        return parent::render($view, $params);
    }


    public function redirect($params)
    {
        if (isset($_GET['popup']))
        {
            $view = array_shift($params);
            $params['popup'] = 1;
            array_unshift($params, $view);
        }

        parent::redirect($params);
    }
}
