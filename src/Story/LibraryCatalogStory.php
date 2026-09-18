<?php

namespace App\Story;

use App\Entity\User;
use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\GenreFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture('catalog')]
final class LibraryCatalogStory extends Story
{
    public function build(): void
    {
        UserFactory::createOne(['email' => 'admin@library.local', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['email' => 'manager@library.local', 'roles' => ['ROLE_MANAGER']]);
        UserFactory::createOne(['email' => 'webmaster@library.local', 'roles' => ['ROLE_WEBMASTER']]);

        $librarian = UserFactory::createOne(['email' => 'librarian@library.local', 'roles' => ['ROLE_LIBRARIAN']]);
        $reader = UserFactory::createOne(['email' => 'reader@library.local']);

        $books = require dirname(__DIR__, 2) . '/fixtures/book_fixtures.php';

        BookFactory::createMany(\count($books), static function (int $i) use ($books, $reader, $librarian): array {
            $book = $books[$i - 1];

            return [
                'title'           => $book['title'],
                'isbn'            => $book['isbn'],
                'publicationDate' => $book['publicationDate'],
                'authors'          => [AuthorFactory::findOrCreate(['name' => $book['author']])],
                'addedBy' => $i % 3 === 0 ? $librarian : $reader,
                'genres'          => array_map(
                    static fn (string $name) => GenreFactory::findOrCreate(['name' => $name]),
                    $book['genres'],
                )
            ];
        });
    }
}
