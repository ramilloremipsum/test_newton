<?php


namespace core\Repositories;

use core\ActiveRecord\Trees\Trees;
use RuntimeException;


class TreesRepository
{


    public static function save(Trees $tree)
    {
        if (!$tree->save()) {
            throw new RuntimeException('Cannot save tree');
        }
    }

    /**
     * @param $id
     * @return Trees|null
     */
    public static function findById($id)
    {
        $tree = Trees::findOne($id);
        if (!$tree) {
            throw new RuntimeException('Tree not found');
        }
        return $tree;
    }
    public static function clean(Trees $tree)
    {
        foreach ($tree->apples as $apple){
            if (!$apple->delete()) {
                throw new RuntimeException('Cannot delete apples from tree');
            }
        }
    }
}