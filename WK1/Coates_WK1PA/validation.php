<?php
namespace lastname_validator;

/**
 * Returns "Required Entry" if the field is required and empty, otherwise returns "".
 * (Parameter passed by value, returns a value)
 */
function required_entry(string $value, bool $isRequired = true): string
{
    $value = trim($value);

    if ($isRequired && $value === '') {
        return "Required Entry";
    }
    return "";
}

/**
 * Validate Name: "Lastname, Firstname"
 * - Required
 * - Must contain a comma
 * - Lastname >= 2 chars
 * - Firstname >= 1 char
 * Uses REGEX + control logic
 */
function validate_name(string $name): string
{
    $name = trim($name);

    // First handle required rule
    $requiredMsg = required_entry($name, true);
    if ($requiredMsg !== "") {
        return $requiredMsg;
    }

    // REGEX: at least 2 chars for last, comma, optional space, at least 1 char for first
    // Allows letters plus common punctuation in names.
    $pattern = "/^[A-Za-z][A-Za-z' -]{1,},\s*[A-Za-z][A-Za-z' -]{0,}$/";
    if (!preg_match($pattern, $name)) {
        // More specific checks (control logic)
        if (strpos($name, ',') === false) {
            return "Name must contain a comma (Lastname, Firstname).";
        }

        $parts = explode(',', $name, 2);
        $last = trim($parts[0] ?? '');
        $first = trim($parts[1] ?? '');

        if (strlen($last) < 2) {
            return "Lastname must be at least 2 characters.";
        } elseif (strlen($first) < 1) {
            return "Firstname must be at least 1 character.";
        }

        return "Name must be formatted as Lastname, Firstname.";
    }

    // Extra split validation (still meets requirements)
    $parts = explode(',', $name, 2);
    $last = trim($parts[0] ?? '');
    $first = trim($parts[1] ?? '');

    if (strlen($last) < 2) {
        return "Lastname must be at least 2 characters.";
    } elseif (strlen($first) < 1) {
        return "Firstname must be at least 1 character.";
    }

    return "";
}

/**
 * Validate Date of Birth: MM/DD/YYYY
 * - Required
 * - Proper format AND a real date
 * Uses REGEX + DateTime parsing
 */
function validate_dob(string $dob): string
{
    $dob = trim($dob);

    $requiredMsg = required_entry($dob, true);
    if ($requiredMsg !== "") {
        return $requiredMsg;
    }

    // REGEX format check
    if (!preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])\/\d{4}$/", $dob)) {
        return "Date of Birth must be formatted as MM/DD/YYYY.";
    }

    // Real date check
    $dt = \DateTime::createFromFormat('m/d/Y', $dob);
    $errors = \DateTime::getLastErrors();

    if ($dt === false || ($errors['warning_count'] ?? 0) > 0 || ($errors['error_count'] ?? 0) > 0) {
        return "Date of Birth must be a valid calendar date.";
    }

    return "";
}

/**
 * Validate Email Address
 * - Required
 * - Must be valid email format
 * Uses PHP built-in format validation (filter_var)
 */
function validate_email(string $email): string
{
    $email = trim($email);

    $requiredMsg = required_entry($email, true);
    if ($requiredMsg !== "") {
        return $requiredMsg;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Enter a valid email address (example: X@X.Y).";
    }

    return "";
}

/**
 * Throws an exception if the value is not an integer.
 * Uses Exceptions
 */
function must_be_integer(string $value): void
{
    $value = trim($value);

    // Accepts optional leading minus sign, then digits
    if (!preg_match("/^-?\d+$/", $value)) {
        throw new \Exception("Favorite Integer must be an integer value.");
    }
}

/**
 * Validate Favorite Integer
 * - Required
 * - Must be integer
 * Uses try/catch with must_be_integer (Exceptions)
 */
function validate_favorite_integer(string $favInt): string
{
    $favInt = trim($favInt);

    $requiredMsg = required_entry($favInt, true);
    if ($requiredMsg !== "") {
        return $requiredMsg;
    }

    try {
        must_be_integer($favInt);
    } catch (\Exception $e) {
        return $e->getMessage();
    }

    return "";
}

/**
 * Validate Nickname
 * - Not required
 * - If entered, must be at least 2 characters
 * Demonstrates parameter passed by reference (normalizes value)
 */
function validate_nickname(string $nickname, string &$normalizedNickname): string
{
    $normalizedNickname = trim($nickname);

    // Not required
    if ($normalizedNickname === '') {
        return "";
    }

    if (strlen($normalizedNickname) < 2) {
        return "Nickname must be at least 2 characters if entered.";
    }

    return "";
}
