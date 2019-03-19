<?php

namespace backend\models;

use Yii;

class BaseModel
{
	/**
	 * send email
	 * @pram $from
	 * @param $to
	 * @param $message
	 * @return boolean
	 **/
	public static function sendMail($from, $to, $message){
		return \Yii::$app->mailer->compose()
			->setFrom($from)
			->setTo($to)
			->setSubject($message)
			->send();
	}
}