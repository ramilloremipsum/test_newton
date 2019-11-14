<?php

namespace backend\controllers;

use core\ActiveRecord\Apples\AppleColors;
use core\ActiveRecord\Trees\Trees;
use core\Forms\backend\Trees\EatAppleForm;
use core\Forms\backend\Trees\CreateAppleForm;
use core\Repositories\TreesRepository;
use core\Services\Apples\ApplesService;
use core\Services\Trees\TreesService;
use Exception;
use Yii;
use yii\base\UserException;
use yii\web\Controller;
use yii\filters\VerbFilter;


class TreesController extends Controller
{
    private $treesService;
    private $applesService;

    public function __construct($id, $module, TreesService $treesService, ApplesService $applesService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->treesService = $treesService;
        $this->applesService = $applesService;
    }


    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'drop-apple' => ['post'],
                    'hang-apple' => ['post'],
                    'fill-up' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $trees = Trees::find()->orderBy('id DESC')->all();
        return $this->render('index', [
            'trees' => $trees
        ]);
    }

    public function actionCreate()
    {
        try {
            $tree = $this->treesService->create();
            Yii::$app->session->addFlash('success', 'Я успешно создал дерево. Я его назвал "'.$tree->name.'" Не благодари.');
        } catch (Exception $e) {
            throw $e;
        }
        return $this->redirect(['trees/index']);
    }

    public function actionView($id)
    {
        $tree = TreesRepository::findById($id);
        $createAppleForm = new CreateAppleForm($tree);
        $eatAppleForm = new EatAppleForm();
        $appleColors = AppleColors::find()->all();
        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post('eat') == 1) {
                if ($eatAppleForm->load(Yii::$app->request->post()) && $eatAppleForm->validate()) {
                    try {
                        $apple = $this->applesService->eat($eatAppleForm);
                        Yii::$app->session->addFlash('success', 'Ты успешно оттяпал ' . $eatAppleForm->eat_percent . '% яблока');
                        if ($apple->size == 0) {
                            Yii::$app->session->addFlash('warning', 'Ты уничтожил яблоко.');
                        }
                    } catch (UserException $e) {
                        Yii::$app->session->setFlash('danger', $e->getMessage());
                    } catch (Exception $e) {
                        throw $e;
                    }
                }
                return $this->refresh();
            }
            if (Yii::$app->request->post('create-apple') == 1) {
                if ($createAppleForm->load(Yii::$app->request->post()) && $createAppleForm->validate()) {
                    try {
                        $this->applesService->create($createAppleForm->getTree()->id,$createAppleForm->color_id);
                        Yii::$app->session->addFlash('success', 'Яблоко добавлено на это дерево.');
                    } catch (Exception $e) {
                        throw $e;
                    }
                }
                return $this->refresh();
            }
        }
        return $this->render('view', [
            'tree' => $tree,
            'appleColors' => $appleColors,
            'createAppleForm' => $createAppleForm,
            'eatAppleForm' => $eatAppleForm
        ]);
    }

    public function actionDropApple()
    {
        $post = Yii::$app->request->post();
        try {
            $this->applesService->dropApple($post['apple_id']);
            Yii::$app->session->setFlash('success', 'Яблоко успешно упало.');
        } catch (UserException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Exception $e) {
            throw $e;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionHangApple()
    {
        $post = Yii::$app->request->post();
        try {
            $apple = $this->applesService->hangApple($post['apple_id']);
            if($apple->size ==1){
                Yii::$app->session->addFlash('success', 'Ты повесил яблоко обратно. Кстати, это не спасет его от гниения.');
            }else{
                Yii::$app->session->addFlash('success', 'Ты повесил откусанное яблоко обратно.');
                if ($apple->size > 0.1) {
                    Yii::$app->session->addFlash('success', 'И да, я не скажу никому, что это ты его откусил.');
                }else{
                    Yii::$app->session->addFlash('success', 'Ну и как ты себя чувствуешь после этого?');
                }
            }
        } catch (UserException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Exception $e) {
            throw $e;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionFillUp()
    {
        $post = Yii::$app->request->post();
        try {
            $this->applesService->fillUpTree($post['tree_id']);
        } catch (UserException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Exception $e) {
            throw $e;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
