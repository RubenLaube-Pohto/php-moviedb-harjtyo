# Movie DB Interface in PHP

Available at: http://student.labranet.jamk.fi/~H8871/www/palvelinohjelmointi/php-moviedb-harjtyo  
phpDocumentor generated API: http://student.labranet.jamk.fi/~H8871/www/palvelinohjelmointi/api  
These links may go down at any time after the end of course.

[Introduction](#introduction)  
[Requirements](#requirements)  
[Issues](#issues)  
[Closing Report](#closing-report)  
- [Design Documentation](#design-documentation)
- [What Was Implemented](#what-was-implemented)
- [What Was Left Out](#what-was-left-out)
- [What Was Learned](#what-was-learned)
- [Self-evaluation](#self-evaluation)

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

Other technologies used:

- [Kendo UI](http://www.telerik.com/kendo-ui)
- [phpDocumentor](https://www.phpdoc.org/)

## Installation

Install required packages with [Composer](https://getcomposer.org/).

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

### PUT and DELETE requests

Many browsers don't support PUT or DELETE requests. The functionality can be provided by Slim if you set form method to POST and add a hidden input tag with method override.

    <form method='post'>
        <input type="hidden" name="_METHOD" value="PUT">
		OR
        <input type="hidden" name="_METHOD" value="DELETE">

### Eloquent ORM

It would have been nice to try out the Eloquent ORM from Laravel with Slim [[3]] but the PHP version was too low.

### Problems with VPN

On the final weekend before finishing the project the VPN connection to school servers decided to oddly break. It was possible to reach one of the usually available drives but not the other. Last lines of the code had to be writen over SSH with Vim because it was the only way to reach the files. PS: Later FTP was used to get to the files. It was not as good as a working VPN but good enough.

## Closing Report

### Design Documentation

Use case:  
![use-case](docs/use-case.png)  
Architecture:  
![architecture](docs/architecture.png)  
Model:  
![model](docs/model.png)  
Classes:  
![classes](docs/classes.png)  
Listing sequence-diagram:  
![sequence-list](docs/sequence_lists.png)  
Movie related methods sequence-diagram (pretty much the same for person):  
![sequence-list](docs/sequence_movie.png)  

### What Was Implemented

- Basic CRUD for movies and people

### What Was Left Out

- Complex relations that exist in the database
- User authentication

### What Was Learned

- Designing helps to get a grasp of what needs to be done
- REST, at least to an extent
- Use of a php framework
- Use of templates
- Use of a HTML UI framework
- Managing database connection in php
- PHPDoc syntax and document generation

Slim was very easy and lightweight to use. It was perfect for a small project like this one as creating a new Slim-project didn't add the myriad of folders that come with bigger frameworks like Laravel and Yii. The user is free to create the directory structure they want and maybe to learn more as things are more bare bones.

It was simple to manage the routes and implement different request methods, including PUT and DELETE by using a hidden field in forms. This made the site / application structure clear and implementing it RESTfully was pretty intuitive.

### Self-evaluation

It was fun to work with the technologies and I realy liked to see everything working together. Unfortunately I didn't find the subject of a movie database that interesting so I spent much more time reading the documentation of the frameworks and implementing new things rather than trying to get the basic interface working as well as possible. As an after thougth I might have enjoyed more making a report on some part of the technologies used but I didn't think of it until much later. I also think I should have used a little bit more time with this project overall.

The documentation is pretty ok in my opinion. Having more classes and a more comlex structure for the program would make documents more valuable. They do, however, display the usage of different UML diagrams. For the programming part, using all the technologies suggest some level of knowledge about the subject. Too bad the total ammount of functionality is rather low. For myself I would suggest a grade of 2/5 for the "WWW Server Programming" course and 3.5/5 for "Software Design" course.

## Spent Time

| Date | Hours | Tasks |
| :---: | :---: | :---: |
| 15.03.2016 | 6 | Preparing project and initial documentation |
| 16.03.2016 | 6 | Get Plates working |
| 17.03.2016 | 1 | Work on documentation |
| 23.03.2016 | 1 | Work on design docs |
| 24.03.2016 | 5 | Work on design docs |
| 28.03.2016 | 4 | Implement classes |
| 29.03.2016 | 4 | Implement basic functionality |
| 08.04.2016 | 4 | Add navigation, implement list people |
| 15. - 17.04.2016 | 15 | Finish application and comment source code |
| 18.04.2016 | 2 | Presentation and final touches to the documentation |
| Total hours: | 48 |  |

[1]: http://php.net/manual/en/ini.core.php#ini.short-open-tag
[2]: http://stackoverflow.com/questions/742764/php-syntax-for-dereferencing-function-result
[3]: https://packagist.org/packages/illuminate/database
