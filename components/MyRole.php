<?php

namespace app\components;

use yii\base\Component;

class MyRole extends Component {

    public static function getUserId() {
        return \Yii::$app->user->id;
    }

    public static function getUserHosCode() {
        $user_hoscode = empty(\Yii::$app->user->identity->hoscode) ? '00000' : \Yii::$app->user->identity->hoscode;

        return $user_hoscode;
    }

    public static function isHoscodeMatch($patient_hoscode) {
        $user_hoscode = empty(\Yii::$app->user->identity->hoscode) ? '' : \Yii::$app->user->identity->hoscode;

        return $patient_hoscode == $user_hoscode;
    }

    public static function getRole() {
        $role = empty(\Yii::$app->user->identity->role) ? '' : \Yii::$app->user->identity->role;
        return $role;
    }

    public static function is_pro() {
        $allow_group = ['pro'];

        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function can_pro() {
        $allow_group = ['pro'];

        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function is_amp() {
        $allow_group = ['amp'];

        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function is_hos() {
        $allow_group = ['hos'];

        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function can_report() {
        $allow_group = ['hos'];

        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function can_accept() {
        $allow_group = ['hos', 'pcu'];

        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function can_all_update() {
        $allow_group = ['pro'];
        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function can_all_delete() {
        $allow_group = ['pro'];
        $user_group = substr(self::getRole(), 0, 3);
        if (in_array($user_group, $allow_group)) {
            return TRUE;
        }
        return FALSE;
    }

}
