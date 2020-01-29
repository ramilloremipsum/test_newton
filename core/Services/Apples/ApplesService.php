<?php


namespace core\Services\Apples;


use core\ActiveRecord\Apples\AppleColors;
use core\ActiveRecord\Apples\Apples;
use core\Exceptions\AppleAlreadyDroppedException;
use core\Exceptions\AppleCannotHangRotten;
use core\Forms\backend\Trees\EatAppleForm;
use core\Forms\backend\Trees\CreateAppleForm;
use core\Helpers\NewtonHelper;
use core\Repositories\ApplesRepository;
use core\Repositories\TreesRepository;
use yii\helpers\ArrayHelper;

class ApplesService
{

    private $applesRepository;
    private $treesRepository;

    public function __construct(ApplesRepository $applesRepository, TreesRepository $treesRepository)
    {
        $this->applesRepository = $applesRepository;
        $this->treesRepository = $treesRepository;
    }


    public function create($tree_id, $color_id)
    {
        $apple = Apples::create($color_id, $tree_id);
        $this->applesRepository->save($apple);
    }

    public function dropApple($apple_id)
    {
        $apple = $this->applesRepository->findById($apple_id);
        if (!$apple->is_on_tree) {
            throw new AppleAlreadyDroppedException();
        }
        $apple->setDropped();
        $this->applesRepository->save($apple);
        return $apple;

    }

    public function eat(EatAppleForm $eatAppleForm)
    {
        $apple = $this->applesRepository->findById($eatAppleForm->apple_id);
        $apple->eat($eatAppleForm->eat_percent);
//        NewtonHelper::debug($apple->size);
        if ($apple->size == 0) {
            $this->applesRepository->delete($apple);
        } else {
            $this->applesRepository->save($apple);
        }
        return $apple;
    }

    public function hangApple($apple_id)
    {
        $apple = $this->applesRepository->findById($apple_id);
        if ($apple->is_on_tree) {
            throw new AppleAlreadyDroppedException();
        }
        if ($apple->isRotten) {
            throw new AppleCannotHangRotten();
        }
        $apple->setHanged();
        $this->applesRepository->save($apple);
        return $apple;
    }

    public function fillUpTree($tree_id)
    {
        $tree = $this->treesRepository->findById($tree_id);
        $apple_colors = $this->applesRepository->getAllColors();
        $apple_colors_arr = ArrayHelper::map($apple_colors, 'id', 'id');
        $count = rand(Apples::MIN_RANDOM_GENERATE, Apples::MAX_RANDOM_GENERATE);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->treesRepository->clean($tree);
            for ($i = 0; $i < $count; $i++) {
                $rand_color_id = array_rand($apple_colors_arr, 1);
                $this->create($tree->id, $rand_color_id);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

}