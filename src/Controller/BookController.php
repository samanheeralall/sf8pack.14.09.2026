<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookSearchType;
use App\Repository\BookRepository;
use App\Search\BookSearchCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class BookController extends AbstractController
{
    #[Route('/books', name: 'app_book_index', methods: ['GET'])]
    public function index(
        BookRepository $bookRepository,
        #[MapQueryString] BookSearchCriteria $criteria = new BookSearchCriteria(),
    ): Response {
        $form = $this->createForm(BookSearchType::class);


        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->search($criteria),
            'form' => $form,
        ]);
    }

    #[Route(
        '/books/{id}',
        name: 'app_book_show',
        requirements: ['id' => Requirement::DIGITS],
        methods: ['GET']
    )]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}
