<?php

namespace App\Command;

use App\Entity\ContactEmail;
use App\Repository\ContactEmailRepository;
use App\Repository\UserRepository;
use App\Service\ContactEmailService;
use Doctrine\ORM\NonUniqueResultException;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;


class SendEmailContactCommand extends Command
{
    private ContactEmailRepository $contactEmailRepository;
    private MailerInterface $mailer;
    private ContactEmailService $contactEmailService;
    private UserRepository $userRepository;
    protected static $defaultName = 'app:send-emailcontact';

    /**
     * @param ContactEmailRepository $contactEmailRepository
     * @param MailerInterface $mailer
     * @param ContactEmailService $contactEmailService
     * @param UserRepository $userRepository
     */
    public function __construct(ContactEmailRepository $contactEmailRepository, MailerInterface $mailer, ContactEmailService $contactEmailService, UserRepository $userRepository)
    {
        $this->contactEmailRepository = $contactEmailRepository;
        $this->mailer = $mailer;
        $this->contactEmailService = $contactEmailService;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /* protected function configure(): void
     {
         $this
             ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
             ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
         ;
     }*/

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*$io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }
        if ($input->getOption('option1')) {
            // ...
        }
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');*/
        try {
            $emailToSendList = $this->contactEmailRepository->findBy(['isSend' => false]);

            $peintre = $this->userRepository->findPeintre();

            $emailAddress = new Address($peintre->getEmail(), $peintre->getFirstName() . ' ' . $peintre->getLastName());
            foreach ($emailToSendList as $m) {
                $email = (new Email())
                    ->from($m->getSenderEmail())
                    ->to($emailAddress)
                    ->subject('Message de ' . $m->getSenderName())
                    ->text($m->getMessage());
                $this->mailer->send($email);
                $this->contactEmailService->isSend($m);
            }
            return Command::SUCCESS;
        } catch (TransportExceptionInterface | NonUniqueResultException $e) {
            return Command::FAILURE;
        }

    }
}
