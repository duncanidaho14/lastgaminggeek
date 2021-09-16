<?php

namespace App\Controller;


use Predis\Client;
use RedisException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *  @Route("/redis", name="redis")
**/
class RedisController extends AbstractController
{
    
    
    public function __construct()
    {
       
    }
    
    /**
     * @Route("/set", service="app.controller.redis")
     */
    public function connect(): Response
    {
        // $redis = new Redis();
        // // $cache = new RedisAdapter(
        // //     Redis $redisConnection,

        // //     // the string prefixed to the keys of the items stored in this cache
        // //     $namespace = '',

        // //     // the default lifetime (in seconds) for cache items that do not define their
        // //     // own lifetime, with a value 0 causing items to be stored indefinitely (i.e.
        // //     // until RedisAdapter::clear() is invoked or the server(s) are purged)
        // //     $defaultLifetime = 0
        // // );

        // $client = RedisAdapter::createConnection(
        //     'redis://localhost:6379',
        //     [
        //         'lazy' => false,
        //         'persistent' => 0,
        //         'persistent_id' => null,
        //         'tcp_keepalive' => 0,
        //         'timeout' => 30,
        //         'read_timeout' => 0,
        //         'retry_interval' => 0,
        //     ]
        // );

        // $cache = new RedisTagAwareAdapter($client);
        // return $cache;

        $client = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
            'password'    => 'Zoldyk99'
        ]);
        $client->set('foo', 'bar');
        $value = $client->get('foo');

        return $this->render('redis/redis.html.twig', [
            'redis' => $value
        ]);
    }


    // /**
    //  * @param Request $request
    //  *
    //  * @Method({"GET"})
    //  * @Route("/set", service="app.controller.redis")
    //  *
    //  * @return Response
    //  */
    // public function setAction(Request $request)
    // {
    //     $key = $request->query->get('key');
    //     $value = $request->query->get('value');
    //     $ttl = $request->query->get('ttl');
    
    //     $result = null;
    
    //     try {
    //         if ($key && $value) {
    //             $this->cache->set($key, $value, $ttl);
    //             $result = ['key' => $key, 'value' => $value, 'ttl' => $ttl];
    //         }
    //     } catch (RedisException $e) {
    //         $result = $e->getMessage();
    //     }
    
    //     return new Response(json_encode($result));
    // }
    
    // /**
    //  * @param Request $request
    //  *
    //  * @Method({"GET"})
    //  * @Route("/get")
    //  *
    //  * @return Response
    //  */
    // public function getAction(Request $request)
    // {
    //     $key = $request->query->get('key');
    
    //     $result = null;
    
    //     try {
    //         if ($key) {
    //             $result = ['key' => $key, 'value' => $this->cache->get($key)];
    //         }
    //     } catch (RedisException $e) {
    //         $result = $e->getMessage();
    //     }
    
    //     return new Response(json_encode($result));
    // }
    
    // /**
    //  * @param Request $request
    //  *
    //  * @Method({"GET"})
    //  * @Route("/ttl")
    //  *
    //  * @return Response
    //  */
    // public function ttlAction(Request $request)
    // {
    //     $key = $request->query->get('key');
    
    //     $result = null;
    
    //     try {
    //         if ($key) {
    //             $result = ['key' => $key, 'ttl' => $this->cache->getTtl($key)];
    //         }
    //     } catch (RedisException $e) {
    //         $result = $e->getMessage();
    //     }
    
    //     return new Response(json_encode($result));
    // }
    
    // /**
    //  * @param Request $request
    //  *
    //  * @Method({"GET"})
    //  * @Route("/persist")
    //  *
    //  * @return Response
    //  */
    // public function persistAction(Request $request)
    // {
    //     $key = $request->query->get('key');
    
    //     $result = null;
    
    //     try {
    //         if ($key) {
    //             $result = ['key' => $key, 'persist' => $this->cache->persist($key)];
    //         }
    //     } catch (RedisException $e) {
    //         $result = $e->getMessage();
    //     }
    
    //     return new Response(json_encode($result));
    // }
    
    // /**
    //  * @param Request $request
    //  *
    //  * @Method({"GET"})
    //  * @Route("/expire")
    //  *
    //  * @return Response
    //  */
    // public function expireAction(Request $request)
    // {
    //     $key = $request->query->get('key');
    //     $ttl = $request->query->get('ttl');
    
    //     $result = null;
    
    //     try {
    //         if ($key) {
    //             $result = ['key' => $key, 'expire' => $this->cache->expire($key, $ttl)];
    //         }
    //     } catch (RedisException $e) {
    //         $result = $e->getMessage();
    //     }
    
    //     return new Response(json_encode($result));
    // }
    
    // /**
    //  * @param Request $request
    //  *
    //  * @Method({"GET"})
    //  * @Route("/delete")
    //  *
    //  * @return Response
    //  */
    // public function deleteAction(Request $request)
    // {
    //     $key = $request->query->get('key');
    
    //     $result = null;
    
    //     try {
    //         if ($key) {
    //             $result = ['key' => $key, 'expire' => $this->cache->delete($key)];
    //         }
    //     } catch (RedisException $e) {
    //         $result = $e->getMessage();
    //     }
    
    //     return new Response(json_encode($result));
    // }



