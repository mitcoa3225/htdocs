<?php
namespace Models;

class User {
    private int $userNo = 0;
    private string $userId = '';
    private string $password = '';
    private string $firstName = '';
    private string $lastName = '';
    private string $hireDate = '';
    private string $email = '';
    private int $extension = 0;
    private int $userLevelNo = 0;

    public function __construct(
        int $userNo,
        string $userId,
        string $password,
        string $firstName,
        string $lastName,
        string $hireDate,
        string $email,
        int $extension,
        int $userLevelNo
    ) {
        $this->userNo = $userNo;
        $this->userId = $userId;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->hireDate = $hireDate;
        $this->email = $email;
        $this->extension = $extension;
        $this->userLevelNo = $userLevelNo;
    }

    public function getUserNo(): int { return $this->userNo; }
    public function getUserId(): string { return $this->userId; }
    public function getPassword(): string { return $this->password; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getHireDate(): string { return $this->hireDate; }
    public function getEmail(): string { return $this->email; }
    public function getExtension(): int { return $this->extension; }
    public function getUserLevelNo(): int { return $this->userLevelNo; }
}
