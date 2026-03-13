<?php


namespace ProjetA2Phoenix2026;

/** Class Validator **/
class Validator {

    private $data;
    private $errors = [];
    private $messages = [
        "required" => "Le champ est requis !",
        "min" => "Le champ doit contenir un minimum de %^% lettres !",
        "max" => "Le champ doit contenir un maximum de %^% lettres !",
        "regex" => "Le format n'est pas respecté",
        "length" => "Le champ doit contenir %^% caractère(s) !",
        "url" => "Le champ doit correspondre à une url !",
        "email" => "Le champ doit correspondre à une email: exemple@gmail.com !",
        "date" => "Le champ doit être une date !",
        "alpha" => "Le champ peut contenir que des lettres minuscules et majuscules !",
        "alphaNum" => "Le champ peut contenir que des lettres minuscules, majuscules et des chiffres !",
        "alphaNumDash" => "Le champ peut contenir que des lettres minuscules, majuscules, des chiffres, des slash et des tirets !",
        "numeric" => "Le champ peut contenir que des chiffres !",
        "confirm" => "Le champs n'est pas conforme au confirm !"
    ];
    private $rules = [
        "required" => "#^.+$#",
        "min" => "#^.{ù,}$#",
        "max" => "#^.{0,ù}$#",
        "length" => "#^.{ù}$#",
        "regex" => "ù",
        "url" => FILTER_VALIDATE_URL,
        "email" => FILTER_VALIDATE_EMAIL,
        "date" => "#^(\d{4})(\/|-)(0[0-9]|1[0-2])(\/|-)([0-2][0-9]|3[0-1])$#",
        "alpha" => "#^[A-z]+$#",
        "alphaNum" => "#^[A-z0-9]+$#",
        "alphaNumDash" => "#^[A-z0-9-\|]+$#",
        "numeric" => "#^[0-9]+$#",
        "confirm" => ""
    ];

    public function __construct($data = []) {
        $this->data = $data ?: $_POST;
    }

    public function validate($array) {
        foreach ($array as $field => $rules) {
            $this->validateField($field, $rules);
        }
    }

    public function validateField($field, $rules) {
        foreach ($rules as $rule) {
            $this->validateRule($field, $rule);
        }
    }

    public function validateRule($field, $rule) {
        // ensure value is always a string to avoid preg_match warnings
        $value = isset($this->data[$field]) ? (string)$this->data[$field] : '';

        // rule with parameter (ex: min:3)
        $pos = strrpos($rule, ":");
        if ($pos !== false) {
            $parts = explode(":", $rule, 2);
            $key = $parts[0];
            $param = $parts[1];

            if (!isset($this->rules[$key])) {
                return;
            }

            $pattern = str_replace("ù", $param, $this->rules[$key]);
            $message = str_replace("%^%", $param, $this->messages[$key] ?? "Erreur de validation");

            // only run preg_match if pattern looks like a regex string
            if (is_string($pattern) && @preg_match($pattern, '') !== false) {
                if (!preg_match($pattern, $value)) {
                    $this->errors[] = $message;
                    $this->storeSession($field, $message);
                }
            } else {
                // fallback: treat as invalid if empty
                if ($value === '') {
                    $this->errors[] = $message;
                    $this->storeSession($field, $message);
                }
            }

            return;
        }

        // confirm rule: support both passwordConfirm and password_confirm naming
        if ($rule === "confirm") {
            $candidates = [
                $field . 'Confirm',
                $field . '_confirm',
                $field . 'confirm'
            ];
            $found = null;
            foreach ($candidates as $k) {
                if (array_key_exists($k, $this->data)) {
                    $found = $k;
                    break;
                }
            }

            if ($found === null) {
                $msg = "Nous avons un problème";
                $this->errors[] = $msg;
                $this->storeSession('confirm', $msg);
            } elseif ((string)$this->data[$field] !== (string)$this->data[$found]) {
                $msg = $this->messages[$rule];
                $this->errors[] = $msg;
                $this->storeSession('confirm', $msg);
            }
            return;
        }

        // email / url (filter-based)
        if ($rule === "email" || $rule === "url") {
            $filter = $this->rules[$rule];
            if (!filter_var($value, $filter)) {
                $msg = $this->messages[$rule];
                $this->errors[] = $msg;
                $this->storeSession($field, $msg);
            }
            return;
        }

        // other regex rules
        if (!isset($this->rules[$rule])) {
            return;
        }

        $pattern = $this->rules[$rule];
        // guard against invalid pattern or null subject
        if (is_string($pattern) && @preg_match($pattern, '') !== false) {
            if (!preg_match($pattern, $value)) {
                $msg = $this->messages[$rule] ?? 'Erreur de validation';
                $this->errors[] = $msg;
                $this->storeSession($field, $msg);
            }
        } else {
            // fallback: check non-empty for required-like rules
            if ($pattern === FILTER_VALIDATE_URL || $pattern === FILTER_VALIDATE_EMAIL) {
                // already handled above
            } elseif ($value === '') {
                $msg = $this->messages[$rule] ?? 'Erreur de validation';
                $this->errors[] = $msg;
                $this->storeSession($field, $msg);
            }
        }
    }

    public function errors() {
        return $this->errors;
    }

    public function storeSession($field, $error) {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        if (!isset($_SESSION["error"])) {
            $_SESSION["error"] = [];
        }
        if (!isset($_SESSION["error"][$field])) {
            $_SESSION["error"][$field] = $error;
        }
    }
}