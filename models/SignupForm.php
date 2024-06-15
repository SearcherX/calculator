<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $firstName;
    public $email;
    public $password;
    public $repeatPassword;

    public function rules()
    {
        return [
            [['email' , 'firstName', 'password', 'repeatPassword'], 'required'],
            ['firstName', 'match', 'pattern' => '/^[a-zA-Z\s]+$/'],

            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            ['email', 'email'],

            ['password', 'match',
                'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z]).{8,14}$/',
                //(?=.*[a-z])(?=.*[A-Z])
                'message' => 'Пароль должен состоять из букв латинского алфавита (A-z), должна быть минимум 1 арабская цифра (0-9), длина пароля должна быть не менее 8 и не более 14 символов.'
            ],

            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],

        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->firstName = $this->firstName;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->generateAuthKey();
            $user->save();

            // нужно добавить следующие три строки:
            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());

            return $user;
        }

        return null;
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'E-mail',
            'firstName' => 'Имя',
            'password' => 'Пароль',
            'repeatPassword' => 'Повторите пароль',
        ];
    }
}