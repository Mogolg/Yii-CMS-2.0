<?php

function p($data)
{
    echo '<pre>';
    CVarDumper::dump($data, 1000, false);
    echo '</pre>';
}


function v($data)
{
    echo "<pre>" . var_dump($data) . "</pre>";
}


if (function_exists('get_called_class') === false)
{
    function get_called_class()
    {
        $bt    = debug_backtrace();
        $lines = file($bt[1]['file']);
        preg_match('/([a-zA-Z0-9\_]+)::' . $bt[1]['function'] . '/', $lines[$bt[1]['line'] - 1], $matches);
        return $matches[1];
    }
}


if (function_exists('lcfirst') === false)
{
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}


function t($message)
{
    $modules_classes = array_keys(AppManager::getModulesData(true));

    $modules_classes[] = 'MainModule';
    $modules_classes[] = get_class(Yii::app()->controller->module);

    krsort($modules_classes);

    $modules_classes = array_unique($modules_classes);

    foreach ($modules_classes as $module_class)
    {
        $translated_message = Yii::t($module_class . '.main', $message);
        if ($translated_message != $message)
        {
            return $translated_message;
        }
    }

    return $message;
}

//для работы моих отладочных функций нужны 2 переменных, мне их глобальными объявлять?
class Y extends CComponent
{
    private static $startSkipCount = 0;
    private static $skipCount = 0;


    /**
     * Ярлык для функции dump класса CVarDumper для отладки приложения
     *
     * @param mixed   $var   переменная для вывода
     * @param boolean $toDie остановить ли дальнейшее выполнение приложения, по умолчанию - true
     */
    public static function dump($var, $skipCount = 0, $depth = 2)
    {
        if (self::$startSkipCount == 0) {
            self::$startSkipCount = self::$skipCount = $skipCount;
        }
        else
        {
            self::$skipCount--;
        }

        if (self::$skipCount == 0)
        {
            self::$startSkipCount = 0;

            echo '<pre>';
            CVarDumper::dump($var, $depth, true);
            echo '</pre>';

            Y::end();
        }
    }


    /**
     * Выводит текст и завершает приложение (применяется в ajax-действиях)
     *
     * @param string $text текст для вывода
     */
    public static function end($data = '')
    {
        if (is_array($data))
        {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
        else
        {
            echo $data;
        }

        Yii::app()->end();
    }
}