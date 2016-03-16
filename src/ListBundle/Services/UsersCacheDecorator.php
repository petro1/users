<?php
namespace ListBundle\Services;

use ListBundle\Criteria\UsersCriteria;

use Doctrine\Common\Cache\CacheProvider;
/**
 * Description of UsersCacheDecorator
 *
 * @author ptanco
 */
class UsersCacheDecorator implements UsersServiceInterface
{
    const CACHE_KEY = 'user';

    private $cache;

    private $cacheTTL;

    private $decorated;

    public function __construct(
        UsersServiceInterface $decorated,
        CacheProvider $cache
    ) {
        $this->decorated = $decorated;
        $this->cache = $cache;
    }

    public function setCacheTTL($cacheTTL)
    {
        $this->cacheTTL = $cacheTTL;
    }

    /*
     * {@inheritdoc}
     */
    public function getUsersList(UsersCriteria $criteria) {}

    /*
     * {@inheritdoc}
     */
    public function getUserDetails($userId)
    {
        if ($this->cache->contains(self::CACHE_KEY.$userId)) {
           return $this->cache->fetch(self::CACHE_KEY.$userId);
        }
        
        $user = $this->decorated->getUserDetails($userId);
        $this->cache->save(self::CACHE_KEY.$userId, $user, strtotime('4 hours'));

        return $user;
    }

    public function invalidateCache($userId)
    {
        if ($this->cache->contains(self::CACHE_KEY.$userId)) {
           try {
               $this->cache->delete(self::CACHE_KEY.$userId);
           } catch (Exception $ex) {
               throw $ex;
           } 
        }

        return true;
    }
}