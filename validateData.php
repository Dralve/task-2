<?php
class Validator {
    private $errors = [];

    // Validate individual data fields
    public function validateData($title, $content, $author) {
        $this->errors = []; // Reset errors

        $this->validateField($title, 'Title');

        $this->validateField($content, 'Content');

        $this->validateField($author, 'Author');

        return [
            'isValid' => empty($this->errors),
            'errors' => $this->errors
        ];
    }

    // Check if field is empty
    private function validateField($value, $fieldName) {
        if (empty($value)) {
            $this->errors[] = "The $fieldName field cannot be empty.";
        }
    }
}
?>
