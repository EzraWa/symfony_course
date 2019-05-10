<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadMicroPosts($manager);
        $this->loadUsers($manager);
    }

    private function loadMicroPosts(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $microPost = new MicroPost();
            $microPost->setText('Some random Text ' . rand(0, 100));
            $microPost->setTime(new \DateTime("2019-03-15"));
            $manager->persist($microPost);

        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('ezra');
        $user->setFullName('Ezra Waalboer');
        $user->setEmail('ezra@techtribe.nl');

        $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'ezra123'));

        $manager->persist($user);

        $manager->flush();

    }
}
