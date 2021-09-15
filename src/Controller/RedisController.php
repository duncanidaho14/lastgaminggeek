<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Classes\Cache;
use RedisException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 *  @Route("/redis", name="redis", service="app.controller.redis")
**/
class RedisController
{
    private $cache;
    
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * @param Request $request
     *
     * @Method({"GET"})
     * @Route("/set")
     *
     * @return Response
     */
    public function setAction(Request $request)
    {
        $key = $request->query->get('key');
        $value = $request->query->get('value');
        $ttl = $request->query->get('ttl');
    
        $result = null;
    
        try {
            if ($key && $value) {
                $this->cache->set($key, $value, $ttl);
                $result = ['key' => $key, 'value' => $value, 'ttl' => $ttl];
            }
        } catch (RedisException $e) {
            $result = $e->getMessage();
        }
    
        return new Response(json_encode($result));
    }
    
    /**
     * @param Request $request
     *
     * @Method({"GET"})
     * @Route("/get")
     *
     * @return Response
     */
    public function getAction(Request $request)
    {
        $key = $request->query->get('key');
    
        $result = null;
    
        try {
            if ($key) {
                $result = ['key' => $key, 'value' => $this->cache->get($key)];
            }
        } catch (RedisException $e) {
            $result = $e->getMessage();
        }
    
        return new Response(json_encode($result));
    }
    
    /**
     * @param Request $request
     *
     * @Method({"GET"})
     * @Route("/ttl")
     *
     * @return Response
     */
    public function ttlAction(Request $request)
    {
        $key = $request->query->get('key');
    
        $result = null;
    
        try {
            if ($key) {
                $result = ['key' => $key, 'ttl' => $this->cache->getTtl($key)];
            }
        } catch (RedisException $e) {
            $result = $e->getMessage();
        }
    
        return new Response(json_encode($result));
    }
    
    /**
     * @param Request $request
     *
     * @Method({"GET"})
     * @Route("/persist")
     *
     * @return Response
     */
    public function persistAction(Request $request)
    {
        $key = $request->query->get('key');
    
        $result = null;
    
        try {
            if ($key) {
                $result = ['key' => $key, 'persist' => $this->cache->persist($key)];
            }
        } catch (RedisException $e) {
            $result = $e->getMessage();
        }
    
        return new Response(json_encode($result));
    }
    
    /**
     * @param Request $request
     *
     * @Method({"GET"})
     * @Route("/expire")
     *
     * @return Response
     */
    public function expireAction(Request $request)
    {
        $key = $request->query->get('key');
        $ttl = $request->query->get('ttl');
    
        $result = null;
    
        try {
            if ($key) {
                $result = ['key' => $key, 'expire' => $this->cache->expire($key, $ttl)];
            }
        } catch (RedisException $e) {
            $result = $e->getMessage();
        }
    
        return new Response(json_encode($result));
    }
    
    /**
     * @param Request $request
     *
     * @Method({"GET"})
     * @Route("/delete")
     *
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $key = $request->query->get('key');
    
        $result = null;
    
        try {
            if ($key) {
                $result = ['key' => $key, 'expire' => $this->cache->delete($key)];
            }
        } catch (RedisException $e) {
            $result = $e->getMessage();
        }
    
        return new Response(json_encode($result));
    }
}