create table category
(
	id int auto_increment
		primary key,
	name varchar(255) not null
)
;

create table episode
(
	id int auto_increment
		primary key,
	playlist int not null,
	program int not null,
	start_time datetime not null,
	end_time datetime not null,
	prerecord tinyint(1) null,
	prerecord_date date null,
	draft tinyint(1) not null,
	comment text null,
	programmer varchar(500) null
)
;

create index program
	on episode (program)
;

create table playlist
(
	id int auto_increment
		primary key
)
;

create table playlist_segments
(
	playlist int not null,
	segment int not null
)
;

create index id
	on playlist_segments (playlist)
;

create index segment
	on playlist_segments (segment)
;

create table program
(
	id int auto_increment
		primary key,
	name varchar(255) not null,
	genres int null,
	active tinyint(1) null
)
;

alter table episode
	add constraint episode_ibfk_2
		foreign key (program) references c9.program (id)
;

create table segment
(
	id int auto_increment
		primary key,
	station_id tinyint(1) null,
	ad_number int null,
	name varchar(255) null,
	album varchar(255) null,
	author varchar(255) null,
	approx_duration_mins int null,
	start_time datetime null,
	category int null,
	can_con tinyint(1) null,
	new_release tinyint(1) null,
	french_vocal_music tinyint(1) null,
	constraint segment_ibfk_1
		foreign key (category) references c9.category (id)
)
;

create index category
	on segment (category)
;

alter table playlist_segments
	add constraint playlist_segment_fk
		foreign key (segment) references c9.segment (id)
			on delete cascade
;

create table user
(
	id int auto_increment
		primary key,
	username text not null,
	program int null,
	encryptedpw text not null
)
;
