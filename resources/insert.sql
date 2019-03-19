insert into gerechten(name, image, price)
  values('Biefstuk', 'biefstuk.jpg', 26.00),
        ('Koninginnenhapje', 'koninginnenhap.jpg', 16.00),
        ('Ribbetjes', 'ribbetjes.jpg', 18.00),
        ('Spaghetti Bolognaise', 'spaghetti.jpg', 12.00),
        ('Forelfilet', 'forel.jpg', 24.00),
        ('Zalmfilet', 'zalm.jpg', 24.00);

insert into gerechten(name, image, price)
values('Biefstuk', 'biefstuk.jpg', 26.00),
      ('Koninginnenhapje', 'koninginnenhap.jpg', 16.00),
      ('Ribbetjes', 'ribbetjes.jpg', 18.00),
      ('Spaghetti Bolognaise', 'spaghetti.jpg', 12.00),
      ('Forelfilet', 'forel.jpg', 24.00),
      ('Zalmfilet', 'zalm.jpg', 24.00);


insert into assortimenten(name, price, gerecht_id)
values('Frieten', 2.50),
      ('Kroketten', 3.00),
      ('Peperroomsaus', 1.50),
      ('Béarnaise', 1.00),
      ('Wittewijnsaus', 1.00),
      ('Wittewijnsaus', 1.00);

/*insert into assortimenten(name, price);

CREATE TABLE assortiment
(
  id serial PRIMARY KEY,
  name VARCHAR(100),
  price DOUBLE,
  gerecht_id INTEGER
);*/
