USE Restaurants;

insert into dishes(name, image, price)
  values('Biefstuk', 'biefstuk.jpg', 26.00),
        ('Koninginnenhapje', 'koninginnenhap.jpg', 16.00),
        ('Ribbetjes', 'ribbetjes.jpg', 18.00),
        ('Spaghetti Bolognaise', 'spaghetti.jpg', 12.00),
        ('Forelfilet', 'forel.jpg', 24.00),
        ('Zalmfilet', 'zalm.jpg', 24.00);

insert into assortments(name, price)
values('Rijst', 2.50),
      ('Frieten', 3.00),
      ('Noodles' , 2.50)
