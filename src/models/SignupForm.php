<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public string $username = '';
    public string $password = '';

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'string', 'min' => 3],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user['username'] = $this->username;
        $user['password_hash'] = password_hash($this->password, PASSWORD_BCRYPT);
        $user['auth_key'] = bin2hex(random_bytes(16));
        $user['created_at'] = time();
        $user['updated_at'] = time();

        return $user->save() ? $user : null;
    }
}