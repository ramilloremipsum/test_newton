<?php


namespace core\Repositories;


use core\ActiveRecord\Apples\AppleColors;
use core\ActiveRecord\Apples\Apples;
use RuntimeException;

class ApplesRepository
{
    public static function create($color_id, $tree_id)
    {
        $apple = new Apples();
        $apple->color_id = $color_id;
        $apple->tree_id = $tree_id;
        $apple->generateCreatedAt();
        $apple->size = 1;
        $apple->is_on_tree = 1;
        $apple->fell_at = NULL;
        return $apple;
    }

    /**
     * @param $id
     * @return Apples|null
     */
    public static function findById($id)
    {
        $apple = Apples::findOne($id);
        if(!$apple){
            throw new RuntimeException('Apple not found');
        }
        return $apple;
    }
    public static function getAllColors()
    {
        $apple_colors = AppleColors::find()->all();
        if(!$apple_colors){
            throw new RuntimeException('Apple colors not found');
        }
        return $apple_colors;
    }

    public static function save(Apples $apple)
    {
        if (!$apple->save()) {
            throw new \RuntimeException('Cannot save apple');
        }
    }
    public static function delete(Apples $apple)
    {
        if (!$apple->delete()) {
            throw new \RuntimeException('Cannot delete apple');
        }
    }
}