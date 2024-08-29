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
class RegisterForm extends Model
{
    public function __construct(
        private UserRepositoryInterface $repository,
                                        $config = []
    )
    {
        parent::__construct($config);
    }

    public $phone;
    public $password = '';
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            [['phone',], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'phone'],
            ['password', 'string', 'min' => 8, 'max' => 255],
            ['phone', 'validatePhone'],
        ];
    }

    public function validatePhone($attribute, $params)
    {
        if (!PhoneHelper::check($this->phone)) {
            $this->addError($attribute, 'Incorrect phone.');
        }
    }

    public function register()
    {
        if ($this->validate()) {
            $user = $this->repository->add(new User([
                'phone' => PhoneHelper::normalize($this->phone),
                'password' => Yii::$app->security->generatePasswordHash($this->password),
            ]));

            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }
}
