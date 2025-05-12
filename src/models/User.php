<?php

class User
{
    private string $id;
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;

    public function __construct(
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getlastName(): string
    {
        return $this->lastName;
    }

    public function setlastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
