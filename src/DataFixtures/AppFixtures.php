<?php

namespace App\DataFixtures;

use App\Entity\Store;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager,): void
    {
        $user = new User();

        $user->setName('Admin');
        $user->setEmail('admin@uaifood.com');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'admin'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_STORE_MANAGER']);

        $manager->persist($user);

        $user2 = new User();

        $user2->setName('User');
        $user2->setEmail('user1@uaifood.com');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user, 'user'));
        $user2->setRoles(['ROLE_USER']);

        $manager->persist($user2);

        for ($i = 0; $i < 6; $i++) {
            $store = new Store();

            $store->setName('Loja ' . $i);
            $store->setDescription('Essa é a loja ' . $i . '.');
            $store->setCnpj('00.000.000/0000-00');
            $store->setPhone('(00) 0000-0000');
            $store->setEmail('loja' . $i . '@uaifood.com');
            $store->setAddress('Rua A, 00' . $i . ' - Centro - Januária/MG');

            $store->setManager($user);
            $store->setLogoUrl('https://photographylife.com/wp-content/uploads/2023/05/Nikon-Z8-Official-Samples-00002.jpg');
            $store->setBannerUrl('https://photographylife.com/wp-content/uploads/2023/05/Nikon-Z8-Official-Samples-00002.jpg');

            $manager->persist($store);
        }

        $manager->flush();
    }
}