// /**
//  *  @Route("/redis", name="redis", service="app.controller.redis")
// **/
// class RedisController
// {
//     private $cache;
    
//     public function __construct(Cache $cache)
//     {
//         $this->cache = $cache;
//     }
    
//     /**
//      * @param Request $request
//      *
//      * @Method({"GET"})
//      * @Route("/set")
//      *
//      * @return Response
//      */
//     public function setAction(Request $request)
//     {
//         $key = $request->query->get('key');
//         $value = $request->query->get('value');
//         $ttl = $request->query->get('ttl');
    
//         $result = null;
    
//         try {
//             if ($key && $value) {
//                 $this->cache->set($key, $value, $ttl);
//                 $result = ['key' => $key, 'value' => $value, 'ttl' => $ttl];
//             }
//         } catch (RedisException $e) {
//             $result = $e->getMessage();
//         }
    
//         return new Response(json_encode($result));
//     }
    
//     /**
//      * @param Request $request
//      *
//      * @Method({"GET"})
//      * @Route("/get")
//      *
//      * @return Response
//      */
//     public function getAction(Request $request)
//     {
//         $key = $request->query->get('key');
    
//         $result = null;
    
//         try {
//             if ($key) {
//                 $result = ['key' => $key, 'value' => $this->cache->get($key)];
//             }
//         } catch (RedisException $e) {
//             $result = $e->getMessage();
//         }
    
//         return new Response(json_encode($result));
//     }
    
//     /**
//      * @param Request $request
//      *
//      * @Method({"GET"})
//      * @Route("/ttl")
//      *
//      * @return Response
//      */
//     public function ttlAction(Request $request)
//     {
//         $key = $request->query->get('key');
    
//         $result = null;
    
//         try {
//             if ($key) {
//                 $result = ['key' => $key, 'ttl' => $this->cache->getTtl($key)];
//             }
//         } catch (RedisException $e) {
//             $result = $e->getMessage();
//         }
    
//         return new Response(json_encode($result));
//     }
    
//     /**
//      * @param Request $request
//      *
//      * @Method({"GET"})
//      * @Route("/persist")
//      *
//      * @return Response
//      */
//     public function persistAction(Request $request)
//     {
//         $key = $request->query->get('key');
    
//         $result = null;
    
//         try {
//             if ($key) {
//                 $result = ['key' => $key, 'persist' => $this->cache->persist($key)];
//             }
//         } catch (RedisException $e) {
//             $result = $e->getMessage();
//         }
    
//         return new Response(json_encode($result));
//     }
    
//     /**
//      * @param Request $request
//      *
//      * @Method({"GET"})
//      * @Route("/expire")
//      *
//      * @return Response
//      */
//     public function expireAction(Request $request)
//     {
//         $key = $request->query->get('key');
//         $ttl = $request->query->get('ttl');
    
//         $result = null;
    
//         try {
//             if ($key) {
//                 $result = ['key' => $key, 'expire' => $this->cache->expire($key, $ttl)];
//             }
//         } catch (RedisException $e) {
//             $result = $e->getMessage();
//         }
    
//         return new Response(json_encode($result));
//     }
    
//     /**
//      * @param Request $request
//      *
//      * @Method({"GET"})
//      * @Route("/delete")
//      *
//      * @return Response
//      */
//     public function deleteAction(Request $request)
//     {
//         $key = $request->query->get('key');
    
//         $result = null;
    
//         try {
//             if ($key) {
//                 $result = ['key' => $key, 'expire' => $this->cache->delete($key)];
//             }
//         } catch (RedisException $e) {
//             $result = $e->getMessage();
//         }
    
//         return new Response(json_encode($result));
//     }
}