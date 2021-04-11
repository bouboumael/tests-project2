<?php

namespace App\Service\library;

class Formulary
{
    private array $errors = [];
    private array $form;
    private array $required;

    public function __construct(array $form, array $required)
    {
        $this->form = $form;
        $this->required = $required;
    }

    public function validateForm(): array
    {
        $startMessage = 'Le champ ';
        foreach ($this->form as $inputName => $inputValue) {
            $startMessage .= $inputName . ' ';
            $this->isInputExist($startMessage, $inputName);
            $this->isEmpty($startMessage, $inputName);
            $this->limit($startMessage, $inputName, $inputValue);

            return $this->errors;
        }

        return $this->errors;
    }

    private function limit(string $startMessage, string $inputName, $inputValue): void
    {
        if (isset($this->required[$inputName]['limit'])) {
            $limit = $this->required[$inputName]['limit'];
            $value = $this->countStringOrInteger($inputValue);
            if (isset($limit['min'])) {
                $min = $limit['min'];
                if ($value < $min) {
                    $startMessage .= 'doit avoir plus de ' . $min;
                    $startMessage .= is_string($inputValue) ? ' caractères' : '';
                    $this->errors[] = $startMessage;
                }
            }
            if (isset($limit['max'])) {
                $max = $limit['max'];
                if ($value > $max) {
                    $startMessage .= 'doit avoir moins de ' . $max;
                    $startMessage .= is_string($inputValue) ? ' caractères' : '';
                    $this->errors[] = $startMessage;
                }
            }
        }
    }

    private function countStringOrInteger($inputValue): int
    {
        return is_string($inputValue) ? strlen($inputValue) : $inputValue;
    }

    private function isInputExist(string $startMessage, string $inputName): void
    {
        if (!array_key_exists($inputName, $this->required)) {
            $this->errors[] = $startMessage . 'n\'existe pas';
        }
    }

    private function isEmpty(string $startMessage, string $inputName): void
    {
        if (empty($this->form[$inputName])) {
            $this->errors[] = $startMessage . 'ne doit pas être vide';
        }
    }
}
