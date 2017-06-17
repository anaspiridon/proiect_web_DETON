
drop table programare_vizita_tip2 cascade constraints;
/
CREATE  TABLE programare_vizita_tip2( id_programare2 integer not null,
                                      id_detinut not null,
                                      id_institutie integer not null,
                                      nume varchar2(25) not null,
                                      prenume varchar2(25) not null,
                                      email varchar2(50),
                                      telefon integer not null,
                                      data_programarii date not null,
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
                RETURN 1;
         ELSE RETURN 1; 
      END IF;

END verif_data_tip2;
/
--set serveroutput on;
--DECLARE
--v_rez number;
--BEGIN
--
--v_rez:=verif_data_tip2 ('01-06-2017', 320 );
-- DBMS_OUTPUT.PUT_LINE(v_rez);
--
--END;
 -- DROP SEQUENCE programare_vizita_tip2;

  CREATE SEQUENCE seq_programare_tip2
  START WITH 1
  INCREMENT BY 1
  CACHE 100;
  /
--  CREATE SEQUENCE seq_vizita
--  START WITH 1
--  INCREMENT BY 1
--  CACHE 10000;  
  
  DECLARE
v_id_detinut integer;
v_nume  varchar2(35);
v_prenume  varchar2(35);
v_count integer;
v_email varchar2(35);
v_start_programare date;
v_programare date;
v_ora varchar2(35);
v_id_vizitator integer;
v_id_martor integer;
v_id_institutie integer;
v_id_relatie integer;
v_obiecte varchar2(500);
v_rezumat varchar2(500);
v_stare_sanatate varchar2(500);
v_stare_spirit varchar2(500);
v_data varchar2(50);
v_nr_inserari integer;
v_telefon number;

BEGIN
 SELECT COUNT(id) INTO v_count FROM users;
 
   --<<LOOP>>
  --FOR i IN 1..100 
  LOOP

SELECT id_detinut, start_pedeapsa, id_institutie into v_id_detinut, v_start_programare, v_id_institutie FROM
( SELECT d.id_detinut, d.start_pedeapsa, d.id_institutie FROM detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=112
ORDER BY dbms_random.value )
WHERE rownum = 1;

 SELECT nume, prenume, (trim(lower(prenume))||'.'||trim(lower(nume)))||'@email.com', id_vizitator, id_relatie into v_nume, v_prenume,  v_email, v_id_vizitator, v_id_relatie FROM
( SELECT nume, prenume, id_vizitator, id_relatie FROM vizitatori
ORDER BY dbms_random.value )
WHERE rownum = 1;
        
        SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_programare ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_programare FROM DUAL;


 
 SELECT ora into v_ora FROM
( SELECT ora FROM ore_vizita2
ORDER BY dbms_random.value )
WHERE rownum = 1;


 SELECT id_martor into v_id_martor FROM
( SELECT id_martor FROM martori
ORDER BY dbms_random.value )
WHERE rownum = 1;

  SELECT * into v_obiecte FROM
      ( select obiect from obiecte
      ORDER BY dbms_random.value )
      WHERE rownum = 1; 

 SELECT * into v_rezumat FROM
      ( select text from rezumat
      ORDER BY dbms_random.value )
      WHERE rownum = 1; 

 SELECT * into v_stare_sanatate FROM
      ( select stare_sanatate from stare1
      ORDER BY dbms_random.value )
      WHERE rownum = 1; 
      
   SELECT * into v_stare_spirit FROM
      ( select stare_spirit from stare2
      ORDER BY dbms_random.value )
      WHERE rownum = 1;     

  v_telefon:=0754321765;

  v_data := to_char(v_programare, 'DD-Mon-YYYY');

if (verif_data_tip2(v_data,v_id_detinut))=1 then
insert into programare_vizita_tip2( id_programare2,
                                      id_detinut,
                                      id_institutie,
                                      nume,
                                      prenume,
                                      email,
                                      telefon,
                                      data_programarii,
                                      ora)
                                    values (seq_programare_tip2.nextval,
                                              v_id_detinut,
                                              v_id_institutie,
                                              v_nume,
                                              v_prenume,
                                              v_email,
                                              v_telefon,
                                              v_programare,
                                              v_ora
                                              );

    select count(*) into v_nr_inserari from programare_vizita_tip2;

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
                        obiecte) 
                        values(seq_vizita.nextval, 
                                  v_id_detinut,
                                  v_id_vizitator,
                                  seq_programare_tip2.nextval,
                                  v_id_martor,
                                  v_id_institutie,
                                  v_id_relatie,
                                  v_stare_sanatate,
                                  v_stare_spirit,
                                  v_rezumat,
                                  v_obiecte
                                   );

--else
--goto LOOP;
end if;
EXIT WHEN v_nr_inserari=100;
END LOOP;
END;

select * from programare_vizita_tip2;
