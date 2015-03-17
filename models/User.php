<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $id_facebook;
    public $authKey;
    public $accessToken;

//    private static $users = [
//        '100' => [
//            'id' => '100',
//            'username' => 'phelipebf@gmail.com',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];
    
    static $users;    
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $usuario = Usuario::findOne(['ds_email' => $username]);
        
//        self::$users = [
//            $usuario->cd_usuario.'' => [
//                'id' => $usuario->cd_usuario.'',
//                'username' => $usuario->ds_email,
//                'password' => $usuario->id_facebook,
//                'authKey' => $usuario->authKey,
//                'accessToken' => $usuario->accessToken,
//            ],
//        ];
//        
//        $user = self::$users[$usuario->cd_usuario];
        
//        $user = [            
//            'id' => $usuario->cd_usuario.'',
//            'username' => $usuario->ds_email,
//            'password' => $usuario->id_facebook,
//            'authKey' => $usuario->authKey,
//            'accessToken' => $usuario->accessToken,            
//        ];
        
        self::$users = [
            '100' => [
                'id' => '100',
                'username' => 'phelipebf@gmail.com',
                'password' => 'admin',
                'authKey' => 'test100key',
                'accessToken' => '100-token',
            ]
        ];
        
        $user = self::$users[100];
        
//        echo '<pre>';
//        var_dump(self::$users); 
//        echo '</pre>';
//        die;
        
        return new static($user);
        
//        foreach (self::$users as $user) {
//            if (strcasecmp($user['username'], $username) === 0) {
//                return new static($user);
//            }
//        }
//
//        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
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
    
    public static function setUser($id)
    {
        $usuario = new Usuario;
        $user = $usuario->findOne([
            "id_facebook" => $id,
        ]);
                
//        self::$users = [
//            $user->cd_usuario => [
//                'id' => $user->cd_usuario,
//                'username' => $user->ds_email,
//                'password' => $user->ds_senha,
//                'id_facebook' => $user->id_facebook,
//                'authKey' => $user->authKey,
//                'accessToken' => $user->accessToken,
//            ],
//        ];
        
        self::$users = [
            '100' => [
                'id' => '100',
                'username' => 'phelipebf@gmail.com',
                'password' => 'admin',
                'authKey' => 'test100key',
                'accessToken' => '100-token',
            ],
            '101' => [
                'id' => '101',
                'username' => 'demo',
                'password' => 'demo',
                'authKey' => 'test101key',
                'accessToken' => '101-token',
            ],
        ];
    }
}
