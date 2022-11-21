# SecuPay API

### About project

For this project the main concern was to keep simplicity(KISS) and clarity.
this project has been run on docker-container provided by Laravel sail.

### Before running project
please consider follwoing ENV vars before project setup or check .env.example:
> FORWARD_DB_PORT //to address the db port <br />
> APP_PORT=99 <br />
> DB_CONNECTION=mysql<br />
> DB_HOST=mysql<br />
> DB_PORT=3306<br />
> FORWARD_DB_PORT=4001<br />
> DB_DATABASE=secupay<br />
> DB_USERNAME=sail<br />
> DB_PASSWORD=password<br />

### To run Project

Enter the project folder and run following commands: 
> all endpoints are guarded, so valid {?api-key} should be provided.
```sh
$ cd secupay
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail composer install
$ php artisan migrate // existing tables are not managed in mgrations
```
### To run tests

```sh
./vendor/bin/sail artisan test
```
> note: there is only 1 test for this project. but some ModelFactories have been created <br />
> with more migrations better test coverage is possible.


# Api endpoints
Endpoins are designed based on steps of given Document.

#### 1- Get serverTIme

```sh
$ [GET] /api/servertime/?api-key={$apiKey} 
response example:

{
    "serverTime" : "2022-11-21 20:11:51"
}
```
#### 2- get flagbits

```sh
$ [GET] /api/flagbit/{transactionId}/?api-key={$apiKey}

response example:

{
    "flags": [
      "TRANSACTION_FLAG_EXT_API",
      "TRANSACTION_FLAG_CHECKOUT",
      "TRANSACTION_FLAG_LVP"
    ]
}
```

> it reutns all user's transactions' flagbits (constants)

#### 3- create flagbit

```sh
$ [POST] /api/flagbit/?api-key={$apiKey}
 request body example:
{
    "dataTypeId" : 11,
    "dataId" : 1,
    "flagbitId" : 13,
    "periodId" : 3,
    "userId" : 2
}
```
> these params are all required and will be validated

#### 4 - redirect to url (it redirects to url based on given uuid)
```sh
$ [DELETE] /api/flagbit/{transactionId}/?api-key={$apiKey}
response example:
{
    []
}
```
> note: this endpoint can be run by a user having masterKey
