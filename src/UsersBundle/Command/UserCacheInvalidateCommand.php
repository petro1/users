<?php
namespace UsersBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Description of UserCacheInvalidateCommand
 *
 * @author ptanco
 */
class UserCacheInvalidateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('user_cache:invalidate')
            ->addArgument('userId', InputArgument::REQUIRED, 'User id required')
            ->setDescription('User cache invalidation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('userId');
        $output->writeln('Start invalidate cache for user: '.$userId);
        
        $cache = $this->getContainer()->get('users.users_service_cache');
        try{
            $cache->invalidateCache($userId);
        } catch (Exception $ex) {
            throw $ex;
        }
        
        $output->writeln('Invalidate cache successfully');
    }
}