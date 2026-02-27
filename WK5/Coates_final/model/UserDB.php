<?php
namespace Models;

class UserDB {
    public static function getAllUsers(Database $db): array {
        $conn = $db->getDbConn();
        if ($conn === false) return [];

        $sql = 'SELECT UserNo, UserId, Password, FirstName, LastName, HireDate, EMail, Extension, UserLevelNo FROM users ORDER BY UserNo';
        $result = mysqli_query($conn, $sql);
        $users = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = new User(
                    intval($row['UserNo']),
                    strval($row['UserId']),
                    strval($row['Password']),
                    strval($row['FirstName']),
                    strval($row['LastName']),
                    strval($row['HireDate']),
                    strval($row['EMail']),
                    intval($row['Extension']),
                    intval($row['UserLevelNo'])
                );
            }
            mysqli_free_result($result);
        }
        return $users;
    }

    public static function getUserByNo(Database $db, int $userNo): ?User {
        $conn = $db->getDbConn();
        if ($conn === false) return null;

        $stmt = mysqli_prepare($conn, 'SELECT UserNo, UserId, Password, FirstName, LastName, HireDate, EMail, Extension, UserLevelNo FROM users WHERE UserNo = ?');
        if (!$stmt) return null;
        mysqli_stmt_bind_param($stmt, 'i', $userNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = null;
        if ($result && ($row = mysqli_fetch_assoc($result))) {
            $user = new User(
                intval($row['UserNo']),
                strval($row['UserId']),
                strval($row['Password']),
                strval($row['FirstName']),
                strval($row['LastName']),
                strval($row['HireDate']),
                strval($row['EMail']),
                intval($row['Extension']),
                intval($row['UserLevelNo'])
            );
        }
        mysqli_stmt_close($stmt);
        return $user;
    }

    public static function getUserByUserId(Database $db, string $userId): ?User {
        $conn = $db->getDbConn();
        if ($conn === false) return null;

        $stmt = mysqli_prepare($conn, 'SELECT UserNo, UserId, Password, FirstName, LastName, HireDate, EMail, Extension, UserLevelNo FROM users WHERE UserId = ?');
        if (!$stmt) return null;
        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = null;
        if ($result && ($row = mysqli_fetch_assoc($result))) {
            $user = new User(
                intval($row['UserNo']),
                strval($row['UserId']),
                strval($row['Password']),
                strval($row['FirstName']),
                strval($row['LastName']),
                strval($row['HireDate']),
                strval($row['EMail']),
                intval($row['Extension']),
                intval($row['UserLevelNo'])
            );
        }
        mysqli_stmt_close($stmt);
        return $user;
    }

    /**
     * Validate login credentials.
     * 
     * @return int|false Returns the UserLevelNo on success, or false on failure.
     */
    public static function validateLogin(Database $db, string $userId, string $password) {
        $user = self::getUserByUserId($db, $userId);
        if (!$user) return false;
        // SQL file uses plain text Password (varchar(20)).
        if ($user->getPassword() !== $password) return false;
        return intval($user->getUserLevelNo());
    }

    public static function addUser(Database $db, array $data): bool {
        $conn = $db->getDbConn();
        if ($conn === false) return false;

        $stmt = mysqli_prepare($conn, 'INSERT INTO users (UserId, Password, FirstName, LastName, HireDate, EMail, Extension, UserLevelNo) VALUES (?,?,?,?,?,?,?,?)');
        if (!$stmt) return false;

        $ext = intval($data['Extension']);
        $lvl = intval($data['UserLevelNo']);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssii',
            $data['UserId'],
            $data['Password'],
            $data['FirstName'],
            $data['LastName'],
            $data['HireDate'],
            $data['EMail'],
            $ext,
            $lvl
        );
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public static function updateUser(Database $db, int $userNo, array $data): bool {
        $conn = $db->getDbConn();
        if ($conn === false) return false;

        $stmt = mysqli_prepare($conn, 'UPDATE users SET UserId=?, Password=?, FirstName=?, LastName=?, HireDate=?, EMail=?, Extension=?, UserLevelNo=? WHERE UserNo=?');
        if (!$stmt) return false;

        $ext = intval($data['Extension']);
        $lvl = intval($data['UserLevelNo']);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssiii',
            $data['UserId'],
            $data['Password'],
            $data['FirstName'],
            $data['LastName'],
            $data['HireDate'],
            $data['EMail'],
            $ext,
            $lvl,
            $userNo
        );
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public static function deleteUser(Database $db, int $userNo): bool {
        $conn = $db->getDbConn();
        if ($conn === false) return false;

        $stmt = mysqli_prepare($conn, 'DELETE FROM users WHERE UserNo=?');
        if (!$stmt) return false;
        mysqli_stmt_bind_param($stmt, 'i', $userNo);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }
}
