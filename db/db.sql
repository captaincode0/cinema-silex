create cinemadb;
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