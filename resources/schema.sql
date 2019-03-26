use Restaurants;

CREATE TABLE customer
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  password VARCHAR(100)
);

CREATE TABLE customer_meal
(
  klant_id INTEGER,
  gerecht_id INTEGER
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
  gerecht_id INTEGER,
  assortiment_id INTEGER
);

CREATE TABLE assortment
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  price DOUBLE,
  gerecht_id INTEGER
);

CREATE TABLE order
(
  id serial PRIMARY KEY,

);

CREATE TABLE order_customer
(


);

