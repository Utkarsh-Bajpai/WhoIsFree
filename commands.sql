create table passwords(
acmadmin varchar(60),
acmuser varchar(60),
pravegaadmin varchar(60),
pravegauser varchar(60)
);
create table timetable(regno varchar(10) not null,name varchar(30) not null,role varchar(30),contactno varchar(15), a100 tinyint(1) not null, a101 tinyint(1) not null, a102 tinyint(1) not null, a103 tinyint(1) not null, a104 tinyint(1) not null, a105 tinyint(1) not null, a106 tinyint(1) not null, a107 tinyint(1) not null, a108 tinyint(1) not null, a109 tinyint(1) not null, a110 tinyint(1) not null, a111 tinyint(1) not null,
     a200 tinyint(1) not null,a201 tinyint(1) not null,a202 tinyint(1) not null,a203 tinyint(1) not null,a204 tinyint(1) not null,a205 tinyint(1) not null,a206 tinyint(1) not null,a207 tinyint(1) not null,a208 tinyint(1) not null,a209 tinyint(1) not null,a210 tinyint(1) not null,a211 tinyint(1) not null,
     a300 tinyint(1) not null,a301 tinyint(1) not null,a302 tinyint(1) not null,a303 tinyint(1) not null,a304 tinyint(1) not null,a305 tinyint(1) not null,a306 tinyint(1) not null,a307 tinyint(1) not null,a308 tinyint(1) not null,
     a400 tinyint(1) not null,a401 tinyint(1) not null,a402 tinyint(1) not null,a403 tinyint(1) not null,a404 tinyint(1) not null,a405 tinyint(1) not null,a406 tinyint(1) not null,a407 tinyint(1) not null,a408 tinyint(1) not null,a409 tinyint(1) not null,a410 tinyint(1) not null,a411 tinyint(1) not null,
     a500 tinyint(1) not null,a501 tinyint(1) not null,a502 tinyint(1) not null,a503 tinyint(1) not null,a504 tinyint(1) not null,a505 tinyint(1) not null,a506 tinyint(1) not null,a507 tinyint(1) not null,a508 tinyint(1) not null,a509 tinyint(1) not null,a510 tinyint(1) not null,a511 tinyint(1) not null,
     acadload int,a309 tinyint(1) default 0,primary key(regno));

create table notices(id int not null auto_increment, name varchar(20), notice text, primary key(id));

create table bugs(id int not null auto_increment,email varchar(50) not null, message text not null,primary key(id));

create table images (
    image_id        tinyint(3)  not null default '0',
    image_type      varchar(25) not null default '',
    image           blob        not null,
    image_size      varchar(25) not null default '',
    image_ctgy      varchar(25) not null default '',
    image_name      varchar(50) not null default ''
);


create table pravega_timetable(regno varchar(10) not null,name varchar(30) not null,role varchar(30),contactno varchar(15), a100 tinyint(1) not null, a101 tinyint(1) not null, a102 tinyint(1) not null, a103 tinyint(1) not null, a104 tinyint(1) not null, a105 tinyint(1) not null, a106 tinyint(1) not null, a107 tinyint(1) not null, a108 tinyint(1) not null, a109 tinyint(1) not null, a110 tinyint(1) not null, a111 tinyint(1) not null,
     a200 tinyint(1) not null,a201 tinyint(1) not null,a202 tinyint(1) not null,a203 tinyint(1) not null,a204 tinyint(1) not null,a205 tinyint(1) not null,a206 tinyint(1) not null,a207 tinyint(1) not null,a208 tinyint(1) not null,a209 tinyint(1) not null,a210 tinyint(1) not null,a211 tinyint(1) not null,
     a300 tinyint(1) not null,a301 tinyint(1) not null,a302 tinyint(1) not null,a303 tinyint(1) not null,a304 tinyint(1) not null,a305 tinyint(1) not null,a306 tinyint(1) not null,a307 tinyint(1) not null,a308 tinyint(1) not null,
     a400 tinyint(1) not null,a401 tinyint(1) not null,a402 tinyint(1) not null,a403 tinyint(1) not null,a404 tinyint(1) not null,a405 tinyint(1) not null,a406 tinyint(1) not null,a407 tinyint(1) not null,a408 tinyint(1) not null,a409 tinyint(1) not null,a410 tinyint(1) not null,a411 tinyint(1) not null,
     a500 tinyint(1) not null,a501 tinyint(1) not null,a502 tinyint(1) not null,a503 tinyint(1) not null,a504 tinyint(1) not null,a505 tinyint(1) not null,a506 tinyint(1) not null,a507 tinyint(1) not null,a508 tinyint(1) not null,a509 tinyint(1) not null,a510 tinyint(1) not null,a511 tinyint(1) not null,
     acadload int,a309 tinyint(1) default 0,primary key(regno));

create table pravega_notices(id int not null auto_increment, name varchar(20), notice text, primary key(id));

create table pravega_bugs(id int not null auto_increment,email varchar(50) not null, message text not null,primary key(id));

create table pravega_images (
    image_id        tinyint(3)  not null default '0',
    image_type      varchar(25) not null default '',
    image           blob        not null,
    image_size      varchar(25) not null default '',
    image_ctgy      varchar(25) not null default '',
    image_name      varchar(50) not null default ''
);