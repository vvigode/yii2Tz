<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Apple;

class AppleController extends Controller
{
    /**
     * Генерация случайного количества яблок.
     * @param int $count количество яблок для генерации
     * @return \yii\web\Response
     */
    public function actionGenerateApples()
    {
        $colors = ['red', 'green', 'yellow'];
        $count = rand(1, 25);
        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            $apple->color = $colors[array_rand($colors)];
            $apple->appearance_date = time();
            $apple->save();
        }
        
        return $this->redirect(['site/index']); // Замените 'site/index' на URL вашей страницы с яблоками
    }
    
    /**
     * Удаление яблка.
     * @param int $id идентификатор яблока
     * @return \yii\web\Response
     */
    public function actionDeleteApple($id)
    {
        $apple = Apple::findOne($id);
        
        if ($apple !== null) {
            $apple->delete();
        }
        
        return $this->redirect(['site/index']); // Замените 'site/index' на URL вашей страницы с яблоками
    }
    
    /**
     * Падение яблка на землю.
     * @param int $id идентификатор яблока
     * @return \yii\web\Response
     */
    public function actionFallApple($id)
    {
        $apple = Apple::findOne($id);
        
        if ($apple !== null) {
            $apple->fallToGround();
        }
        
        return $this->redirect(['site/index']); // Замените 'site/index' на URL вашей страницы с яблоками
    }
    
    /**
     * Съедение яблка.
     * @param int $id идентификатор яблока
     * @param int $percent процент откушенной части
     * @return \yii\web\Response
     */
    public function actionEatApple($id)
    {
        $request = Yii::$app->request;
        $percent = $request->bodyParams['percent'];
    
        $apple = Apple::findOne($id);
    
        if ($apple !== null) {
            $apple->eat($percent);
        }
    
        return $this->redirect(['site/index']); // Замените 'site/index' на URL вашей страницы с яблоками
    }
}
