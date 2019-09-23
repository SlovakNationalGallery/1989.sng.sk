# Welcome

[![Build Status](https://travis-ci.com/SlovakNationalGallery/1989.sng.sk.svg?branch=master)](https://travis-ci.com/SlovakNationalGallery/1989.sng.sk)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

[1989.sng.sk](http://1989.sng.sk) is a digital project on the events of the 17th november 1989 by the Slovak National Gallery. Its main focus is on the visual aspects of the revolutionary times.


# Tech setup

## Requirements
This software is built with the [Laravel 6.x framework](http://laravel.com/) and [Backpack for Laravel](https://backpackforlaravel.com/)

It requires
* PHP >= 7.2.0
* MySQL >= 5.7

## Local Installation

1. Clone this repository.
    ```
    git clone git@github.com:SlovakNationalGallery/1989.sng.sk.git 1989.sng.sk/
    cd 1989.sng.sk/
    ```
2. Setup database in your favourite database editor. set:
    * db name
    * username
    * password
3. Set `.env` file. you can copy values from `.env.example`
4. Run `composer install` to fulfil required libraries.
5. Run migrations to setup the database with

Note: Visual Studio Code users can make use of [Dev Container](https://code.visualstudio.com/docs/remote/containers) config.

## Maintainer

This project is maintained by [lab.SNG](http://lab.sng.sk). If you have any questions please don't hesitate to ask them by creating an issue or email us at [lab@sng.sk](mailto:lab@sng.sk).

## License

Source code in this repository is licensed under the MIT license. Please see the [License File](LICENSE) for more information.
