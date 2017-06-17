drop table detinuti cascade constraints;
/
CREATE TABLE detinuti( id_detinut number, 
                      nume varchar2(25)not null,
                      prenume varchar2(25) not null,
                      gen varchar2(1)not null,
                      nr_dosar varchar2(24) not null,
                      start_pedeapsa date not null,
                      id_pedeapsa number not null,
                      id_institutie  number not null,
                      adr_poza varchar2(150) not null,
                      data_nastere date not null,
                      comportament_exemplar integer not null,
                      PRIMARY KEY(id_detinut),
                      FOREIGN KEY (id_institutie) REFERENCES INSTITUTIE(id_institutie),
                      FOREIGN KEY (id_pedeapsa) REFERENCES PEDEPSE(id_pedeapsa));
                      
/                      
 DROP SEQUENCE seq_detinuti;
 CREATE SEQUENCE seq_det
  START WITH 1
  INCREMENT BY 1
  CACHE 1000;
 /
 
set serveroutput on; 
DECLARE 

CREATE OR REPLACE FUNCTION add_detinuti (p_id integer) RETURN number as  

capacitate EXCEPTION;
PRAGMA EXCEPTION_INIT(capacitate, -20002);


set serveroutput on; 
DECLARE 

CREATE OR REPLACE FUNCTION add_detinuti (p_id integer) RETURN number as 

capacitate EXCEPTION;
username_duplicat EXCEPTION;
PRAGMA EXCEPTION_INIT(capacitate, -20002);   
PRAGMA EXCEPTION_INIT(username_duplicat, -20079);
count_detinuti number;
count_pedepse number;
count_institutii number;

random_nume number;
random_prenume number;
random_pedepse number;
random_institutii number;
random_exemplar number;
random_dosar1 number;
random_dosar2 number;

v_nume varchar2(25);
v_prenume varchar2(25);
v_id_pedeapsa number;
v_id_institutii number;
v_pedeapsa_tip number;
v_institutie_tip number;
v_poza varchar2(35);
v_pedeapsa DATE;
v_data_nastere DATE;
v_dosar varchar(24);
v_gen varchar2(1);
v_capacitate number;
v_count_capacitate number;
count_duplicate number;


