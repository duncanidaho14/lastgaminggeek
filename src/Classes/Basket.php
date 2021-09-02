<?php

namespace App\Classes;

use App\Entity\Jeuxvideo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Basket
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
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

    public function delete($id)
    {
        $basket = $this->session->get('basket', []);

        unset($basket[$id]);

        return $this->session->set('basket', $basket);
    }

    public function decrease($id)
    {
        $basket = $this->session->get('basket', []);

        if ($basket[$id] > 1) {
            $basket[$id]--;
        } else {
            unset($basket[$id]);
        }

        return $this->session->set('basket', $basket);
    }

    public function getAllBasket()
    {
        $basketOver = [];
        if ($this->get()) {
            foreach($this->get() as $id => $quantity) {
                $jeuxvideo = $this->entityManager->getRepository(Jeuxvideo::class)->findOneById($id);
                if (!$jeuxvideo) {
                    $this->delete($id);
                    continue;
                }
                $basketOver[] = [
                    'jeuxvideo' => $jeuxvideo,
                    'quantity' => $quantity
                ];
            }
        }
        return $basketOver;
    }
}