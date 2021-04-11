<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Service\library\THP\Formulary;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $form = [
            'name' => 'Maël',
            'email' => 'bouboumael@wanadoo.fr',
        ];
        $formData = [];
        $errors = (new Formulary($form, [
            'name' => [
                'limit' => [
                    'max' => 100
                ],
                'type' => 'string'
            ],
            'email' => ['filter_var' => FILTER_VALIDATE_EMAIL],
            'adress' => []
        ]))->validateForm();

        if (empty($errors)) {
            $formData = array_map('trim', $form);
        }

        return $this->twig->render('Home/index.html.twig', [
            'errors' => $errors,
            'formData' => $formData
        ]);
    }
}
