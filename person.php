<?php
class Person {
    public $id;
    public $firstname;
    public $lastname;
    public $birthday;
    public $profession;
    public $movies;
    public $roles;

    public function Person() {
        $this->id = NULL;
        $this->firstname = NULL;
        $this->lastname = NULL;
        $this->birthday = NULL;
        $this->profession = NULL;
        $this->movies = array();
        $this->roles = array();
    }
}