use Restaurants;

DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS customer_meal;
DROP TABLE IF EXISTS meal;
DROP TABLE IF EXISTS meal_assortment;
DROP TABLE IF EXISTS assortment;
DROP TABLE IF EXISTS order;

CREATE TABLE customer
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  password VARCHAR(100)
);

CREATE TABLE customer_meal
(
  customer_id INTEGER,
  meal_id INTEGER
);

CREATE TABLE meal
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(100),
  price DOUBLE
);

CREATE TABLE meal_assortment
(
  meal_id INTEGER,
  assortment_id INTEGER
);

CREATE TABLE assortment
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  price DOUBLE,
  meal_id INTEGER
);

CREATE TABLE order_meal
(
  order_id INTEGER,
  meal_id INTEGER,
  PRIMARY KEY (order_id, meal_id)
);

CREATE TABLE order
(
  id serial PRIMARY KEY,
  customer_id INTEGER,
  meal_id INTEGER
);
