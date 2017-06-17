drop table programare_vizita_tip1 cascade constraints;
/
CREATE  TABLE programare_vizita_tip1( id_programare1 integer not null,
                                      id_detinut not null,
                                      id_institutie integer not null,
                                      nume varchar2(25) not null,
                                      prenume varchar2(25) not null,
                                      email varchar2(50) not null,
                                      data_programarii date not null,
                                      ora varchar2(15)not null,
                                      PRIMARY KEY(id_programare1),
                                      FOREIGN KEY (id_detinut) REFERENCES DETINUTI(id_detinut)
                                      
);
/
drop table interval_ore_111;
/
create table interval_ore_111(ora varchar2(35));
/
insert into interval_ore_111(ora) values('10:00-10:45'); 
insert into interval_ore_111(ora) values('10:45-11:30'); 
insert into interval_ore_111(ora) values('11:30-12:15');
insert into interval_ore_111(ora) values('12:15-13:00');
insert into interval_ore_111(ora) values('13:00-13:45');
insert into interval_ore_111(ora) values('13:45-14:30');
insert into interval_ore_111(ora) values('14:30-15:15');
insert into interval_ore_111(ora) values('15:15-16:00');

/
DROP SEQUENCE seq_programare_tip1;
/
 CREATE SEQUENCE seq_programare_tip1
  START WITH 1
  INCREMENT BY 1
  CACHE 100;
/
DROP SEQUENCE seq_programare_tip11;
/
 CREATE SEQUENCE seq_programare_tip11
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

BEGIN
 SELECT COUNT(id) INTO v_count FROM users;
 
   --<<LOOP>>
  --FOR i IN 1..100 
  LOOP

SELECT id_detinut, start_pedeapsa, id_institutie into v_id_detinut, v_start_programare, v_id_institutie FROM
( SELECT d.id_detinut, d.start_pedeapsa, d.id_institutie FROM detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=111
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
( SELECT ora FROM interval_ore_111
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

  v_data := to_char(v_programare, 'DD-Mon-YYYY');

if (verificare_prog111(v_data, v_id_detinut))=1 then
insert into programare_vizita_tip1( id_programare1 ,
                                    id_detinut,
                                    id_institutie,
                                    nume,
                                    prenume,
                                    email,
                                    data_programarii,
                                    ora)  
                                    values (seq_programare_tip1.nextval,
                                              v_id_detinut,
                                              v_id_institutie,
                                              v_nume,
                                              v_prenume,
                                              v_email,
                                              v_programare,
                                              v_ora
                                              );

    select count(*) into v_nr_inserari from programare_vizita_tip1;

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
                                  seq_programare_tip11.nextval,
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
--select * from programare_vizita_tip1 where to_char(data_programarii,'MM') in (05);
--select * from stare1;
--select * from obiecte;
--select * from detinuti;
--select * from martori;
--select * from vizitatori;
--select * from programare_vizita_tip1;
--select * from vizita;
--
--select * from programare_vizita_tip1 where to_char(data_programarii,'YYYY-MM-DD')='2004-04-05';
--
--SELECT count(*) from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1
--where to_char(data_programarii,'YYYY-MM-DD')=trim(2004-04-05);
--
--select * from vizita where id_detinut=525;
----
--SELECT * from programare_vizita_tip1 p  join vizita v on v.id_programare=p.id_programare1;
--SELECT * from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1 where to_char(data_programarii,'YYYY-MM-DD')='2004-04-05';
--
--select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, 
--m.nume as n_martor, m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator,
--v.stare_sanatate as stare_sanatate, v.stare_spirit as stare_spirit,v.rezumat as rezumat, 
--v.obiecte as obiecte from vizita v join programare_vizita_tip1 p on v.id_programare=p.id_programare1
--join detinuti d  on v.id_detinut=d.id_detinut join martori m  on v.id_martor=m.id_martor join vizitatori vi 
--on v.id_vizitator=vi.id_vizitator WHERE  to_char(p.data_programarii,'YYYY-MM-DD')= trim(2014-06-30);
--
--SELECT * FROM VIZITA;
--select * from programare_vizita_tip1 where ora='13:00-13:45' ;
--select * from vizita where id_programare=141;
--select count(*) from vizita;
--select id_detinut from programare_vizita_tip1 where id_programare1=39;
--select id_relatie from vizitatori v join programare_vizita_tip1 p on v.nume=p.nume where p.id_programare1=3;
--select id_institutie from detinuti d join programare_vizita_tip1 p on d.id_detinut=p.id_detinut where id_programare1=3;
--select id_vizitator from vizitatori v join programare_vizita_tip1 p on v.nume=p.nume where p.id_programare1=3;

--
--select v.id_vizita as id_vizita, d.nume as n_detinut, d.prenume as p_detinut, m.nume as n_martor,
--m.prenume as p_martor, vi.nume as n_vizitator, vi.prenume as p_vizitator, v.stare_sanatate as stare_sanatate,
--v.stare_spirit as stare_spirit,v.rezumat as rezumat, v.obiecte as obiecte from vizita v join detinuti d  on v.id_detinut=d.id_detinut
--join martori m  on v.id_martor=m.id_martor join vizitatori vi on v.id_vizitator=vi.id_vizitator ;


--select * from vizita v join vizitatori vi on vi.id_vizitator=v.id_vizitator  join detinuti d on v.id_detinut=d.id_detinut where v.id_relatie=4;
--
--select* from relatie;

--select id_institutie from programare_vizita_tip1 where id_programare1=227;

--SELECT * FROM VIZITA V JOIN VIZITATORI VI ON VI.ID_VIZITATOR=V.ID_VIZITATOR JOIN programare_vizita_tip1 P ON P.id_programare1=V.id_programare1;
--
--
--SELECT * FROM VIZITA V JOIN programare_vizita_tip1 P ON P.id_programare1=V.id_programare;

--select * from programare_vizita_tip1;
--select * from vizita;
--
--SELECT * FROM VIZITA WHERE ID_VIZITA=11107;