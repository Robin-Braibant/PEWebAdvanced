use Restaurants;

CREATE TABLE klanten
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  password VARCHAR(100)
);

CREATE TABLE klanten_gerechten
(
  klant_id INTEGER,
  gerecht_id INTEGER
);

CREATE TABLE gerechten
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(100),
  price DOUBLE
);

CREATE TABLE gerecht_assortiment
(
  gerecht_id INTEGER,
  assortiment_id INTEGER
);

CREATE TABLE assortiment
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  price DOUBLE,
  gerecht_id INTEGER
);

CREATE TABLE bestellingen
(
  blog_post_id INTEGER,
  blog_comment_id INTEGER,
  PRIMARY KEY (blog_post_id, blog_comment_id)
);
