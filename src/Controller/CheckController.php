<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CheckController extends AbstractController
{

    public function check(){
        return new Response('', 200);
    }

}