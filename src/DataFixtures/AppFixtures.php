<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Grade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->addUsers($manager);
        $this->addGrade($manager);
    }

    private function addGrade(ObjectManager $manager)
    {
        $cursos = [ 
            '1º GRADO',
            '2º GRADO',
            '3º GRADO',
            '4ª GRADO',
        ];

        foreach ($cursos as $key => $name) {
            $grade = new Grade();
            $grade->setName($name);
            $manager->persist($grade);
        }
        $manager->flush();
    } 

    private function addUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@gugocreative.com');
        $user->setRoles('ROLE_ADMIN');

        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('editor');
        $user->setEmail('editor@gugocreative.com');
        $user->setRoles('ROLE_EDITOR');

        $password = $this->encoder->encodePassword($user, 'editor');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        for ($i=1; $i<=10; $i++) {
            $user = new User();
            $user->setUsername('alumno'.$i);
            $user->setEmail('alumno'.$i.'@gugocreative.com');
            $user->setRoles('ROLE_STUDENT');

            $password = $this->encoder->encodePassword($user, 'alumno'.$i);
            $user->setPassword($password);

            $manager->persist($user);
        }
        $manager->flush();
    }

}