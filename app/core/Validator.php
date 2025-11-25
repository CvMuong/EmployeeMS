<?php
class Validator {
    private $errors = [];
    public function validateRequired($field, $value, $msg = null) {
        if (trim((string)$value) === '') $this->errors[$field] = $msg ?? "$field is required";
    }
    public function validateEmail($field, $value, $msg = null) {
        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) $this->errors[$field] = $msg ?? "Invalid email";
    }
    public function validateMaxLen($field, $value, $max, $msg = null) {
        if (mb_strlen((string)$value) > $max) $this->errors[$field] = $msg ?? "$field max $max chars";
    }
    public function validateNumeric($field, $value, $msg = null) {
        if ($value !== '' && !is_numeric($value)) $this->errors[$field] = $msg ?? "$field must be numeric";
    }
    public function addError($field, $msg) { $this->errors[$field] = $msg; }
    public function hasErrors() { return !empty($this->errors); }
    public function errors() { return $this->errors; }
}
