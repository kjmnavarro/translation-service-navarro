# TranslationService Laravel App

This Laravel application manages translations with locales and tags, protected by Sanctum SPA authentication.

---

## About the Developer
This is a Coding Solution for Translation Management Service of Kieffer John M. Navarro.

## How to install the app locally
- Make sure Composer, Node.js and XAMPP is installed on your local device.
- Clone the repository using this link [https://github.com/kjmnavarro/translation-service-navarro.git](https://github.com/kjmnavarro/translation-service-navarro.git)

```

git clone https://github.com/kjmnavarro/translation-service-navarro.git

```

- Open the folder of the newly cloned code repo to a command prompt of GitBash
- You need to install composer and npm before running other Laravel scripts.

```

composer install
npm install
npm run dev

```

- You need to create a .env file and input details such as APPNAME and DBNAME. (You may refer to the .env example as guide)
- You need to run these Laravel artisan scripts

```

cp .env.example .env
php artisan key:generate
php artisan migrate

```

- Populate Translation Data

```

php artisan translations:populate 100

```

- After running the Laravel artisan scripts, you can now run the APP locally using this Laravel artisan script

```

php artisan serve

```

- Run Automated Tests

```

php artisan test

```

- Testing the API with Postman

```

http://localhost:8000/sanctum/csrf-cookie

```

- Send a POST request to:

```

http://localhost:8000/login

```

- Headers:

```

X-XSRF-TOKEN: <value_of_XSRF-TOKEN_cookie>
Content-Type: application/json
Accept: application/json

```

- Body (raw JSON):

```

{
  "email": "user@example.com",
  "password": "password"
}

```

- Access Protected API Routes

```

GET http://localhost:8000/api/translations/export?locale=en

```