<?php

namespace App\Loan;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class LoanManager
{
    private const DEFAULT_DURATION_DAYS = 14;
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createLoan(User $user, Book $book): Loan
    {
        if (!$book->isAvailable()){
            throw new \RuntimeException('Book is not available');
        }

        $now = new \DateTimeImmutable();
        $loan = new Loan();
        $loan->setUser($user)
            ->setBook($book)
            ->setLoanDate($now)
            ->setDueDate($now->modify('+'.self::DEFAULT_DURATION_DAYS.' days'))
            ->setStatus(LoanStatus::Active);

        $book->setAvailable(false);

        $this->entityManager->persist($loan);
        $this->entityManager->flush();

        return $loan;
    }

    public function returnLoan(Loan $loan): void
    {
        $loan->setReturnDate(new \DateTimeImmutable())
        ->setStatus(LoanStatus::Returned);

        $loan->getBook()->setAvailable(true);

        $this->entityManager->flush();
    }
}
