<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SearchBundle\Services;

use Doctrine\Common\Cache\CacheProvider;
use SearchBundle\Services\SearchInterface;
use SearchBundle\Entities\User;
/**
 * Description of UsersCacheDecorator
 *
 * @author ptanco
 */
class UsersCacheDecorator implements SearchInterface
{
    const CACHE_KEY = 'search';
    
    private $cache;
    private $cacheTTL;
    private $decorated;

    public function __construct(CacheProvider $cache, SearchInterface $decorated, $cacheTTL)
    {
        $this->cache = $cache;
        $this->decorated = $decorated;
        $this->cacheTTL = $cacheTTL;
    }

    public function search(User $user)
    {
        if($this->cache->contains(self::CACHE_KEY.$user->getFirstName()))
        {
            return $this->cache->fetch(self::CACHE_KEY.$user->getFirstName());
        }
        $results = $this->decorated->search($user);
        $this->cache->save(self::CACHE_KEY.$user->getFirstName(), $results, $this->cacheTTL);

        return $results;
    }

    public function invalidateCache(User $user)
    {
        if ($this->cache->contains(self::CACHE_KEY.$user->getFirstName()))
        {
            try {
                $this->cache->delete(self::CACHE_KEY.$user->getFirstName());
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        return true;
    }
}