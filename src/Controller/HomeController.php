<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Service\library\Formulary;

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
        $test = (new Formulary())->validateForm([
            'name' => [],
            'email' => [],
            'adress' => []
        ], [
            'name' => 'test'
        ]);
        var_dump($test);
        return $this->twig->render('Home/index.html.twig');
    }
}
