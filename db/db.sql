drop database if exists cinemadb;
create database cinemadb;
use cinemadb;

/**
 * Users
 * Items
 * Tickets
 * Movies
 * Schedule
 */

/**
 * @table: users
 * Types:
 * 		0) Admin
 * 		1) Guest
 */

create table users (
	id int unsigned not null primary key auto_increment,
	email varchar(50) unique not null,
	name varchar(45) not null,
	passwd char(32) not null,
	usertype boolean not null,
	isactive boolean not null default false
)engine=innodb;

create table accountactivation (
	userid int unsigned not null,
	token char(32) null,
	expired boolean not null default false
)engine=innodb;

alter table accountactivation
	add constraint fk_users0
		foreign key accountactivation (userid)
			references users (id)
				on update no action
				on delete cascade;

create table accountrecovery (
	userid int unsigned not null,
	token char(32) null,
	expired boolean not null default false
)engine=innodb;

alter table accountrecovery
	add constraint fk_users1
		foreign key accountrecovery (userid)
			references users (id)
				on update no action
				on delete cascade;

create table movies (
	id int unsigned not null primary key auto_increment,
	name varchar(80) not null,
	descr varchar(150) not null,
	lenght int not null
)engine=innodb;

create table movieschedule(
	movieid int unsigned not null,
	ihour time not null,
	ehour time not null,
	day enum("mon", "thu", "wed", "thur", "fry", "sat", "sun") not null
)engine=innodb;

alter table movieschedule
	add constraint fk_movies0
		foreign key movieschedule (movieid)
			references movies (id)
				on update no action
				on delete cascade;

create table items (
	id int unsigned not null primary key auto_increment,
	name varchar(60) not null,
	price float not null
)engine=innodb;

create table buyitems (
	itemid int unsigned not null,
	quantity int not null
)engine=innodb;

alter table buyitems
	add constraint fk_items0
		foreign key buyitems (itemid)
			references items (id)
				on update no action
				on delete cascade;

/**
 * ticket-id: <userid><now()><movieid>
 */
create table tickets (
	id char(16) unique null,
	movieid int unsigned not null,
	userid int unsigned not null,
	buydate date not null
)engine=innodb;

alter table tickets
	add constraint fk_movies1
		foreign key tickets (movieid)
			references movies (id)
				on update no action
				on delete cascade;

alter table tickets
	add constraint fk_users2
		foreign key tickets (userid)
			references users (id)
				on update no action
				on delete cascade;

delimiter //

/**
 * TRIGGERS
 */

create trigger trgBITickets before insert on tickets
for each row
	begin
		declare new_ticket_id char(16) default(select reverse(replace(replace(replace(now(), "-", ""), ":", ""), " ", "")));
		set new_ticket_id = (select substring(new_ticket_id, 1, 16));
		set new.id = (select concat(new.userid, new_ticket_id ,new.movieid));
	end;//



/**
 * Datatypes
 * 		Numbers
 * 			-float
 * 			-double
 * 			-int (32 bits)
 * 				-shortint (16 bits)
 * 				-tinyint (8 bits)
 * 			-bigint (64 bits)
 * 	  		-unsigned
 * 	  	Booleans
 * 	  		-tinyint(1)
 * 	  		-boolean
 * 	  			-true
 * 	  			-false
 * 	  	 Strings
 * 	  	 	-char
 * 	  	 	-varchar
 * 	  	 Binary
 * 	  	 	-text
 * 	  	 		-full text
 * 	  	 		-medium text
 * 	  	 		-short text
 * 	  	 	-blobs
 */

/**
 * FUNCTIONS
 */

/**
 * [generateActivationToken description]
 * @param  {[type]} pemail [description]
 * @return {[type]}        [description]
 */
create function generateActivationToken(pemail varchar(50)) returns tinyint(2)
	begin
		declare flag tinyint(2) default(0);

		if exists(select id from users where email = pemail limit 1) then
			begin
				declare uid int unsigned default(select id from users where email=pemail);

				if not exists(select userid from accountactivation where userid=uid) then
					begin
						declare tmptoken char(32) default(select md5(concat(uid, uid+rand(), curdate())));
						insert into accountactivation(userid, token) values(uid, tmptoken);
						set flag = 2;
					end;
				else
					set flag = 1;
				end if;
			end;
		end if;

		return flag;
	end;//


create function activateAccount(ptoken char(32)) returns tinyint(2)
	begin
		declare flag tinyint(2) default(0);

		if exists(select userid from accountactivation where token=ptoken and expired=false limit 1) then
			begin
				declare uid int unsigned default(select userid from accountactivation where token=ptoken);
				update accountactivation set expired=true where token=ptoken;
				update users set isactive=true where id=uid;
				set flag = 2;
			end;
		elseif exists(select userid from accountactivation where token=ptoken and expired=true limit 1) then
			begin
				set flag = 1;
			end;
		end if;

		return flag;
	end;//


delimiter ;