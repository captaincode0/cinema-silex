use cinemadb;

insert into users values(null, "developerdiego0@gmail.com", "diego", md5("myuser890Az"), 1, default);


insert into movies values(null, "X-Men Apocalypse", "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias assumenda non.", 1), (null, "Avengers Ultron Age", "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis velit, doloremque.", 2);

insert into items(name, price) values("Refresco", 130.50),("Palomitas", 150.99);

insert into movieschedule values(1, "16:30", "19:00", "mon"),
	(1, "12:00", "14:30", "thu"), (2, "18:00", "21:00", "thur"), (2, "16:00", "19:00", "fry");

insert into movieschedule select id, "16:30", "19:30", "wed" from movies;

insert into tickets values(null, 1, 1, curdate());