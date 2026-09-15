<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class BookController extends AbstractController
{
    private function getBooks(): array
    {
        return [
            'the-lord-of-the-rings' => [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'year' => 1954,
                'genre' => 'Fantasy',
                'description' => 'The epic quest of the Fellowship to destroy the One Ring and defeat the dark lord Sauron in Middle-earth.',
            ],
            'the-eye-of-the-world' => [
                'title' => 'The Eye of the World',
                'author' => 'Robert Jordan',
                'year' => 1990,
                'genre' => 'Fantasy',
                'description' => 'The first book of the Wheel of Time series, following farm boy Rand al\'Thor as destiny pulls him far from his village.',
            ],
            'promise-of-blood' => [
                'title' => 'Promise of Blood',
                'author' => 'Brian McClellan',
                'year' => 2013,
                'genre' => 'Fantasy',
                'description' => 'A revolution has just overthrown the king — but the new government discovers a terrifying prophecy written in the blood of the dead.',
            ],
            'magician' => [
                'title' => 'Magician',
                'author' => 'Raymond E. Feist',
                'year' => 1982,
                'genre' => 'Fantasy',
                'description' => 'A kitchen boy discovers his remarkable magical abilities as his world is invaded by warriors from another realm.',
            ],
            'a-brief-history-of-time' => [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'year' => 1988,
                'genre' => 'Non-Fiction',
                'description' => 'An exploration of cosmology — black holes, the Big Bang, and the nature of time — written for the general reader.',
            ],
        ];
    }

    #[Route('/books', name: 'app_book_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $this->getBooks(),
        ]);
    }

    #[Route('/books/{slug}', name: 'app_book_show', requirements: ['slug' => Requirement::ASCII_SLUG],
        methods: ['GET'])]
    public function show(string $slug): Response
    {
        $books = $this->getBooks();
        if (!array_key_exists($slug, $books)) {
            throw $this->createNotFoundException('The book does not exist.');
        }

        return $this->render('book/show.html.twig', [
            'book' => $books[$slug],
        ]);
    }
}
