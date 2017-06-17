drop table programare_vizita_tip4 cascade constraints;
/
CREATE  TABLE programare_vizita_tip4( id_programare4 integer not null,
                                      id_detinut integer not null,
                                      id_institutie integer not null,
                                      nume varchar2(25) not null,
                                      prenume varchar2(25) not null,
                                      email varchar2(50) not null,
                                      telefon integer not null,
                                      seria_buletin varchar2(2) not null,
                                      nr_buletin number not null,
                                      data_programarii date not null,
                                      ora varchar2(15)not null,
                                      PRIMARY KEY(id_programare4)
--                                      FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
                                      
);

/
drop table ore_vizita4; 
CREATE TABLE ore_vizita4 (id_ora integer not null,ora varchar2(35) not NULL, primary key(id_ora));
INSERT INTO ore_vizita4(id_ora, ora) VALUES (1,'10:00-10:15');
INSERT INTO ore_vizita4(id_ora, ora) VALUES (2,'10:15-10:30');
INSERT INTO ore_vizita4(id_ora, ora) VALUES (3,'10:30-10:45');
INSERT INTO ore_vizita4(id_ora, ora) VALUES (4,'10:45-11:00');
INSERT INTO ore_vizita4 (id_ora, ora) VALUES (5,'11:00-11:15');
INSERT INTO ore_vizita4(id_ora, ora) VALUES (6,'11:15-11:30');
INSERT INTO ore_vizita4 (id_ora, ora)VALUES (7,'11:30-11:45');
INSERT INTO ore_vizita4 (id_ora, ora) VALUES (8,'11:45-12:00');
INSERT INTO ore_vizita4 (id_ora, ora) VALUES (9,'15:30-16:00');
/

CREATE OR REPLACE FUNCTION verif_buletin (p_serie varchar, p_nr number, p_id_detinut integer ) RETURN number as
v_count1 number;
v_count2 number;
v_count3 number;
BEGIN
select COUNT(*) INTO v_count1 from relatii_maxSecuritate WHERE id_detinut=p_id_detinut;
select COUNT(*) INTO v_count2 from relatii_maxSecuritate WHERE TRIM(serie)=TRIM(p_serie);
select COUNT(*) INTO v_count3 from relatii_maxSecuritate WHERE NR=p_nr;
  IF (v_count1=0) THEN 
    RETURN 0;
    ELSIF (v_count2=0) THEN 
    RETURN 2;
    ELSIF (v_count3=0) THEN 
    RETURN 3;
    ELSIF (v_count1>=1 AND v_count2>=1 AND v_count3>=1) THEN
    RETURN 1;
END IF;
END verif_buletin;

/
CREATE OR REPLACE FUNCTION verif_data_tip4 (p_data varchar, p_id_detinut integer ) RETURN number as

 CURSOR lista_programari IS
 SELECT data_programarii FROM programare_vizita_tip4 WHERE id_detinut=p_id_detinut;

v_day number;
BEGIN
select TO_NUMBER(to_char (TO_DATE(p_data,'DD-MM-YYYY'), 'D'),99) INTO v_day  FROM DUAL;
    IF ((v_day!=1 AND v_day!=7) OR (v_day!=1 AND v_day!=7) ) THEN
      RETURN 0;
        ELSIF (v_day=1 OR v_day=7) THEN
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

END verif_data_tip4;
/
--DROP SEQUENCE seq_programare_tip4;
/
  CREATE SEQUENCE seq_programare_tip4
  START WITH 1
  INCREMENT BY 1
  CACHE 100;
/

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
v_serie varchar2(2);
v_nr_buletin number;

BEGIN
 SELECT COUNT(id) INTO v_count FROM users;
 
   --<<LOOP>>
  --FOR i IN 1..100 
  LOOP

SELECT  start_pedeapsa, id_institutie into v_start_programare, v_id_institutie FROM
( SELECT d.start_pedeapsa, d.id_institutie FROM detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=114
ORDER BY dbms_random.value )
WHERE rownum = 1;

 SELECT nume, prenume, (trim(lower(prenume))||'.'||trim(lower(nume)))||'@email.com', id_vizitator into v_nume, v_prenume,  v_email, v_id_vizitator FROM
( SELECT nume, prenume, id_vizitator FROM vizitatori
ORDER BY dbms_random.value )
WHERE rownum = 1;
        
        SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_programare ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_programare FROM DUAL;


 
 SELECT ora into v_ora FROM
( SELECT ora FROM ore_vizita4
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


   SELECT * into v_serie, v_nr_buletin,  v_id_detinut, v_id_relatie FROM
      ( select SERIE, NR, ID_DETINUT, ID_RELATIE from relatii_maxSecuritate 
      ORDER BY dbms_random.value )
      WHERE rownum = 1; 



  v_telefon:=0754321765;

  v_data := to_char(v_programare, 'DD-Mon-YYYY');

if ((verif_data_tip4(v_data,v_id_detinut))=1 and (verif_buletin(v_serie, v_nr_buletin, v_id_detinut))=1) then
insert into programare_vizita_tip4( id_programare4,
                                      id_detinut,
                                      id_institutie,
                                      nume,
                                      prenume,
                                      email,
                                      telefon,
                                      seria_buletin,
                                      nr_buletin,
                                      data_programarii,
                                      ora)
                                    values (seq_programare_tip4.nextval,
                                              v_id_detinut,
                                              v_id_institutie,
                                              v_nume,
                                              v_prenume,
                                              v_email,
                                              v_telefon,
                                              v_serie,
                                              v_nr_buletin,
                                              v_programare,
                                              v_ora
                                              );

    select count(*) into v_nr_inserari from programare_vizita_tip4;

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
                                  seq_programare_tip4.nextval,
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
/

select * from programare_vizita_tip4;

