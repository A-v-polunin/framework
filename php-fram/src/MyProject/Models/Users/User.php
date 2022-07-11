<?php
    namespace MyProject\Models\Users;
    use MyProject\Models\ActiveRecordEntity;

    class User extends ActiveRecordEntity {
        protected $nickname;

        protected $email;
        protected $role;
        protected $isConfirmed;
        protected $password_hash;
        protected $auth_token;
        protected $created_at;


        public function getNickName() {
            return $this->nickname;
        }


        public static function getTableName():string{
            return 'users';
        }
    }


?>