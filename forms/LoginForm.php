<?php

namespace app\forms;

use app\entities\User;
use app\helpers\PhoneHelper;
use app\repositories\contracts\UserRepositoryInterface;
use Yii;
use yii\base\Model;

/**
 * @property-read User|null $user
 */
class LoginForm extends Model
{
    public $phone;
    public $password = '';
    public $rememberMe = true;

    private $_user = false;

    public function __construct(
                                        $config,
                                        private UserRepositoryInterface $repository,
    )
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Incorrect phone or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }


    public function getUser(): ?User
    {
        if ($this->_user === false) {
            $this->_user = $this->repository->findByPhone(PhoneHelper::normalize($this->phone));
        }

        return $this->_user;
    }
}
