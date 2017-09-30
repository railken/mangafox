# MangaFox Scraper

Search and download manga from [mangafox.me](http://mangafox.me/)

MangaFox Scraper is a library that gets all the needed information about manga for a manga-reader

## Requirements

PHP 7.0.0 or later.

## Composer

You can install it via [Composer](https://getcomposer.org/) by typing the following command:

```bash
composer require railken/mangafox
```


## Dependencies

- [`curl`](https://secure.php.net/manual/en/book.curl.php)


## Getting Started

Simple usage looks like:

```php

# Creating a new instance of manager
$manager = new \Railken\Mangafox\Mangafox();

# Searching a manga
$results = $manager
    ->search()
    ->type('any')
    ->name('contains', 'One Piece')
    ->author('contains', 'Oda Eiichiro')
    ->artist('contains', 'Oda Eiichiro')
    ->genres('include', ['Action', 'Drama', 'Historical'])
    ->releasedYear('<', '2017')
    ->rating('>', 4)
    ->completed(0)
    ->sortBy('name', 'ASC')
    ->page(1)
    ->get();

# Retrieving all info about a manga
$manga = $manager
	->resource('one_piece')
	->get();


# Retrieving all scans for a given manga, volume and chapter
$scans = $manager
	->scan('one_piece', 1, 1)
	->get();

# Retrieving last updates 
$results = $manager->releases()->page(1)->get();

# Perform a query in the directory
$results = $manager
    ->directory()
    ->browseBy('genre', 'Action')
    ->sortBy('name') 
    ->page(1)
    ->get();
```


## License

Open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Copyright

All the manga are copyrighted to their respective author. Please buy the manga if it's available in your country.