<?php

namespace app\controllers;

use app\engine\Request;
use app\models\repositories\ProductRepository;


class ProductController extends Controller
{

    public function actionIndex() {
        echo $this->render('index');
    }

    public function actionCatalog() {

        try{
            $page = (new Request())->getParams()['page'] ?? 0;
            // $catalog = Products::getAll();
            $catalog = (new ProductRepository())->getLimit(($page + 1) * 2); //2 4 6 8
        } catch (\Exception $e){
            echo 'Trouble in actionCatalog' . PHP_EOL;
            echo $e->getMessage();die;
        }

       // $user = Users::getWhere('login', 'admin');
        echo $this->render('product/catalog', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard() {

        try{
            $id = (new Request())->getParams()['id'];
            $product = (new ProductRepository())->getOne($id);
        } catch (\Exception $e){
            echo 'Trouble in actionCard' . PHP_EOL;
            echo $e->getMessage();die;
        }

        echo $this->render('product/card', [
            'product' => $product
        ]);
    }



}