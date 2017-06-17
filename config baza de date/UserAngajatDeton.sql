SET SERVEROUTPUT ON;

drop table parole;
/
create table parole(parola varchar2(30));
/
insert into parole(parola) values('aroma');
insert into parole(parola) values('tandafir');
insert into parole(parola) values('calimara');
insert into parole(parola) values('sticla');
insert into parole(parola)values('papadie');
insert into parole(parola) values('amurg');
insert into parole(parola) values('alint');
insert into parole(parola) values('brad');
insert into parole(parola) values('artar');
insert into parole(parola) values('dragon');
insert into parole(parola) values('flacara');
insert into parole(parola) values('sistem');
insert into parole(parola) values('adiere');
insert into parole(parola) values('labirint');
insert into parole(parola) values('catifea');
insert into parole(parola) values('sarpe');
insert into parole(parola) values('basma');
insert into parole(parola)values('margele');
insert into parole(parola) values('rasarit');
insert into parole(parola) values('soare');
insert into parole(parola) values('noapte');
insert into parole(parola) values('boboc');
insert into parole(parola) values('balta');
insert into parole(parola) values('musca');
insert into parole(parola) values('raport');
insert into parole(parola) values('zambet');

--select * from parole;
/
drop table utilizatoriDeton;
/
create table utilizatoriDeton( 
ID integer,
nume varchar2(25) not null,
prenume varchar2(25) not null,
username varchar2(25) not null unique,
password varchar2(25) not null,
tip varchar2(25) not null,
id_institutie integer,
primary key (ID)
);

/
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(1, 'Popescu', 'Roxana','roxana.popescu', 'american', 'admin',1);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(2, 'Mazur', 'Stefana', 'stefana.mazur', 'floare', 'admin',2);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(3, 'Dragomirescu', 'Ionut', 'ionut.dragomirescu', 'copac', 'admin',3);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(4, 'Patrichi', 'Victor', 'victor.patrichi', 'dream', 'admin',4);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(5, 'Ion', 'Ion', 'ion.ion', 'urzica', 'admin',5);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(6, 'Apetroaiei', 'Bogdan', 'bogdan.apetroaiei', 'cazan', 'admin',6);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(7, 'Patrulescu', 'Alina', 'alina.patrulescu', 'inima', 'admin',7);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(8, 'Mardare', 'Ionela', 'ionela.mardare', 'uragan', 'admin', 8);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(9, 'Tiuca', 'Sebastian', 'sebastian.tiuca', 'razim', 'admin',9);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(10, 'Tataru', 'Madalina',  'madalina.tataru', 'ghinda', 'admin',10);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(11, 'Liteanu', 'Claudia', 'claudia.liteanu', 'medicament', 'admin', 11);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(12, 'Lazariuc', 'Camelia', 'camelia.lazariuc', 'mandarina', 'admin', 12);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(13, 'Popescu', 'Camelia', 'camelia.popescu', 'mandarina', 'admin', 13);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(14, 'Popescu', 'Alina','alina.popescu', 'visare', 'admin',14);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(15, 'Mazga', 'Stefana', 'stefana.mazga', 'gheata', 'admin',15);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(16, 'Dragomirescu', 'Bogdan', 'bogdan.dragomirescu', 'capcana', 'admin',16);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(17, 'Patrichi', 'Valentin', 'valentin.patrichi', 'visator', 'admin',17);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(18, 'Simion', 'Ion', 'ion.simion', 'urzica', 'admin',18);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(19, 'Apetroaiei', 'Paula', 'paula.apetroaiei', 'cazarma', 'admin',19);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(20, 'Patrulescu', 'Florina', 'florina.patrulescu', 'iasomie', 'admin',20);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(21, 'Mardare', 'Iulian', 'iulian.mardare', 'urzica', 'admin', 21);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(22, 'Pan', 'Sebastian', 'sebastian.pan', 'rachita', 'admin',22);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(23, 'Taru', 'Madalina',  'madalina.taru', 'ghimbir', 'admin',23);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(24, 'Liteanu', 'Cosmin', 'cosmin.liteanu', 'magie', 'admin', 24);
 insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) values(25, 'Lazariuc', 'Amalia', 'amalia.lazariuc', 'curcubeu', 'admin', 25);
/

drop sequence seq_secretareDeton;
/
CREATE SEQUENCE seq_secretareDeton
  START WITH 26
  INCREMENT BY 1
  CACHE 51;
  
/
DECLARE
type username IS VARRAY(1000) OF VARCHAR2(255);
type nume IS VARRAY(1000) OF VARCHAR2(255);
type prenume IS VARRAY(1000) OF VARCHAR2(255);
v_utilizator  username;
v_nume nume;
v_prenume prenume;
v_parola varchar2(30);
v_count integer;
BEGIN
FOR i IN 1..25
LOOP
SELECT SUBSTR(name,INSTR(name,' '),length(name)), SUBSTR(name,0,INSTR(name,' ')), trim(lower(SUBSTR(name,0,INSTR(name,' '))))||'.'||trim(lower(SUBSTR(name,INSTR(name,' '),length(name)))) BULK COLLECT INTO v_nume, v_prenume, v_utilizator from users where user_role like 'user' order by id asc;

SELECT parola into v_parola FROM
( SELECT parola FROM parole
ORDER BY dbms_random.value )
WHERE rownum = 1;

insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) VALUES(seq_secretareDeton.nextval, v_nume(i), v_prenume(i),v_utilizator(i), v_parola, 'secretara',i);
END LOOP;
END;
/
drop sequence seq_jandarmiDeton;
/
CREATE SEQUENCE seq_jandarmiDeton
  START WITH 51
  INCREMENT BY 1
  CACHE 251;
  
/
DECLARE
type username IS VARRAY(1000) OF VARCHAR2(255);
type nume IS VARRAY(1000) OF VARCHAR2(255);
type prenume IS VARRAY(1000) OF VARCHAR2(255);
v_utilizator  username;
v_nume nume;
v_prenume prenume;
v_parola varchar2(30);
v_count integer;
v_id_institutie integer;
BEGIN
FOR i IN 151..351
LOOP
SELECT SUBSTR(name,INSTR(name,' '),length(name)), SUBSTR(name,0,INSTR(name,' ')), trim(lower(SUBSTR(name,0,INSTR(name,' '))))||'.'||trim(lower(SUBSTR(name,INSTR(name,' '),length(name)))) BULK COLLECT INTO v_nume, v_prenume, v_utilizator from users where user_role like 'user' order by id desc;

SELECT parola into v_parola FROM
( SELECT parola FROM parole
ORDER BY dbms_random.value )
WHERE rownum = 1;

v_id_institutie := dbms_random.value(1,25);

insert into utilizatoriDeton(ID, nume, prenume, username, password, tip, id_institutie) VALUES(seq_jandarmiDeton.nextval, v_nume(i), v_prenume(i),v_utilizator(i), v_parola, 'jandarm', v_id_institutie);
END LOOP;
END;
/

--select* from utilizatoriDeton;