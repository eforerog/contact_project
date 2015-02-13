# contact_project

This is a contact system demo.

You can see online this repo an AWS EC2 instance at http://54.145.136.187. You are free to create an user and test the system.

This project use a MVC architecture based in laravel 5 php framework.

The layout of this project is:

M - Located at (contact_app/app/)
    The model files are: Contact.php, Email.php, Phone.php, User.php
    This files are based in Eloquent ORM (from Laravel). You can see documentation at http://laravel.com/docs/5.0/eloquent
V - Located at (contact_app/resources/views)
    The views used have and master page or layout named app.blade.php and for each section exist a view named similar to the model name. This views use a template language provided by Laravel. You can see documentation at http://laravel.com/docs/5.0/views
C - Located at (contact_app/app/Http/Controllers/)
    The controllers use the Laravel core for proccess all the actions of the systems. You can see documentation at http://laravel.com/docs/5.0/controllers 
    
Additional to this, the system have a section for unit test based in phpunit and is possible to see in the folder contact_app/test folder. All the information about this is possible to see at http://laravel.com/docs/5.0/testing.

This project have two modules: The first is a user authentication module based in laravel platform. The second is a contact module, designed from a requirements document.

This system support upload and process of XLS, XLSX, CSV and TSV spreadsheats using the Laravel-Excel library (https://github.com/Maatwebsite/Laravel-Excel). this library is based in PHPExcel library for php. I select this library because have good documentation, is growing and is the most downloaded in github for this purposes.
