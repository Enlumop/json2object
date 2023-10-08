# Json2Object Conventer

Easy to use Json 2 Object of class conventer.

## Installation

Composer:

```shell
composer require enlumop/json2obj
```

## Usage

First map JSON properties in your class:

```php
<?php

use Enlumop\JsonMapper\Attribute\JsonMap;

class MyDtoClass
{
    // If you need set base type then declarate type in mapper
    // You can use eg.  string, int, integer, bool, boolean, float
    #[JsonMap(type: 'string')]
    public string $name;

    // Sometimes json property name is diffrent. Then you can use other json property name to map class property.
    #[JsonMap(type: 'string', jsonPropertyName: 'shortlyUserName')]
    public string $shortName;

    #[JsonMap(type: 'int')]
    public int $age;

    // If property is the same as json property then you don't need to set a type
    #[JsonMap()]
    public bool $isFine;

     // Mapping is also working with a private and protected properties
    #[JsonMap()]
    private bool $isPrivate;

    // If structure of JSON is more complex then as type use classname
    #[JsonMap(type: OtherDto::class)]
    public OtherDto $other;

    /**
     * For array we need type of the values
     * @var array<string>
     */
    #[JsonMap(type: 'array<string>')]
    public array $stringArray;

    /**
     * For type of values array you can use clasename
     * @var array<OtherDto>
     */
    #[JsonMap(type: 'array<' . OtherDto::class . '>')]
    public array $objectsArray;
}

```

That class has mapping for this json:

```json
{
    "name": "foo bar baz",
    "shortlyUserName": "bar",
    "age": "111",
    "isFine": true,
    "isPrivate": true,
    "other": {
        "anotherProperty": "another value"
    },
    "stringArray": [ "foo", "bar", "baz" ],
    "objectsArray": [
        {
            "anotherProperty": "other another value"
        },
        {
            "anotherProperty": "any other another value"
        }
    ]
}
```

Then, if you have a JSON and Mapping in your class then just convert that:

```php
<?php
use function Enlumop\JsonMapper\json2Obj;

// Get some json data
$json = "GIVE ME SOME JSON IN HERE";

// Convert json to object of MyDtoClass
$myObj = json2Obj(MyDtoClass::class, $json);

```

and done! You have object of MyDtoClass!
