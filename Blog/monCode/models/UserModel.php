<?php

class UserModel extends CoreModel
{

    /**
     * Get users with possibility to specify the role
     * @param  string|null $role [description]
     * @return [type]            [description]
     */
    public function getUsers(string $role=NULL)
    {
        $sql = '
                SELECT * FROM `user`
                '; 

        if (!is_null($role))
            $sql .= 'WHERE use_role LIKE :role';

        $param = (!is_null($role)) ? ['role' => '%'.$role.'%'] : [];

        return $this->MakeSelect($sql, $param);
    }

    public function getUserByName(array $data)
    {
        $sql = '
                SELECT * FROM `user`
                WHERE (user.use_login = :user_login);
                ';

        $param = [
            'user_login' => $data['login']
        ];

        return ($user = $this->MakeSelect($sql, $param)[0]) ? $user : false;
    }

    public function createUser(User $user)
    {
    	$sql = '
				INSERT INTO user 
				(`use_login`, `use_password`, `use_role`, `use_last_login`, `use_created`) 
				VALUES (:login, :password, :role, :last_login, :created);
    			';

    	$param = [
    		'login' =>$user->getLogin(),
    		'password' =>$user->getPassword(),
    		'role' =>$user->getRole(),
    		'last_login' =>$user->getLastLogin(),
    		'created' =>$user->getCreated()
    	];

    	return ($this->MakeStatement($sql, $param)) ? true : false;
    }

    public function updateUser(array $data)
    {
    	$sql = '
				UPDATE `user`
				SET use_login=:login, use_password=:password,
				use_role=:role, use_last_login=:last_login
				WHERE use_id=:id;
    			';

    	$param = [
    			'login' 		=> $data['use_login'],
				'password'	    => $data['use_password'],
				'role'			=> $data['use_role'],
				'last_login'	=> $data['use_last_login'],
				'id' 			=> $data['use_id']
    	];

    	return ($this->MakeStatement($sql, $param)) ? true : false;
    }

}

?>