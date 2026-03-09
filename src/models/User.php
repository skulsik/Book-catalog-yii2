<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string|null $auth_key
 *
 * @method static User|null findOne($condition)
 * @method static \yii\db\ActiveQuery find()
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public function rules(): array
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    public static function findByUsername($username): ?self
    {
        return static::find()
            ->where(['username' => $username])
            ->one();
    }

    public function validatePassword($password): bool
    {
        return password_verify($password, $this->password_hash);
    }
}
