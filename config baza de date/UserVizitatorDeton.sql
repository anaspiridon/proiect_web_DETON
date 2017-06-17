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
drop table userVizitatorDeton;
/
create table userVizitatorDeton( 
ID integer,
id_vizitator integer,
nume varchar2(25) not null,
prenume varchar2(25) not null,
username varchar2(100) not null unique,
password varchar2(50) not null,
tip varchar2(25) not null,
primary key (ID)
);

/
drop sequence seq_vizitatoriDeton;
/
CREATE SEQUENCE seq_vizitatoriDeton
  START WITH 1
  INCREMENT BY 1
  CACHE 100;
  
/  
DECLARE
type username IS VARRAY(1000) OF VARCHAR2(255);
type nume IS VARRAY(1000) OF VARCHAR2(255);
type prenume IS VARRAY(1000) OF VARCHAR2(255);
type id_vizitator IS VARRAY(1000) OF NUMBER;
v_utilizator  username;
v_nume nume;
v_prenume prenume;
v_id_vizitator id_vizitator;
v_parola varchar2(30);
v_count integer;


BEGIN
for i in 1..100
loop
select nume, prenume, trim(lower(prenume))||'.'||trim(lower(nume)), id_vizitator BULK COLLECT INTO v_nume, v_prenume, v_utilizator, v_id_vizitator from vizitatori;

SELECT parola into v_parola FROM
( SELECT parola FROM parole
ORDER BY dbms_random.value )
WHERE rownum = 1;

insert into userVizitatorDeton(ID,id_vizitator, nume, prenume, username, password, tip) VALUES(seq_vizitatoriDeton.nextval,v_id_vizitator(i), v_nume(i), v_prenume(i),v_utilizator(i), v_parola, 'vizitator');
END LOOP;
END;
/
--select * from vizitatori;
--select * from userVizitatorDeton;