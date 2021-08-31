<?php

namespace App\Classes;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class Basket
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add($id)
    {
        $basket = $this->session->get('basket', []);

        if(!empty($basket[$id])) {
            $basket[$id]++;
        } else {
            $basket[$id] = 1;
        }

        $this->session->set('basket', $basket);
    }

    public function get()
    {
        return $this->session->get('basket');
    }

    public function remove()
    {
        return $this->session->remove('basket');
    }
}