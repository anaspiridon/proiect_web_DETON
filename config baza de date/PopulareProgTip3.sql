drop table programare_vizita_tip3 cascade constraints;
/
CREATE  TABLE programare_vizita_tip3( id_programare3 integer not null,
                                      id_detinut not null,
                                      id_institutie integer not null,
                                      nume varchar2(25) not null,
                                      prenume varchar2(25) not null,
                                      email varchar2(50) not null,
                                      telefon integer not null,
                                      data_programarii date not null,
                                      ora varchar2(15)not null,
                                      PRIMARY KEY(id_programare3),
                                      FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
                                      
);
/
DROP SEQUENCE seq_programare_tip3;
/
CREATE SEQUENCE seq_programare_tip3
  START WITH 1
  INCREMENT BY 1
  CACHE 100;
/
 CREATE SEQUENCE seq_vizita
  START WITH 1
  INCREMENT BY 1
  CACHE 100;
/
drop table interval_ore_113;
/
create table interval_ore_113(ora varchar2(35));
/
insert into interval_ore_113(ora) values('14:00-14:30'); 
insert into interval_ore_113(ora) values('14:30-15:00'); 
insert into interval_ore_113(ora) values('15:00-15:30'); 
insert into interval_ore_113(ora) values('15:30-16:00'); 
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
v_telefon integer;
v_data_nastere date;
v_id_vizitator integer;
v_id_martor integer;
v_data varchar2(50);

v_stare_sanatate varchar2(500);
v_stare_spirit varchar2(500);
v_rezumat varchar2(500);
v_id integer;
v_id_relatie integer;
v_obiecte varchar2(500);
v_id_institutie integer;
v_nr_inserari integer;
BEGIN
 SELECT COUNT(id) INTO v_count FROM users;

--   <<LOOP>>
 -- FOR i IN 1..1000 
  LOOP

SELECT id_detinut, start_pedeapsa, data_nastere, id_institutie into v_id_detinut, v_start_programare, v_data_nastere, v_id_institutie FROM
( SELECT d.id_detinut, d.start_pedeapsa, d.data_nastere, d.id_institutie FROM detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=113
ORDER BY dbms_random.value )
WHERE rownum = 1;

 SELECT id_vizitator, nume, prenume, (trim(lower(prenume))||'.'||trim(lower(nume)))||'@email.com', id_relatie into v_id_vizitator, v_nume, v_prenume,  v_email, v_id_relatie FROM
( SELECT id_vizitator, nume, prenume, id_relatie FROM vizitatori
ORDER BY dbms_random.value )
WHERE rownum = 1;
        
        SELECT TO_DATE(
              TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(v_start_programare ,'J'),
                                    TO_CHAR(ADD_MONTHS(sysdate,3),'J')
                                    )),'J' ) into v_programare FROM DUAL;


 
 SELECT ora into v_ora FROM
( SELECT ora FROM interval_ore_113
ORDER BY dbms_random.value )
WHERE rownum = 1;

 SELECT id_martor into v_id_martor FROM
( SELECT id_martor FROM martori
ORDER BY dbms_random.value )
WHERE rownum = 1;

select dbms_random.value(1000000000, 9999999999) num into v_telefon from dual;

   
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


   v_data := to_char(v_programare, 'DD-Mon-YYYY');
   
if (verificare_prog113(v_data,v_id_detinut))=1 then
insert into programare_vizita_tip3( id_programare3 ,
                                    id_detinut,
                                    id_institutie,
                                    nume,
                                    prenume,
                                    email,
                                    telefon,
                                    data_programarii,
                                    ora)  
                                    values (seq_programare_tip3.nextval,
                                              v_id_detinut,
                                              v_id_institutie,
                                              v_nume,
                                              v_prenume,
                                              v_email,
                                              v_telefon,
                                              v_programare,
                                              v_ora
                                              );

select count(*) into v_nr_inserari from programare_vizita_tip3;

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
    v_id_detinut,
    v_id_vizitator,
    seq_programare_tip3.nextval,
    v_id_martor,
    v_id_institutie,
    v_id_relatie,
    v_stare_sanatate,
    v_stare_spirit,
    v_rezumat,
    v_obiecte
   );
  
end if;
EXIT WHEN v_nr_inserari=100;

END LOOP;
END;
/

--select * from vizita;
--select * from programare_vizita_tip3;
--select * from vizitatori;
--select * from martori;
--select * from detinuti;