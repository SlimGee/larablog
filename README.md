## Laraveblog

This is a simple blog application built with Laravel. 

## Installation
To install locally simply clone this repository and run the following commands:
```bash
git clone https://github.com/SlimGee/larablog.git
``` 
```bash
cd larablog
```
```bash
composer install
```

Install npm dependencies
```bash
npm install
```

or if you prefer yarn
```bash
yarn install
```

Start the dev asset compiler
```bash
npm run dev
```

Configure your .env file
```bash
cp .env.example .env
```

Add your database credentials to the .env file

If you're using laravel valet run this project with
```bash
valet open
```

Or if simply using php artisan serve
```bash
php artisan serve
```


## PS
Everything in this app is behind authentication, so you'll need to register and login to access the blog posts. 


