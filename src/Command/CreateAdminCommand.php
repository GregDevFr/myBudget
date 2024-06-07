<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'createAdmin',
    description: 'Add a short description for your command',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $existing = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([
            'email' => 'bonjour@greg-dev.fr'
        ]);

        if (null !== $existing) {
            $io->error('Admin user already exists!');
            return Command::FAILURE;
        }

        $admin = (new User())
            ->setEmail('bonjour@greg-dev.fr')
            ->setNom('Blémand')
            ->setPrenom('Grégory')
            ->setBirthDate(new \DateTime('1983-02-08'))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $admin->setPassword($this->hasher->hashPassword($admin, 'password'));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $io->success('Admin user created!');

        return Command::SUCCESS;
    }
}
