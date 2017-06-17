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
                                      --data_programarii date not null,
                                      ora varchar2(15)not null,
                                      PRIMARY KEY(id_programare4),
                                      FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
                                      
);
/
drop table vizita cascade constraints;
/
create table vizita (   id_vizita INTEGER, 
                        id_detinut INTEGER NOT NULL,
                        id_vizitator INTEGER NOT NULL,
                        id_programare INTEGER NOT NULL,
                        id_martor INTEGER NOT NULL,
                        id_institutie INTEGER NOT NULL,
                        id_relatie INTEGER NOT NULL,
                        stare_sanatate varchar2(100) NULL, 
                        stare_spirit varchar2(100) NOT NULL,
                        rezumat varchar(100) not null,
                        obiecte varchar2(500),
                        PRIMARY KEY (id_vizita),
                        FOREIGN KEY (id_detinut) REFERENCES DETINUTI (id_detinut),
                        FOREIGN KEY (id_vizitator) REFERENCES VIZITATORI(id_vizitator),
                        FOREIGN KEY (id_martor) REFERENCES MARTORI (id_martor),
                        FOREIGN KEY (id_institutie) REFERENCES INSTITUTIE (id_institutie)
                       
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
select * FROM ore_vizita4;
/
select i.id_tip_institutie, i.capacitate, i.id_institutie, d.id_detinut FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
WHERE i.id_tip_institutie=114;
/

--CREATE OR REPLACE FUNCTION verif_buletin (p_serie varchar, p_nr number, p_id_detinut integer ) RETURN number as
--v_count number;
--BEGIN
--select COUNT(*) INTO v_count from relatii_maxSecuritate WHERE id_detinut=p_id_detinut AND TRIM(serie)=TRIM(p_serie) AND NR=p_nr;
--  IF (v_count>=1) THEN 
--    RETURN 1;
--    ELSIF (v_count=0) THEN 
--    RETURN 0;
--END IF;
--END verif_buletin;


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
-- populare programare_vizita_4

 DROP SEQUENCE id_program4;
/
 CREATE SEQUENCE id_program4
  START WITH 300
  INCREMENT BY 1
  CACHE 550;
/
 CREATE SEQUENCE seq_vizita
  START WITH 1
  INCREMENT BY 1
  CACHE 550;
/ 
select COUNT(*)  FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
WHERE i.id_tip_institutie=112;
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


SELECT COUNT(*) INTO count_vizitatori FROM vizitatori;
SELECT COUNT(*) INTO count_ora FROM ore_vizita4;

  FOR i IN 1..200 LOOP
    random_detinuti := trunc(dbms_random.value(1,count_detinuti+1));
    random_vizitatori := trunc(dbms_random.value(1,count_vizitatori+1));
    random_ora := trunc(dbms_random.value(1,count_ora+1));
       
     SELECT * into v_serie, v_nr_buletin, v_id, v_id_relatie FROM
      ( select SERIE, NR, ID_DETINUT, ID_RELATIE from relatii_maxSecuritate 
      ORDER BY dbms_random.value )
      WHERE rownum = 1; 
      
  SELECT start_pedeapsa, id_institutie into v_start_pedeapsa, v_id_institutie FROM detinuti WHERE id_detinut=v_id; 
      
  SELECT * into v_nume, v_prenume, v_id_vizitator FROM 
    (SELECT * FROM (SELECT nume, prenume, id_vizitator from vizitatori
    WHERE ROWNUM <= random_vizitatori ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
    
  SELECT * into v_ora FROM 
    (SELECT * FROM (SELECT ora from ore_vizita4
    WHERE ROWNUM <= random_ora ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  
  v_email:=TRIM(LOWER(v_prenume))||'.'||TRIM(LOWER(v_nume))||'@gmail.com';
  v_telefon:=0040753582216;

   
SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_pedeapsa ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_data FROM DUAL; 
SELECT TO_CHAR(v_data,'dd-mm-yyyy') INTO v_convert FROM dual;
v_rez:=verif_data_tip4 (v_convert, v_id );

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
      
  INSERT INTO  programare_vizita_tip4 VALUES (id_program4.nextval,
                                              v_id,
                                              v_id_institutie,
                                              v_nume,
                                              v_prenume,
                                              v_email,
                                              v_telefon,
                                              v_serie,
                                              v_nr_buletin,
                                              
                                              v_ora
                                      
  );
 END LOOP;
END; 
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
  v_poza:='poza';  
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
    id_program4.nextval,
    v_martor,
    v_id_institutie,
    v_id_relatie,
    v_stare_sanatate,
    v_stare_spirit,
    v_rezumat,
    v_obiecte

   );
  
  
  
  
  
  
  END IF;



/

select * FROM vizitatori;
select * FROM vizita;
select* FROM programare_vizita_tip4 p JOIN RELATII_MAXSECURITATE r ON p.id_detinut=r.id_detinut
WHERE p.seria_buletin=r.serie AND p.nr_buletin=r.nr;
select * FROM detinuti;
select * FROM programare_vizita_tip4;
/
select COUNT(*)  from relatii_maxSecuritate WHERE id_detinut=345 AND TRIM(serie)=TRIM('NS') AND NR=251984;
/
set serveroutput on;
DECLARE
v_verif number;
v_nr_buletin number;
begin

v_verif:=verif_buletin('NS', 251984, 345); 
v_nr_buletin:=trunc(dbms_random.value(100000,999999));

DBMS_OUTPUT.PUT_LINE(v_verif);
DBMS_OUTPUT.PUT_LINE(v_nr_buletin);
end;