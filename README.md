# daterangeapi

```
$ composer install
$ php -S localhost:8181
```

## Get list of dates
```
$ curl -X GET 'http://localhost:8181'
```
output:
```
[
  {
    "id": "3",
    "start": "1",
    "end": "8",
    "price": "5"
  },
  {
    "id": "4",
    "start": "10",
    "end": "13",
    "price": "15"
  },
  {
    "id": "5",
    "start": "14",
    "end": "15",
    "price": "8"
  }
]
```
## Add a new range
```
$curl -X POST \
  'http://localhost:8181?a=add' \
  -H 'Content-Type: application/json' \
  -d '{
	"start": 10,
	"end": 13,
	"price": 15
}'
```
### Delete all records
```
$ curl -X GET 'http://localhost:8181?a=deleteAll' 
```


# Running test

```
$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/DateRangeTest.php
```