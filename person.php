<?php
/**
 * Person class.
 */
class Person {
    /** @var integer $id Person ID. */
    public $id;
    /** @var string $firstname First name of the person. */
    public $firstname;
    /** @var string $lastname Last name of the person. */
    public $lastname;
    /** @var string $birthday Birthday of the person in 'YYYY-MM-DD' format. */
    public $birthday;
    /** @var string $profession Profession of the person. */
    public $profession;
    /** @var integer[] $movies IDs of the movies the person is associated with. */
    public $movies;
    /** @var integer[] $roles IDs of the roles the person has had. */
    public $roles;

    /**
     * Default constructor.
     */
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
