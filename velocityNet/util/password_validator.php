<?php
// Password validation helper.
// Used to keep password rules consistent across pages.

class PasswordValidator {

    // Return a list of validation messages. Empty list means the password is valid.
    public static function getMessages($passwordText) {
        $messages = [];
        $passwordText = (string)$passwordText;

        // Minimum length 8, at least 1 uppercase, 1 lowercase, 1 special character.
        if (strlen($passwordText) < 8) {
            $messages[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $passwordText)) {
            $messages[] = "Password must contain at least 1 uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $passwordText)) {
            $messages[] = "Password must contain at least 1 lowercase letter.";
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $passwordText)) {
            $messages[] = "Password must contain at least 1 special character.";
        }

        return $messages;
    }

    // Convenience helper when the UI only displays one message.
    public static function getFirstMessage($passwordText) {
        $messages = self::getMessages($passwordText);
        return (count($messages) > 0) ? $messages[0] : "";
    }
}
