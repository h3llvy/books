<?php

namespace app\entities;

use app\repositories\contracts\UserRepositoryInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $phone
 * @property string $password
 * @property string|null $auth_key
 * @property string|null $access_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public static function findIdentity($id)
    {
        $repository = Yii::createObject(UserRepositoryInterface::class);
        return $repository->findById($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $repository = Yii::createObject(UserRepositoryInterface::class);
        return $repository->findByAccessToken($token, $type);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
