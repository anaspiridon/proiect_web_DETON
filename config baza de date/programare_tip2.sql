
drop table programare_vizita_tip2 cascade constraints;
/
CREATE  TABLE programare_vizita_tip2( id_programare2 integer not null,
                                      id_detinut not null,
                                      id_institutie integer not null,
                                      nume varchar2(25) not null,
                                      prenume varchar2(25) not null,
                                      email varchar2(50),
                                      telefon integer not null,
                                      data_programarii varchar2(45) not null,
                                      ora varchar2(15)not null,                 
                                      PRIMARY KEY(id_programare2),
                                      FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
                                      
);
/
drop table ore_vizita2; 
CREATE TABLE ore_vizita2 (id_ora integer not null,ora varchar2(35) not NULL, primary key(id_ora));
INSERT INTO ore_vizita2(id_ora, ora) VALUES (1,'12:00-12:30');
INSERT INTO ore_vizita2(id_ora, ora) VALUES (2,'12:30-13:00');
INSERT INTO ore_vizita2(id_ora, ora) VALUES (3,'13:00-13:30');
INSERT INTO ore_vizita2(id_ora, ora) VALUES (4,'13:30-14:00');
INSERT INTO ore_vizita2(id_ora, ora) VALUES (5,'14:00-14:30');
INSERT INTO ore_vizita2 (id_ora, ora)VALUES (6,'14:30-15:00');
INSERT INTO ore_vizita2 (id_ora, ora) VALUES (7,'15:00-15:30');
INSERT INTO ore_vizita2 (id_ora, ora) VALUES (8,'15:30-16:00');
select * FROM ore_vizita2;
/
CREATE OR REPLACE FUNCTION verif_data_tip2 (p_data varchar, p_id_detinut integer ) RETURN number as

 CURSOR lista_programari IS
 SELECT data_programarii FROM programare_vizita_tip2 WHERE id_detinut=p_id_detinut;

v_day number;
BEGIN
select TO_NUMBER(to_char (TO_DATE(p_data,'DD-MM-YYYY'), 'D'),99) INTO v_day  FROM DUAL;
    IF ((v_day!=2 AND v_day!=4) OR (v_day!=4 AND v_day!=2) ) THEN
      RETURN 0;
        ELSIF (v_day=2 OR v_day=4) THEN
         DBMS_OUTPUT.PUT_LINE(v_day||'in elsif'); 
          FOR linie_programari IN lista_programari LOOP
            IF (linie_programari.data_programarii=p_data) THEN
              DBMS_OUTPUT.PUT_LINE('Ziua solicitata este deja prgramata!');
                RETURN 2;
             END IF;
                END LOOP;
                RETURN 9;
         ELSE RETURN 9; 
      END IF;

END verif_data_tip2;
/
set serveroutput on;
DECLARE
v_rez number;
BEGIN

v_rez:=verif_data_tip2 ('29-06-17', 316);
 DBMS_OUTPUT.PUT_LINE(v_rez);

END;
/
SELECT * FROM programare_vizita_tip2 WHERE data_programarii='23/June/17'
 DROP SEQUENCE id_program2;
/
 CREATE SEQUENCE id_program2
  START WITH 500
  INCREMENT BY 1
  CACHE 700;
 CREATE SEQUENCE seq_vizita
  START WITH 1
  INCREMENT BY 1
  CACHE 10000;  
/

DECLARE
 v_detinut INTEGER;
  v_vizitator INTEGER;
  v_martor INTEGER;
  v_id_vizitator number;
  v_id_institutie number;
  v_stare_sanatate CLOB;
  v_stare_spirit CLOB;
  v_rezumat CLOB;
  v_id_program2 number;
  
  v_count_detinut INTEGER :=0;
  v_count_vizitator INTEGER :=0;
  v_count_martor INTEGER :=0;
  
  v_count_stare_sanatate INTEGER:=0;
  v_count_stare_spirit INTEGER :=0;
  v_count_rezumat INTEGER :=0;
  
  v_random_detinut INTEGER;
  v_random_vizitator INTEGER;
  v_random_martor INTEGER;
  v_random_stare_sanatate INTEGER;
  v_random_stare_spirit INTEGER;
  v_random_rezumat INTEGER;
