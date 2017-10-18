<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/10/16
 * Time: 16:30
 */

namespace App\Services\View;


class ViewFactory
{

    /**
     * @param $index
     * @param $type
     * @param $id
     * @param array $options
     * @return array|null
     */
    public static function getViewer($index, $type, $id, $options = [])
    {
        $conf = config("viewer.types.$type");
        if (!$conf) {
            return null;
        }
        $model = isset($conf['model']) ? $conf['model'] : null;
        $view = isset($conf['view']) ? $conf['view'] : null;
        $opt = isset($conf['options']) ? $conf['options'] : [];
        $options = array_merge($opt, $options);
        $rf = new \ReflectionClass("App\Models\\$model");
        $ins = $rf->getMethod('find')->invokeArgs(null, [$id, $index, $type, $options]);
        if (!$ins) {
            return null;
        }
        return ['view'=>$view, 'model'=>$ins->toArray(), 'title'=>isset($conf['title']) ? $conf['title'] : ''];
    }
}