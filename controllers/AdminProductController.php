<?php

namespace app\controllers;

use app\engine\Request;
use app\engine\Session;
use app\interfaces\IRenderer;
use app\models\entities\Products;
use app\models\repositories\ProductRepository;
use app\models\repositories\UserRepository;
use app\services\FileService;
use phpDocumentor\Reflection\File;


class AdminProductController extends Controller
{
    public function actionEdit() {

        $session = new Session();
        $login = $session->get('login');
        if(empty($login) || (new UserRepository())->isAdmin($login) == false){
            echo "You can't edit product";die;
        }

        try{
            $id = (new Request())->getParams()['id'];
            $product = new Products();
            if(!empty($id)) {
                $product = (new ProductRepository())->getOne($id);
            }
        } catch (\Exception $e){
            echo 'Trouble in actionEdit' . PHP_EOL;
            echo $e->getMessage();die;
        }

        echo $this->render('product/edit', [
            'product' => $product
        ]);
    }

    public function actionAdd(){

        $session = new Session();
        $login = $session->get('login');
        if(empty($login) || (new UserRepository())->isAdmin($login) == false){
            echo "You can't add product";die;
        }

        try {
            $product = new Products();

            if (!empty($_FILES) &&
                (new FileService())->allowedFilesType([$_FILES['image']['type']]) &&
                (new FileService())->allowedFilesSize([$_FILES['image']['size']])) {
                if(move_uploaded_file($_FILES['image']['tmp_name'], './img/' . $_FILES['image']['name'])){
                    $request = (new Request())->getParams();
                    $product->name = $request['name'];
                    $product->description = $request['description'];
                    $product->price = $request['price'];
                    $product->image = $_FILES['image']['name'];
                    (new ProductRepository())->save($product);
                } else {
                    echo 'Product image not uploaded'; die;
                }
            }

            echo $this->render('product/card', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            echo 'Trouble in actionAdd ' . $e->getMessage();die;
        }

    }

    public function actionUpdate(){

        $session = new Session();
        $login = $session->get('login');
        if(empty($login) || (new UserRepository())->isAdmin($login) == false){
            echo "You can't update product";die;
        }

        try {
            $id = (new Request())->getParams()['id'];
            $product = (new ProductRepository())->getOne($id);
            $request = (new Request())->getParams();

            if (!empty($_FILES) &&
                (new FileService())->allowedFilesType([$_FILES['image']['type']]) &&
                (new FileService())->allowedFilesSize([$_FILES['image']['size']])) {
                if(move_uploaded_file($_FILES['image']['tmp_name'], './img/' . $_FILES['image']['name'])){
                    $product->image = $_FILES['image']['name'];
                } else {
                    echo 'Product image not uploaded'; die;
                }
            }

            $product->name = $request['name'];
            $product->description = $request['description'];
            $product->price = $request['price'];

            (new ProductRepository())->update($product);

            echo $this->render('product/card', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            echo 'Trouble in actionUpdate ' . $e->getMessage();die;
        }

    }


    public function actionDelete(){

        $session = new Session();
        $login = $session->get('login');
        if(empty($login) || (new UserRepository())->isAdmin($login) == false){
            echo "You can't delete product";die;
        }

        try {
            $id = (new Request())->getParams()['id'];
            $product = (new ProductRepository())->getOne($id);
            (new ProductRepository())->delete($product);

            $page = (new Request())->getParams()['page'] ?? 0;
            $catalog = (new ProductRepository())->getLimit(($page + 1) * 2);

            echo $this->render('product/catalog', [
                'catalog' => $catalog,
                'page' => ++$page
            ]);
        } catch (\Exception $e){
            echo 'Trouble in actionDelete ' . $e->getMessage();die;
        }
    }
}