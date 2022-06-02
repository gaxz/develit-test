<?php

namespace backend\controllers;

use backend\models\Product;
use backend\models\ProductCard;
use backend\models\ProductForm;
use backend\models\ProductImage;
use backend\models\ProductSearch;
use backend\models\UploadedImageForm;
use yii\base\Exception;
use yii\db\Transaction;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws \Throwable
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $product = new Product();
        $productCard = new ProductCard();
        $productImage = new ProductImage();

        if ($this->request->isPost) {

            if ($product->validate() && $productCard->validate()) {
                $this->writeProductData($product, $productCard, $productImage);

                return $this->redirect(['view', 'id' => $product->id]);
            }
        } else {
            $product->loadDefaultValues();
        }

        return $this->render('create', [
            'product' => $product,
            'productCard' => $productCard,
            'productImage' => $productImage,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $productImage = $product->productImage;
        $productCard = $product->productCard;

        if ($this->request->isPost) {

            if ($product->validate() && $productCard->validate()) {
                $this->writeProductData($product, $productCard, $productImage);

                return $this->redirect(['view', 'id' => $product->id]);
            }
        }

        return $this->render('update', [
            'product' => $product,
            'productCard' => $productCard,
            'productImage' => $productImage,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Create/update product table stack transaction
     */
    protected function writeProductData(Product $product, ProductCard $productCard, ProductImage $productImage)
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if (!$product->load($this->request->post(), 'Product') || !$product->save()) {
                throw new Exception('Unable to create Product');
            }

            $productCard->product_id = $product->id;
            $productImage->product_id = $product->id;

            if (!$productCard->load($this->request->post(), 'ProductCard') || !$productCard->save()) {
                throw new Exception('Unable to create ProductCard');
            }

            if (!empty(UploadedFile::getInstance($productImage, 'path'))) {
                $uploadedImage = new UploadedImageForm(
                    UploadedFile::getInstance($productImage, 'path'),
                    $productImage->getImagePath()
                );

                if (!$uploadedImage->validate()) {
                    throw new Exception('Image is not valid');
                }

                if (!$uploadedImage->upload()) {
                    throw new Exception('Unable to save image');
                }

                $productImage->path = $uploadedImage->getImageFilePath();
            }

            if (!$productImage->save()) {
                throw new Exception('Unable to save ProductImage');
            }

            $transaction->commit();
        } catch (\Throwable $e) {

            $transaction->rollBack();
            throw $e;
        }
    }
}
