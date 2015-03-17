<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $cd_usuario
 * @property string $ds_nome
 * @property string $ds_email
 * @property string $ds_senha
 * @property string $id_facebook
 * @property string $authKey
 * @property string $accessToken
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ds_nome', 'ds_email'], 'required'],
            [['ds_nome', 'ds_email', 'ds_senha', 'authKey', 'accessToken'], 'string', 'max' => 255],
            [['id_facebook'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cd_usuario' => 'Cd Usuario',
            'ds_nome' => 'Ds Nome',
            'ds_email' => 'Ds Email',
            'ds_senha' => 'Ds Senha',
            'id_facebook' => 'Id Facebook',
        ];
    }
    
    public function createUser($attributes)
    {
        $this->ds_nome = $attributes['name'];
        $this->ds_email = $attributes['email'];
        $this->id_facebook = $attributes['id'];
        $this->authKey = sha1($attributes['id']);
        $this->accessToken = md5($attributes['id']);
        #$usuario->ds_senha = md5($usuario->id_facebook);
        $this->save();
    }
    
    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $usuario = static::findOne(['ds_email' => $username]);
        
//        $user = [
//            $usuario->cd_usuario.'' => [
//                                'id' => $usuario->cd_usuario.'',
//                                'username' => $usuario->ds_email,
//                                'password' => $usuario->id_facebook,
//                                'authKey' => $usuario->authKey,
//                                'accessToken' => $usuario->accessToken,
//            ],
//        ];
        
        $user = [
            'cd_usuario' => $usuario->cd_usuario.'',
            'ds_email' => $usuario->ds_email,
            'id_facebook' => $usuario->id_facebook,
            'authKey' => $usuario->authKey,
            'accessToken' => $usuario->accessToken,            
        ];
        
        return new static($user);
        #return $user;
        
//        foreach (self::$users as $user) {
//            if (strcasecmp($user['username'], $username) === 0) {
//                return new static($user);
//            }
//        }
//
//        return null;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->cd_usuario;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }
    
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
