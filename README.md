

SHOE BRANDS
Tommy Bountham
March 27, 2015

Description:
The Shoe Brands project lets a user create multiple shoe stores and brands

Database
CREATE DATABASE shoes_db;
CREATE TABLE brands (id serial PRIMARY KEY, name varchar);
CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);
CREATE DATABASE shoe_test WITH TEMPLATE shoes_db;

Technology Used

    PHP/HTML
    PostgreSQL
    PHPUnit
    Silex
    Twig
    CSS

License
Tommy bountham

Copyright (c) 2015 Tommy Bountham
