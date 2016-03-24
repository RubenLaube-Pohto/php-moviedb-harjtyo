# Movie DB Interface in PHP

Available at: http://student.labranet.jamk.fi/~H8871/www/palvelinohjelmointi/php-moviedb-harjtyo

[Introduction](#introduction)  
[Requirements](#requirements)  
[Issues](#issues)  
[Spent Time](#spent-time)  

## Introduction

The purpose of this project is to create a web app in PHP for a database containing movie titles and personel who worked with said movie titles.

It will use the Slim 2.x micro framework. Version 3.x is available but the school server does not support the required PHP version of 5.5. Web pages will be rendered with Plates template system. Slim had other templating extensions readily available but Plates was chosen as an interesting alternative. Luckily it had the slim/plates adapter package available, though setup was still a bit time consuming experience.

The database to be used is being / was created as part of the Databases course. Final features of the web app will include user accounts and basic CRUD operations to the database acording to permission levels. Coding is done as an end of course project for "WWW Server Programming" course.

The design documentation is to be very detailed as an end of course project for the "Software Design" course. The documentation will include user strories and different diagrams describing the software.

## Requirements

- [PHP](http://php.net/) 5.3.0 or newer
- [Slim](http://www.slimframework.com/) 2.6.2
- [slim/plates](https://packagist.org/packages/slim/plates) 1.0.2
- [Plates](http://platesphp.com/) 3.1.1

## Issues

Issues that have come up while working on the project.

### Arrays in PHP 5.3

Plates examples used array dereferencing but it is not available in PHP 5.3. I had to change syntax from

    echo $templates->render('profile', ['name' => 'Jonathan']);
to

    echo $templates->render('profile', array('name' => 'Jonathan'));

The example would have worked on PHP 5.4 [[2]].

### PHP short_open_tag

It was new to me that you could use `<?= ?>` as a short version of `<?php echo ?>`. Plates recommends to use short tags, possibly for readability. This is not usually recommended especialy in PHP <= 5.3 as it can conflict with XML-files `<?` and so I chose to use the longer syntax. Again, with PHP 5.4 I could have used short tags without problems [[1]].

On the school servers short tags are not enabled by default. This can be changed in the php.ini-file by setting `short_open_tag: On`.

## Spent Time

| Date | Hours | Tasks |
| :---: | :---: | :---: |
| 15.03.2016 | 6 | Preparing project and initial documentation |
| 16.03.2016 | 6 | Get Plates working |
| 17.03.2016 | 1 | Work on documentation |
| 23.03.2016 | 1 | Work on design docs |
| 24.03.2016 | 2 | Work on design docs |
| Total hours: | 16 |  |

[1]: http://php.net/manual/en/ini.core.php#ini.short-open-tag
[2]: http://stackoverflow.com/questions/742764/php-syntax-for-dereferencing-function-result
