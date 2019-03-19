<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityPaperCouponController implements the CRUD actions for ActivityPaperCoupon model.
 */
class ApiController extends Controller
{
	public function actionGetToken(){
		echo substr(md5('lianghui'),0,16);
	}
}