BEGIN
  SELECT COUNT(id) INTO count_detinuti FROM users;
  SELECT COUNT(id_pedeapsa) INTO count_pedepse FROM pedepse;
  SELECT COUNT(id_institutie) INTO count_institutii FROM institutie;

  
  random_dosar1 := trunc(dbms_random.value(500,5000)); 
  random_dosar2 := trunc(dbms_random.value(1,100));
  random_nume := trunc(dbms_random.value(1,count_detinuti+1));
  random_prenume := trunc(dbms_random.value(1,count_detinuti+1));
  random_pedepse := trunc(dbms_random.value(1,count_pedepse+1)); 
  random_institutii := trunc(dbms_random.value(1,count_institutii+1)); 
  random_exemplar:=trunc(dbms_random.value(0,2)); 
  
   SELECT * into v_nume FROM 
    (SELECT * FROM (SELECT SUBSTR(name,INSTR(name,' '),length(name)) from users
    WHERE ROWNUM <= random_nume ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
 -- dbms_output.put_line(v_nume);
    SELECT * into  v_prenume FROM 
    (SELECT * FROM (SELECT  SUBSTR(name,0,INSTR(name,' ')) from users
    WHERE SUBSTR(name,0,INSTR(name,' ')) IS NOT NULL AND ROWNUM <= random_prenume ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  
  SELECT * into  v_id_pedeapsa, v_pedeapsa_tip FROM 
    (SELECT * FROM (SELECT id_pedeapsa, id_tip_institutie FROM pedepse
    WHERE ROWNUM <= random_pedepse ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  
   SELECT * into  v_id_institutii, v_institutie_tip FROM 
    (SELECT * FROM (SELECT id_institutie, id_tip_institutie FROM institutie
    WHERE ROWNUM <= random_institutii ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
  
  
  IF (v_pedeapsa_tip!=v_institutie_tip) THEN
  LOOP
    random_pedepse := trunc(dbms_random.value(1,count_pedepse+1));     
       SELECT * into  v_id_pedeapsa, v_pedeapsa_tip FROM 
      (SELECT * FROM (SELECT id_pedeapsa, id_tip_institutie FROM pedepse
      WHERE ROWNUM <= random_pedepse ORDER BY ROWNUM DESC)) WHERE ROWNUM < 2; 
    
    EXIT WHEN v_pedeapsa_tip=v_institutie_tip;
  END LOOP;
END IF; 
--dbms_output.put_line(v_pedeapsa_tip||''||v_institutie_tip||'egalitate');
  IF (TRIM(v_prenume) NOT LIKE '%a' ) THEN
    v_gen:='M';
    ELSE 
    v_gen:='F';
  END IF;
  
  v_pedeapsa:=TO_DATE(TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(DATE '2000-01-01','J'),TO_CHAR(DATE '2017-03-15','J'))),'J');
  v_data_nastere:=TO_DATE(TRUNC(DBMS_RANDOM.VALUE(TO_CHAR(DATE '1980-01-01','J'),TO_CHAR(DATE '2003-03-15','J'))),'J');
  v_dosar:= random_dosar1||'/'||random_dosar2||'/'||TO_CHAR(EXTRACT (YEAR FROM v_pedeapsa)-1);
  v_poza:='lala';
  
  
  
 INSERT INTO detinuti(id_detinut , 
                      nume,
                      prenume,
                      gen,
                      nr_dosar,
                     start_pedeapsa ,
                      id_pedeapsa ,
                      id_institutie ,
                      adr_poza,
                      data_nastere ,
                      comportament_exemplar ) VALUES
  
                      (p_id,
                      v_nume,
                      v_prenume,
                      v_gen,
                      v_dosar,
                      v_pedeapsa,
                      v_id_pedeapsa,
                      v_id_institutii,
                      v_poza,
                      v_data_nastere,
                      random_exemplar) ;
  
  select COUNT(d.id_detinut), i.capacitate, i.id_institutie INTO v_count_capacitate, v_capacitate, v_id_institutii 
  FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
  WHERE i.id_institutie=v_id_institutii
  GROUP BY i.capacitate, i.id_institutie;
  
  SELECT COUNT(*) into count_duplicate   FROM detinuti WHERE (TRIM(lower(prenume))||'.'||TRIM(lower(nume)))=(TRIM(lower(v_prenume))||'.'||TRIM(lower(v_nume)));
  
  
  IF (v_count_capacitate+1>v_capacitate) THEN
    raise_application_error (-20002,'Capacitatea institutiei a fost depasita');
  ELSIF  (count_duplicate > 1) THEN      
    raise_application_error (-20079,'Username-ul nu este unic!');
    dbms_output.put_line('count ul>1');
  ELSE
    dbms_output.put_line('count ul ramane 1! sunt in else');
  RETURN 1;
  END IF;
  
  
EXCEPTION
  WHEN NO_DATA_FOUND THEN
  DBMS_OUTPUT.PUT_LINE(SUBSTR(SQLERRM,1,64));
 RETURN 2;

  WHEN DUP_VAL_ON_INDEX THEN
  DBMS_OUTPUT.PUT_LINE(SUBSTR(SQLERRM,1,64));
  RETURN 2;
  
  WHEN capacitate THEN
  DBMS_OUTPUT.PUT_LINE(SUBSTR(SQLERRM,1,64));
  RETURN 2;  
  
  WHEN username_duplicat THEN
  DBMS_OUTPUT.PUT_LINE(SUBSTR(SQLERRM,1,64));
  RETURN 3;  
 
 END;
 
select * FROM detinuti; 
select COUNT(d.id_detinut), i.capacitate, i.id_institutie FROM detinuti d  join institutie i ON i.id_institutie=d.id_institutie
GROUP BY i.capacitate, i.id_institutie;

/
CREATE OR REPLACE PROCEDURE all_detinuti  as 
v_contor number;
v_linii number;
v_rez number;
random_institutii number;
count_institutii number;
v_count_capacitate number;
v_capacitate number;
v_id_institutii number;
v_blah number;
count_inst number;

 BEGIN
v_contor:=1;
v_linii:=0;


LOOP
v_rez:=add_detinuti(v_contor);    

    IF (v_rez=1) THEN
    v_linii:=v_linii+1;
    
    ELSIF v_rez=2 THEN
    EXECUTE IMMEDIATE 'DELETE FROM detinuti WHERE id_detinut=:v_contor' using v_contor;
    
    ELSIF v_rez=3 THEN
    EXECUTE IMMEDIATE 'DELETE FROM detinuti WHERE id_detinut=:v_contor' using v_contor;
    
    END IF;   
    v_contor:=v_contor+1; 

EXIT WHEN v_linii>2000 OR v_contor>2000;
END LOOP;

END;
/

set SERVEROUTPUT ON;
begin

all_detinuti;

end;




-- teste
select * FROM detinuti;
select COUNT(*)FROM detinuti;

select trim(lower(prenume))||'.'||trim(lower(nume)), count(*) from detinuti

GROUP BY trim(lower(prenume))||'.'||trim(lower(nume))
HAVING count(distinct (trim(lower(prenume))||'.'||trim(lower(nume))))>=1;


SELECT COUNT(*)  FROM detinuti WHERE TRIM(lower(prenume))||'.'||TRIM(lower(nume))=TRIM(lower('sebastian'))||'.'||TRIM(lower('popovici'));


select count(distinct (trim(lower(prenume))||'.'||trim(lower(nume))))  from detinuti;


SELECT COUNT(*)  FROM detinuti WHERE (TRIM(lower(prenume))||'.'||TRIM(lower(nume)))=(TRIM(lower('george'))||'.'||TRIM(lower('tofan')));