count_detinuti number;
count_vizitatori number;
count_ora number;
v_nume varchar2(85);
v_prenume varchar2(85);
v_telefon number;
v_email varchar2(87);
v_data date;
v_id number;
random_detinuti number;
random_vizitatori number;
random_ora number;
v_rez number;
v_convert varchar2(20);
v_ora varchar2(20);
v_start_pedeapsa date;
v_serie varchar2(2);
v_nr_buletin number;
v_verif number;
v_poza varchar2(500);
v_id_relatie integer;
v_obiecte varchar2(500);

BEGIN
select COUNT(*) INTO count_detinuti FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
WHERE i.id_tip_institutie=112;

SELECT COUNT(*) INTO count_vizitatori FROM vizitatori;
SELECT COUNT(*) INTO count_ora FROM ore_vizita2;

  FOR i IN 1..200 LOOP
    random_detinuti := trunc(dbms_random.value(1,count_detinuti+1));
    random_vizitatori := trunc(dbms_random.value(1,count_vizitatori+1));
    random_ora := trunc(dbms_random.value(1,count_ora+1));
   
     SELECT * into v_id, v_start_pedeapsa, v_id_institutie FROM
      ( select d.id_detinut, d.start_pedeapsa, i.id_institutie  FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
        WHERE i.id_tip_institutie=112
        ORDER BY dbms_random.value )
        WHERE rownum = 1; 
      
  SELECT * into v_nume, v_prenume, v_id_vizitator FROM 
    (SELECT * FROM (SELECT nume, prenume, id_vizitator from vizitatori
    WHERE ROWNUM <= random_vizitatori ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
    
  SELECT * into v_ora FROM 
    (SELECT * FROM (SELECT ora from ore_vizita2
    WHERE ROWNUM <= random_ora ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  
  v_email:=TRIM(LOWER(v_prenume))||'.'||TRIM(LOWER(v_nume))||'@gmail.com';
  v_telefon:=0754321765;
--  v_data:=TO_DATE(TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(DATE '01-01-2016','J'),TO_CHAR(DATE '15-03-2017','J'))),'J');
  
--select to_date(v_start_pedeapsa, 'dd-mm-yyyy')+dbms_random.value(1,1000)into v_data from dual;  
SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_pedeapsa ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_data FROM DUAL; 
SELECT TO_CHAR(v_data,'dd-mm-yyyy') INTO v_convert FROM dual;
v_rez:=verif_data_tip2 (v_convert, v_id );

  IF (v_rez=2  OR v_rez=0) THEN
    LOOP
    SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_pedeapsa ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_data FROM DUAL;   
    SELECT TO_CHAR(v_data,'dd-mm-yyyy') INTO v_convert FROM dual;
    v_rez:=verif_data_tip2 (v_convert, v_id );
    EXIT WHEN v_rez=1;
    END LOOP;
   END IF; 
    
--  ELSIF (v_rez = 2) THEN
--    LOOP
--    select to_date('01-01-2015', 'dd-mm-yyyy')+dbms_random.value(1,1000)into v_data from dual;  
--    SELECT TO_CHAR(v_data,'dd-mm-yyyy') INTO v_convert FROM dual;
--    v_rez:=verif_data_tip2 (v_convert, v_id );
--    EXIT WHEN v_rez=1;
--    END LOOP;
  
 v_id_program2:=id_program2.nextval; 
  
  INSERT INTO  programare_vizita_tip2 VALUES (v_id_program2,
                                              v_id,
                                              v_id_institutie,
                                              v_nume,
                                              v_prenume,
                                              v_email,
                                              v_telefon,
                                              v_data,
                                              v_ora
                                      
  );


    IF (v_data < sysdate) THEN
 -- stocam cati id_detinut, id_vizitator, id_martor avem in v_count_detinut, v_count_vizitator, v_count_martor
    SELECT COUNT(id_detinut) INTO v_count_detinut FROM detinuti;
    SELECT COUNT(id_vizitator) INTO v_count_vizitator FROM vizitatori;
    SELECT COUNT(id_martor) INTO v_count_martor FROM martori;

-- de asemenea stocam ca mai sus cate stari de spirit, sanatate si rezumate avem       
    SELECT COUNT(TO_CHAR(stare_sanatate)) INTO v_count_stare_sanatate FROM stare1;
    SELECT COUNT(TO_CHAR(stare_spirit)) INTO v_count_stare_spirit FROM stare2;
    SELECT COUNT(TO_CHAR(text)) INTO v_count_rezumat FROM rezumat;  
  
       v_random_detinut := trunc(dbms_random.value(1,v_count_detinut+1));  
  
   v_random_vizitator := trunc(dbms_random.value(1,v_count_vizitator+1)); 
   v_random_martor := trunc(dbms_random.value(1,v_count_martor+1)); 
   
    v_random_stare_sanatate := trunc(dbms_random.value(1,v_count_stare_sanatate+1));  
    v_random_stare_spirit := trunc(dbms_random.value(1,v_count_stare_spirit+1)); 
    v_random_rezumat := trunc(dbms_random.value(1,v_count_rezumat+1)); 
  
  -- selectam atribut care se afla la linia egala cu nr random generat si il stocam intr-o variabila ca sa il inseram in tabel  
 
  SELECT * INTO v_martor FROM (SELECT id_martor FROM martori  WHERE ROWNUM <= v_random_martor ORDER BY ROWNUM DESC) WHERE ROWNUM < 2; 
  
  SELECT * INTO v_stare_sanatate FROM (SELECT * FROM(SELECT stare_sanatate FROM stare1  WHERE ROWNUM <= v_random_stare_sanatate ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  SELECT * INTO v_stare_spirit FROM (SELECT * FROM(SELECT stare_spirit FROM stare2  WHERE ROWNUM <= v_random_stare_spirit ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  SELECT * INTO v_rezumat FROM (SELECT *FROM(SELECT text FROM rezumat  WHERE ROWNUM <= v_random_rezumat ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  SELECT * into v_obiecte FROM
      ( select obiect from obiecte
      ORDER BY dbms_random.value )
      WHERE rownum = 1; 

  SELECT * into v_id_relatie FROM
      ( select id_relatie from relatie WHERE id_relatie>=3 AND id_relatie<=5
      ORDER BY dbms_random.value )
      WHERE rownum = 1;



    INSERT INTO vizita ( id_vizita , 
                        id_detinut ,
                        id_vizitator ,
                        id_programare,
                        id_martor ,
                        id_institutie,
                        id_relatie,
                        stare_sanatate, 
                        stare_spirit,
                        rezumat,
                        obiecte
                        ) 
    values(seq_vizita.nextval, 
    v_id,
    v_id_vizitator,
    v_id_program2,
    v_martor,
    v_id_institutie,
    v_id_relatie,
    v_stare_sanatate,
    v_stare_spirit,
    v_rezumat,
    v_obiecte

   );
  
  
  
  
  
  
  END IF;

      

END LOOP;
END;
/


select * FROM vizita;








SELECT * FROM TIP_INSTITUTIE WHERE ID_TIP_INSTITUTIE=320;

SELECT data_programarii FROM programare_vizita_tip2 WHERE id_detinut=320;
select * FROm institutie;
select i.id_tip_institutie, i.capacitate, i.id_institutie, d.id_detinut FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
WHERE i.id_tip_institutie=112;


INSERT INTO programare_vizita_tip2 VALUES (1,320,'Matei','Ion','mate.ion@gmail.com',075357483,
TO_DATE('01-06-2017','DD-MM-YYYY'),'12:00');


INSERT INTO programare_vizita_tip1 VALUES (2,320,21,'Matei','Ion','mate.ion@gmail.com',
TO_DATE('06-06-2017','DD-MM-YYYY'),'12:00');

select TO_NUMBER(to_char (date '2017-06-01', 'D'),99)  FROM DUAL;
SELECT TO_DATE('01-06-2017', 'DD-MM-YYYY') FROM DUAL;


select TO_NUMBER(to_char (TO_DATE('01-06-2017','DD-MM-YYYY'), 'D'),99)   FROM DUAL;

select to_date('2010-01-01', 'yyyy-mm-dd')+dbms_random.value(1,1000) from dual;
SELECT * from programare_vizita_tip2;


SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(DATE '2000-12-31' ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' )  FROM DUAL;
                                    
                                    
SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_programare ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_programare FROM DUAL; 
                                    
select * from detinuti;

select * FROM institutie;
SELECT * FROM detinuti d JOIN institutie i ON i.id_institutie=d.id_institutie 
JOIN userDetinutDeton u ON u.id_detinut=d.id_detinut
WHERE TRIM(u.username)=TRIM('vladut.cazacu')AND TRIM(i.nume_institutie)=TRIM('Scoala de corectie Iasi');

SELECT id_institutie FROM institutie where TRIM(nume_institutie)=TRIM('Scoala de corectie Iasi');
SELECT id_detinut FROM userDetinutDeton WHERE TRIM(username)=TRIM('vladut.cazacu');

SELECT * FROM (SELECT ID_PROGRAMARE2 FROM PROGRAMARE_VIZITA_TIP2  WHERE ROWNUM <= (select count(*) from PROGRAMARE_VIZITA_TIP2 ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2;


SELECT * FROM vizita;
SELECT * FROM (SELECT ID_PROGRAMARE2 FROM PROGRAMARE_VIZITA_TIP2  WHERE ROWNUM <= (select count(*) from PROGRAMARE_VIZITA_TIP2 ) ORDER BY ROWNUM DESC) WHERE ROWNUM < 2

INSERT INTO programare_vizita_tip3 VALUES (5000, 320,3, 'ddd','ddd','asdasd',99333,'01-07-2017','asas');
INSERT INTO programare_vizita_tip2 VALUES (5001, 330,4, 'ddd','ddd','asdasd',99333,'01/June/17','asas');
INSERT INTO programare_vizita_tip2 VALUES (5015, 330,4, 'ddd','ddd','asdasd',99333,'10/June/17','asas');



select * from programare_vizita_tip2;
select * FROM vizitatori;SELECT * FROM programare_vizita_tip2 WHERE id_detinut=330;

DELETE FROM programare_vizita_tip2 WHERE data_programarii IN ('10/June/17','10/June/17')
SELECT data_programarii, id_programare2 FROM programare_vizita_tip2

/
drop table programare_vizita_validata cascade constraints;
CREATE  TABLE programare_vizita_validata( id_programare integer not null,
                                      id_detinut integer not null,
                                      id_institutie integer not null,
                                      nume varchar2(25) not null,
                                      prenume varchar2(25) not null,
                                      email varchar2(50),
                                      telefon integer not null,
                                      data_programarii varchar2(45) not null,
                                      ora varchar2(15)not null,
                                      time_stamp timestamp not null
--                                      PRIMARY KEY(id_programare),
--                                      FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
                                      
);

 INSERT INTO programare_vizita_validata( id_programare ,id_detinut ,id_institutie , nume ,prenume ,email ,telefon  ,data_programarii ,ora,time_stamp ) 
 VALUES (5000, 320,3, 'ddd','ddd','asdasd',99333,'01/June/17','asas', SUBSTR(systimestamp,0,INSTR(systimestamp,',')-1));
 
 SELECT * FROM programare_vizita_validata;
 SELECT ID_PROGRAMARE2, ID_DETINUT, ID_INSTITUTIE,NUME,PRENUME,EMAIL,TELEFON,DATA_PROGRAMARII,ORA, systimestamp 
 FROM programare_vizita_tip2 WHERE id_programare2 IN ($check) ";
 
 SELECT ID_PROGRAMARE2, ID_DETINUT, ID_INSTITUTIE,NUME,PRENUME,EMAIL,TELEFON,DATA_PROGRAMARII,ORA,  
 FROM programare_vizita_tip2 WHERE id_programare2 IN (5000,5001); 
           
select * FROM programare_vizita_validata;   


SELECT TELEFON FROM programare_vizita_tip2 WHERE ID_PROGRAMARE2=5001;
UPDATE programare_vizita_tip2 SET TELEFON=0040753582216;

SELECT TELEFON, ORA,DATA_PROGRAMARII FROM programare_vizita_tip2;
select to_char(timestampColumnName,'DD-MON-YY HH24:MI:SS') "Date" from dual;
select  SUBSTR(systimestamp,0,INSTR(systimestamp,',')-1) from dual;
select systimestamp from dual;


SELECT data_programarii, ID_PROGRAMARE2, Ora, NUME, PRENUME, ORA FROM programare_vizita_tip2 WHERE id_detinut=320;
SELECT *  FROM programare_vizita_tip2 WHERE id_detinut=320;
  
SELECT NUME, PRENUME, DATA_PROGRAMARII, ORA, TIME_STAMP FROM programare_vizita_validata ORDER BY TIME_STAMP DESC;   

SELECT data_programarii, ID_PROGRAMARE2, NUME, PRENUME, ORA FROM programare_vizita_tip2 WHERE TRIM(NUME)='Iacob'

SELECT * FROM(SELECT SUBSTR(TIME_STAMP,0,INSTR(TIME_STAMP,',')-1) "TIME_STAMP" FROM programare_vizita_validata ORDER BY TIME_STAMP DESC ) WHERE ROWNUM=1;

SELECT * FROM programare_vizita_tip3;

SELECT COUNT(*) FROM programare_vizita_tip4;

UPDATE FROM programare_vizita_tip2 WHERE TELEFON=

SELECT TELEFON, ORA, DATA_PROGRAMARII FROM programare_vizita_tip2 WHERE

SELECT * FROM programare_vizita_tip2 WHERE id_detinut=316
SELECT TELEFON, ORA,DATA_PROGRAMARII FROM programare_vizita_tip2 WHERE id_programare2=881;
select TO_DATE('30/June/17','dd-mm-yyyy') FROM dual;
select  sysdate from dual
select * from programare where TO_CHAR(TO_DATE(CAST('01-APR-1999' AS VARCHAR(15)),'DD-MON-YY'),'MM/DD/YYYY')<=sysdate
SELECT CAST('01-APR-1999' AS VARCHAR(15))  from dual
SELECT * FROM RELATII_MAXSECURITATE WHERE TRIM(ID_DETINUT)=1797 AND TRIM(SERIE)= AND TRIM(NR)=
SELECT * FROM RELATII_MAXSECURITATE WHERE TRIM(ID_DETINUT)=TRIM(:bind) AND TRIM(SERIE)=TRIM(:bind1) AND TRIM(NR)=TRIM(:bind2)

select * from institutie
select * from detinuti

select * from institutie i join detinuti d on i.id_institutie=d.id_institutie


SELECT * FROM userDetinutDeton where trim(prenume)='Robert'

SELECT * FROM userDetinutDeton WHERE TRIM(username)=TRIM(:bind1)

select id_detinut from userdetinutDeton u join 

select to_char(data_programarii,'DD-MM-YYYY') FROM programare_vizita_validata 
WHERE  to_char(data_programarii,'DD-MM-YYYY')= TO_CHAR('18-02-2016','DD-MM-YYYY'); and ora=trim(:bind2); 

select * from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1

select* from programare_vizita_validata WHERE  TO_CHAR(TO_DATE(CAST('data_programarii' AS VARCHAR(15)),'DD-MM-YYYY'),'DD-MM_YYYY')= '18-02-2016' and ora=trim(:bind2);

SELECT count(*) from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1 WHERE to_char(p.data_programarii,'YYYY-MM-DD')= trim(:bind1)

SELECT * FROM(select SUBSTR(time_stamp,INSTR(time_stamp,',')) FROM programare_vizita_validata ORDER BY time_stamp DESC) WHERE ROWNUM <=1 ; 


select NUME, PRENUME, DATA_PROGRAMARII, ORA from programare_vizita_validata WHERE  to_char(data_programarii,'YYYY-MM-DD')> TO_CHAR(date '2017-05-16','YY-MON-DD')

select TO_CHAR(date '2017-05-16','YYYY-MM-DD') from dual

select MAX(time_stamp) from programare_vizita_validata


select NUME, PRENUME, DATA_PROGRAMARII, ORA from programare_vizita_validata WHERE id_detinut=816



