<?php 

class User
{
	
	private $id;
	private $login;
	private $password;
	private $role;
	private $last_login;
	private $created;

	public function __construct(array $data)
	{
		foreach ($data as $key => $value) {
			$setterPieces = explode('_', $key);
			$setterName = 'set';
			foreach ($setterPieces as $setterPiece) {
				ucwords($setterPiece);
				$setterName .= $setterPiece;
			}
			if (method_exists($this, $setterName)) {
				$this->$setterName($value);
			}
		}
	}

    //GETTERS

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    //SETTERS

    /**
     * @param mixed $login
     *
     * @return self
     */
    public function setLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param mixed $role
     *
     * @return self
     */
    public function setRole(string $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @param mixed $last_login
     *
     * @return self
     */
    public function setLastLogin(string $last_login)
    {
        $this->last_login = $last_login;

        return $this;
    }

    /**
     * @param mixed $created
     *
     * @return self
     */
    public function setCreated(string $created)
    {
        $this->created = $created;

        return $this;
    }
}

?>