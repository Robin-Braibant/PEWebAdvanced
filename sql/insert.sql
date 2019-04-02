USE Restaurants;

insert into meal(name, image, price)
  values('Biefstuk', 'biefstuk.jpg', 26.00),
        ('Koninginnenhapje', 'koninginnenhap.jpg', 16.00),
        ('Ribbetjes', 'ribbetjes.jpg', 18.00),
        ('Spaghetti Bolognaise', 'spaghetti.jpg', 12.00),
        ('Forelfilet', 'forel.jpg', 24.00),
        ('Zalmfilet', 'zalm.jpg', 24.00);


insert into assortment(name, price)
values('Frieten', 2.50),
      ('Kroketten', 3.00),
      ('Peperroomsaus', 1.50),
      ('Béarnaise', 1.00),
      ('Wittewijnsaus', 1.00);

insert into meal_assortment(meal_id, assortment_id)
  values((select id from meal where name='Biefstuk'), (select id from assortment where name='Frieten')),
        ((select id from meal where name='Biefstuk'), (select id from assortment where name='Kroketten')),
        ((select id from meal where name='Biefstuk'), (select id from assortment where name='Peperroomsaus')),
        ((select id from meal where name='Biefstuk'), (select id from assortment where name='Béarnaise')),
        ((select id from meal where name='Koninginnenhapje'), (select id from assortment where name='Kroketten')),
        ((select id from meal where name='Koninginnenhapje'), (select id from assortment where name='Frieten'));

insert into customer(name, password)
  values('Robin', 'paswoord'),
        ('Shane', 'paswoord'),
        ('Lars', 'paswoord'),
        ('Maxim', 'paswoord');
