# Chess Repository Service

[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/RichardTrujilloTorres/chess-repository-service/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/RichardTrujilloTorres/chess-repository-service/?branch=master)
[![codecov](https://codecov.io/gh/RichardTrujilloTorres/chess-repository-service/branch/master/graph/badge.svg?token=NP34LYLVWR)](https://codecov.io/gh/RichardTrujilloTorres/chess-repository-service)


## What Is It
This is the API for the Chess Repository project. Its purpose is to hold in the cloud your games while having access
to all customary supporting service (aka analysis, position evaluation, etc.).
It's a WIP currently supporting hosting.

## Features
At the moment holds the games with lila-gif powered features. 
WIP: 
- Analysis request
- Full FEN elaboration (under its own package)
- Social media game sharing
- Infinite cloud based analysis w/ periodic evaluation notification according to settings

## Method
In tech terms, this is a Lumen powered app w/ full code coverage.
It's the main one. There are more supporting services (i.e. media generation on [Chess Media Service][link-chess-media-service])

## Installation and Setup
The usual. Set the .env.example file:

``` bash
composer install
php artisan migrate
```

## Demo
Check out the [demo][link-demo].

## Wish List
The iOS native App: I'm not an on-the-go player, but for someone that happens to be it helps.

## Contributing
If you happen to be a chess player or for whatever the reason have some interesting feedback/suggestions, 
feel free to open issues with them. The project will have everything I fancy, but it's always great when
people benefit from your work.

## Security Vulnerabilities
Again, the customary. If you find some issues, please let me know. 

## License

[link-chess-media-service]: https://github.com/RichardTrujilloTorres/chess-media-service
[link-demo]: https://master.d2w903qzsa9bxc.amplifyapp.com/
