<?php

namespace App\Service\library;

class Formulary
{
    private array $errors = [];

    /**
     * function for control formulary before send to database
     *
     * @param array $required (array with all controls)
     * @param array $form (form to test)
     * @return array (responses of tests)
     */
    public function validateForm(array $required, array $form): array
    {
        $startMessage = 'Le champ ';
        foreach ($form as $formInput => $inputValue) {
            $startMessage .= $formInput . ' ';
            if (!array_key_exists($formInput, $required)) {
                $this->errors[] = $startMessage . 'n\'existe pas';
            }
            if (empty($form[$formInput])) {
                $this->errors[] = $startMessage . 'ne doit pas être vide';
            }
            if (isset($required[$formInput]['limit'])) {
                $this->limit($required[$formInput]['limit'], [
                    'startMessage' => $startMessage,
                    'inputValue' => $inputValue,
                ]);
            }
        }

        return $this->errors;
    }

    /**
     * fuction for test limit min or max value
     *
     * @param array $limit
     * @param array $testValues
     * @return void
     */
    private function limit(array $limit, array $testValues): void
    {
        $value = $this->countStringOrInteger($testValues);
        $message = $testValues['startMessage'];
        if (isset($limit['min'])) {
            $min = $limit['min'];
            if ($value < $min) {
                $message .= $message . 'doit avoir plus de ';
                $this->errors[] = $message . $min . is_string($testValues['inputValue']) ? 'caractères' : '';
            }
        }
        if (isset($limit['max'])) {
            $max = $limit['max'];
            if ($value > $max) {
                $message .= $message . 'doit avoir moins de ';
                $this->errors[] = $message . $max . is_string($testValues['inputValue']) ? 'caractères' : '';
            }
        }
    }

    private function countStringOrInteger(array $input): int
    {
        return is_string($input['inputValue']) ? strlen($input['inputValue']) : $input['inputValue'];
    }
}
