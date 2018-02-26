# Login workflow

Attribute | value
--------- |---------
version   | 1.0
creator   | nguyen.van.dat@alliedtechbase.com
created   | 2018-22-02

![LoginWorkFlow](https://lh4.googleusercontent.com/PZfELWfsXzbGgqP7nBCayDbYqqpPcRNQSbUFJ_HH4S7wJK55S9WSkyWyd4U8UbxcsOuRfJ4kJwcjMTVZX6oyeKTTrMQIAwqjvxSEeGxZoftzOfN4ueDW2ljafTzWOhvQoogvfcy6zg)


## Requirement

* Only allow login with account company (Email has domain of company : aainc.co.jp).
* If operator wants to download then it is required to login on a secure machine (only a few machine have IP private address is entitled to download).
* Account will be create auto if it is not exist on system.

## Impact

* All functions are required to login (without function answers survey).


## Functional references

* loginWithGoogle : 

        
        Path : app/Http/Controllers/Auth/LoginController.php 

* isSecurePrivateRange: 

        Path : app/Http/Services/AuthService.php
        Goals : Check the user who had login to system?
            (1) If login on secure machine => redirect to page download list
            (2) If login on nomarl machine => redirect to page survey list

## Database table related
* users

## Document reference

  see ![Document](https://docs.google.com/spreadsheets/d/1KZBQCwq3FLdunpxjGNZlLA58ZovPQ_9wuOiBkCXG2Os/edit#gid=664747388)


