<?php

class LandingController extends AdminController
{

    public function actionIndex() {

        $this->pageTitle = 'Просмотр посадочных страниц';

        $models = FranchiseLanding::model()->findAll();

        $this->render('index', array('models' => $models));
    }

    public function actionCreate() {

        $this->pageTitle = 'Добавление посадочной страницы';

        $model = new FranchiseLanding();

        if(isset($_POST['FranchiseLanding'])) {

            $model->attributes = $_POST['FranchiseLanding'];
            $model->franchise_landing_user_id = $this->user->id;

            if($model->save()) {

                $this->redirect('/admin/landing/index');
            }
        }

        $this->render('form', array('model' => $model));
    }

    public function actionUpdate($id) {

        $this->pageTitle = 'Изменение посадочной страницы';

        $model = $this->loadModel($id);

        if(isset($_POST['FranchiseLanding'])) {

            $model->attributes = $_POST['FranchiseLanding'];

            if($model->save()) {
                $this->redirect('/admin/landing/index');
            }
        }

        $this->render('form', array('model' => $model));
    }

    public function actionDelete($id) {

        $model = $this->loadModel($id);

        if($model->delete()) {

            $this->redirect('/admin/landing/index');
        }
    }

    public function loadModel($id) {

        $model = new FranchiseLanding();

        $model = $model->findByPk($id);

        if(empty($model)) throw new CHttpException(404, 'страница не найдена');

        return $model;
    }

    /* ДОБАВЛЕНИЕ ФУНКЦИОНАЛА ДЛЯ ГОРОДОВ */

    public function loadModelCity($id) {

        $model = City::model()->findByPk($id);

        if(empty($model)) throw new CHttpException(404, 'страница не найдена');

        return $model;
    }
    
    public function actionCityIndex() {

        $this->setPageTitle('Управление городами');

        $models = City::model()->findAll();
        
        $this->render('city/index', array('models' => $models));
    }
    
    public function actionCityCreate() {

        $this->setPageTitle('Добавление города');
        
        $model = new City;

        if(isset($_POST['City'])) {
            $model->attributes = $_POST['City'];
            if($model->save()) {
                $this->redirect('/admin/landing/cityindex');
            }
        }

        $this->render('city/form', array('model' => $model));
    }

    public function actionCityUpdate($id) {
        
        $this->setPageTitle('Изменение города');

        $model = $this->loadModelCity($id);

        if(isset($_POST['City'])) {

            $model->attributes = $_POST['City'];
            if($model->save()) {

                $this->redirect('/admin/landing/cityindex');
            }
        }

        $this->render('city/form', array('model' => $model));
    }
    
    public function actionCityDelete($id) {

        $model = $this->loadModelCity($id);

        if(!$model->delete()) {
            throw new CHttpException(403,'ошибка удаления');
        }

        $this->redirect($this->createUrl('cityindex'));
    }
}
