
<h1 align="center">
  <br>
  Online Exam 
  <br>
</h1>

<h4 align="center">online examination system with <a href="http://laravel.com" target="_blank">Laravel</a>.</h4>

## Description
you can create exams and set rules for them and students can create questions for them

## Installation


```
git clone git@github.com:mohamadrezza/online_exam.git exam
cd exam
composer install
cp .env.example .env
php artisan key:generate
```

Then you need to put your database credentials in the .env file.I used MySQL in this project,
run

```
php artisan migrate
```


## Features
* signup as teacher or student
* create lesson and assign teacher (by admin)
* create exam for lessons 
* create question and answers with attachment
* select questions for exam
* accept questions by teacher
* see results

