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
drop table userDetinutDeton;
/
create table userDetinutDeton( 
ID integer,
id_detinut integer,
nume varchar2(25) not null,
prenume varchar2(25) not null,
username varchar2(100) not null unique,
password varchar2(25) not null,
tip varchar2(25) not null,
id_institutie integer,
primary key (ID),
 FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
);

drop sequence seq_detinutiDeton;
/
CREATE SEQUENCE seq_detinutiDeton
  START WITH 1
  INCREMENT BY 1
  CACHE 1311;

/
set serveroutput on;
DECLARE

v_parola varchar2(30);


CURSOR lista_detinuti  IS
       SELECT * from detinuti ;
   v_std_linie lista_detinuti%ROWTYPE; 

BEGIN
 OPEN lista_detinuti;
    LOOP
        FETCH lista_detinuti INTO v_std_linie;
        EXIT WHEN lista_detinuti%NOTFOUND;
        

SELECT parola into v_parola FROM
( SELECT parola FROM parole
ORDER BY dbms_random.value )
WHERE rownum = 1;

DBMS_OUTPUT.PUT_LINE(v_std_linie.nume);
  insert into userDetinutDeton(ID,id_detinut, nume, prenume, username, password, tip, id_institutie) VALUES(seq_detinutiDeton.nextval, v_std_linie.id_detinut, v_std_linie.nume, v_std_linie.prenume,(trim(lower(v_std_linie.prenume))||'.'||trim(lower(v_std_linie.nume))), v_parola, 'detinut', v_std_linie.id_institutie);


    END LOOP;
    CLOSE lista_detinuti; 
END;
/
--select * from detinuti;
--
--select * from userDetinutDeton;
