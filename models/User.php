<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {

    public static function tableName() {
        return 'user';
    }

    public function rules() {
        return [
            [['username', 'password_hash'], 'required'],
            [['username', 'email', 'hoscode', 'role', 'allow', 'countlogin', 'lastlogin'], 'string'],
            ['username', 'unique']
        ];
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    public function getId() {
        return $this->id;
    }

    public function getRole() {
        return $this->role;
    }

    public function getAllow() {
        return $this->allow;
    }

    public function getHoscode() {
        return $this->hoscode;
    }
     public function getHosname() {
        return $this->hosname;
    }

    public function getCountlogin() {
        return $this->countlogin;
    }

    public function getLastlogin() {
        return $this->lastlogin;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return $this->password_hash == $password;
        //return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function updateLastLogin() {
        $this->countlogin = (int) $this->countlogin + 1;
        $this->lastlogin = date('Y-m-d H:i:s'); // Set current date and time
        return $this->save(false); // Save without validation
    }

}
