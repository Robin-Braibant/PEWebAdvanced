USE Restaurants;

insert into gerecht(name, image, price)
  values('Biefstuk', 'biefstuk.jpg', 26.00),
        ('Koninginnenhapje', 'koninginnenhap.jpg', 16.00),
        ('Ribbetjes', 'ribbetjes.jpg', 18.00),
        ('Spaghetti Bolognaise', 'spaghetti.jpg', 12.00),
        ('Forelfilet', 'forel.jpg', 24.00),
        ('Zalmfilet', 'zalm.jpg', 24.00);


insert into assortiment(name, price)
values('Frieten', 2.50),
      ('Kroketten', 3.00),
      ('Peperroomsaus', 1.50),
      ('Béarnaise', 1.00),
      ('Wittewijnsaus', 1.00);

insert into gerecht_assortiment(gerecht_id, assortiment_id)
  values((select id from gerecht where name='Biefstuk'), (select id from assortiment where name='Frieten')),
        ((select id from gerecht where name='Biefstuk'), (select id from assortiment where name='Kroketten')),
        ((select id from gerecht where name='Biefstuk'), (select id from assortiment where name='Peperroomsaus')),
        ((select id from gerecht where name='Biefstuk'), (select id from assortiment where name='Béarnaise')),
        ((select id from gerecht where name='Koninginnenhapje'), (select id from assortiment where name='Kroketten')),
        ((select id from gerecht where name='Koninginnenhapje'), (select id from assortiment where name='Frieten'));

insert into klant(name, password)
  values('Robin', 'paswoord'),
        ('Shane', 'paswoord'),
        ('Lars', 'paswoord'),
        ('Maxim', 'paswoord');
