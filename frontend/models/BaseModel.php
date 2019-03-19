<?php

namespace frontend\models;

use backend\models\User;
use Yii;

class BaseModel
{
	/**
	 * @param $title
	 * @param $body
	 * @return string
	 * @desc 获取modal提示框html
	 */
	public static function getModal($title, $body){
		$html = '<div class="modal-header">';
		$html 	.= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">';
		$html 	.= '&times;';
		$html 	.= '</button>';
		$html 	.= '<h5 class="modal-title" id="myModalLabel">';
		$html 		.= $title;
		$html 	.= '</h5>';
		$html .= '</div>';
		$html .= '<div class="modal-body">';
		$html 	.= $body;
		$html .= '</div>';
		$html .= '<div class="modal-footer">';
		$html 	.= '<button type="button" class="btn btn-default" data-dismiss="modal">';
		$html 		.= '取消';
		$html 	.= '</button>';
		$html 	.= '<button type="button" id="do-something" class="btn btn-primary">';
		$html 		.= '确定';
		$html 	.= '</button>';
		$html .= '</div>';
		return $html;
	}

	/**
	 * @return bool
	 * @desc 获取用户是否绑定邮箱
	 */
	public static function isBindEmail(){
		if (\Yii::$app->user->isGuest) return true;

		$userId = Yii::$app->user->identity->getId();
		$user   = User::findOne(['id' => $userId]);

		return empty($user) ? false : (
			$user['email'] ? true : false
		);
	}
}
