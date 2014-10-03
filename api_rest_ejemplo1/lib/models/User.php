<?php
class User extends \Phalcon\Mvc\Model{
    protected $id;
    protected $name;
    protected $email;
    
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;
    }


    public function getId()    {
        return $this->id;
    }

    public function getName()    {
        return $this->name;
    }

    public function getEmail()    {
        return $this->email;
    }
    public function validationOld(){
        $this->validate(
            new Email(
                array(
                    "field"    => "email",
                    "required" => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

    public static function find($parameters = array()){
        return parent::find($parameters);
    }


    public static function findFirst($parameters = array()){
        return parent::findFirst($parameters);
    }

    public function columnMap() {
        return array(
            'id' => 'id', 
            'name' => 'name', 
            'email' => 'email'
        );
    }

}
