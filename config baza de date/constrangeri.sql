create or replace trigger "insert_detinuti"
BEFORE
insert on "DETINUTI"
for each row
when (new.ID_INSTITUTIE is not null AND new.ID_PEDEAPSA is not null)
begin
    declare v_count integer := 0;
    v_count1 integer := 0;
    begin
        select count(*) into v_count from institutie where id_institutie = :new.ID_INSTITUTIE ;
        select count(*) into v_count1 from pedepse where id_pedeapsa = :new.ID_PEDEAPSA ;
        if v_count = 0 then
            raise_application_error(-20542, 'Institutia '||:new.ID_INSTITUTIE||' nu exista!');
        ELSIF v_count1=0 then
            raise_application_error(-20742, 'Pedeapsa '||:new.ID_PEDEAPSA||' nu exista!');
        end if;
        EXCEPTION
        WHEN OTHERS THEN
        null;
    end;
end;
/
create or replace trigger "trigg_insert_vizita"
BEFORE
insert on "VIZITA"
for each row
when (new.ID_VIZITATOR is not null AND new.ID_DETINUT is not null AND new.ID_MARTOR is not null AND new.ID_INSTITUTIE is not null
AND new.ID_RELATIE is not null AND new.ID_PROGRAMARE is not null )
begin
    declare v_count integer := 0;
    v_count1 integer := 0;
    v_count2 integer := 0;
    v_count3 integer := 0;
    v_count4 integer := 0;
    v_count5 integer := 0;
    v_count6 integer := 0;
    v_count7 integer := 0;
    v_count8 integer := 0;
    
    begin
        select count(*) into v_count from vizitatori where id_vizitator = :new.ID_VIZITATOR;
        select count(*) into v_count1 from detinuti where id_detinut = :new.ID_DETINUT ;
        select count(*) into v_count2 from martori where id_martor = :new.ID_MARTOR ;
        select count(*) into v_count3 from institutie where ID_INSTITUTIE = :new.ID_INSTITUTIE ;
        select count(*) into v_count4 from relatie where ID_RELATIE = :new.ID_RELATIE ;
        
        SELECT COUNT(ID_PROGRAMARE1)into v_count5 FROM PROGRAMARE_VIZITA_TIP1  WHERE ID_PROGRAMARE1=:new.ID_PROGRAMARE;
        SELECT COUNT(ID_PROGRAMARE2) into v_count6 FROM PROGRAMARE_VIZITA_TIP2  WHERE ID_PROGRAMARE2=:new.ID_PROGRAMARE;
        SELECT COUNT(ID_PROGRAMARE3) into v_count7 FROM PROGRAMARE_VIZITA_TIP3  WHERE ID_PROGRAMARE3=:new.ID_PROGRAMARE;
        SELECT COUNT(ID_PROGRAMARE4) into v_count8 FROM PROGRAMARE_VIZITA_TIP4  WHERE ID_PROGRAMARE4=:new.ID_PROGRAMARE;
        
       
        if v_count = 0 then
            raise_application_error(-20542, 'Vizitatorul cu id-ul '||:new.ID_VIZITATOR||' nu exista!');
        ELSIF v_count1 = 0 then
            raise_application_error(-20582, 'Detinutul cu id-ul '||:new.ID_DETINUT||' nu exista!');
              
        ELSIF v_count2 = 0 then
            raise_application_error(-20592, 'Martorul cu id-ul '||:new.ID_MARTOR||' nu exista!');
            
       ELSIF v_count3 = 0 then
            raise_application_error(-20542, 'Institutia cu id-ul '||:new.ID_INSTITUTIE||' nu exista!');
              
        ELSIF v_count4 = 0 then
            raise_application_error(-20532, 'Relatia cu id-ul '||:new.ID_RELATIE ||' nu exista!');
            
       ELSIF v_count5 = 0 AND v_count6=0 AND v_count7 = 0 AND v_count8=0  then
            raise_application_error(-20382, 'Programarea cu id-ul '||:new.ID_PROGRAMARE||' nu exista!');
      
        end if;
       
    end;
end;

/

create or replace trigger "after_insert_programare1"
AFTER
insert on "PROGRAMARE_VIZITA_TIP1"
for each row
when (NEW.NUME is not null AND NEW.PRENUME is NOT NULL)
DECLARE
v_count number:=0;
begin
    SELECT * into v_count FROM (SELECT id_vizitator FROM vizitatori ORDER  BY ROWNUM DESC) WHERE ROWNUM=1;
    INSERT INTO VIZITATORI VALUES (v_count+1,:NEW.NUME,:NEW.PRENUME,''); 
        
end;
/
create or replace trigger after_insert_programare2
AFTER
insert on programare_vizita_tip2
for each row

DECLARE
v_count number:=0;
begin
    SELECT *  FROM (SELECT id_vizitator FROM vizitatori ORDER  BY ROWNUM DESC) WHERE ROWNUM=1;
    INSERT INTO VIZITATORI VALUES (v_count+1,:NEW.NUME,:NEW.PRENUME,''); 
        
end;
/
create or replace trigger "after_insert_programare3"
AFTER
insert on "PROGRAMARE_VIZITA_TIP3"
for each row
when (NEW.NUME is not null AND NEW.PRENUME is NOT NULL)
DECLARE
v_count number:=0;
begin
    SELECT * into v_count FROM (SELECT id_vizitator FROM vizitatori ORDER  BY ROWNUM DESC) WHERE ROWNUM=1;
    INSERT INTO VIZITATORI VALUES (v_count+1,:NEW.NUME,:NEW.PRENUME,''); 
        
end;
/
create or replace trigger "after_insert_programare4"
AFTER
insert on "PROGRAMARE_VIZITA_TIP4"
for each row
when (NEW.NUME is not null AND NEW.PRENUME is NOT NULL)
DECLARE
v_count number:=0;
begin
    SELECT * into v_count FROM (SELECT id_vizitator FROM vizitatori ORDER  BY ROWNUM DESC) WHERE ROWNUM=1;
    INSERT INTO VIZITATORI VALUES (v_count+1,:NEW.NUME,:NEW.PRENUME,''); 
        
end;
/
CREATE OR REPLACE TRIGGER REMOVE_DETINUTI
BEFORE DELETE ON DETINUTI
FOR EACH ROW
DECLARE
v_nume varchar2(45);
v_prenume varchar2(45);
v_id integer;
BEGIN
  DELETE FROM VIZITA WHERE ID_DETINUT = :old.ID_DETINUT ;
  DELETE FROM PROGRAMARE_VIZITA_TIP1 WHERE ID_DETINUT = :old.ID_DETINUT ;
  DELETE FROM PROGRAMARE_VIZITA_TIP2 WHERE ID_DETINUT = :old.ID_DETINUT ;
  DELETE FROM PROGRAMARE_VIZITA_TIP3 WHERE ID_DETINUT = :old.ID_DETINUT ;
  DELETE FROM PROGRAMARE_VIZITA_TIP4 WHERE ID_DETINUT = :old.ID_DETINUT ;
  DELETE FROM RELATII_MAXSECURITATE WHERE ID_DETINUT = :old.ID_DETINUT ;
  
--  SELECT nume, prenume, id_institutie INTO v_nume, v_prenume, v_id FROM detinuti WHERE ID_DETINUT=:old.ID_DETINUT ;
--  DELETE FROM UTILIZATORIDETON  WHERE nume=v_nume AND prenume=v_prenume AND id_institutie=v_id;
  
  EXCEPTION
  when NO_DATA_FOUND then
  DBMS_OUTPUT.PUT_LINE('Detinutul pe care doriti sa il stergeti nu exista!');  
  
END;
/
DELETE TRIGGER REMOVE_INSTITUTIE; 
/
CREATE OR REPLACE TRIGGER REMOVE_INSTIT
BEFORE DELETE ON INSTITUTIE
FOR EACH ROW
BEGIN
  DELETE FROM DETINUTI WHERE ID_INSTITUTIE = :old.ID_INSTITUTIE ;
  DELETE FROM (SELECT * FROM VIZITA V JOIN DETINUTI D ON V.ID_DETINUT=D.ID_DETINUT WHERE D.ID_INSTITUTIE = :old.ID_INSTITUTIE) ;
  DELETE FROM PROGRAMARE_VIZITA_TIP1 WHERE ID_INSTITUTIE = :old.ID_INSTITUTIE ;
  DELETE FROM PROGRAMARE_VIZITA_TIP2 WHERE ID_INSTITUTIE = :old.ID_INSTITUTIE ;
  DELETE FROM PROGRAMARE_VIZITA_TIP3 WHERE ID_INSTITUTIE = :old.ID_INSTITUTIE ;
  DELETE FROM PROGRAMARE_VIZITA_TIP4 WHERE ID_INSTITUTIE = :old.ID_INSTITUTIE ;
  DELETE FROM (SELECT * FROM RELATII_MAXSECURITATE R JOIN DETINUTI D ON R.ID_DETINUT= D.ID_DETINUT WHERE D.ID_INSTITUTIE = :old.ID_INSTITUTIE) ;
  DELETE FROM UTILIZATORIDETON WHERE ID_INSTITUTIE = :old.ID_INSTITUTIE;
  
  EXCEPTION
  when NO_DATA_FOUND then
  DBMS_OUTPUT.PUT_LINE('Institutia pe care doriti sa o stergeti nu exista!'); 
  
END;
/
CREATE OR REPLACE TRIGGER REMOVE_MARTORII
BEFORE DELETE ON MARTORI
FOR EACH ROW
BEGIN
  DELETE FROM VIZITA WHERE ID_MARTOR = :old.ID_MARTOR ;
  
  EXCEPTION
  when NO_DATA_FOUND then
  DBMS_OUTPUT.PUT_LINE('Martorul pe care doriti sa il stergeti nu exista!');  
  
END;
/
CREATE OR REPLACE TRIGGER REMOVE_VIZITATORI
BEFORE DELETE ON VIZITATORI
FOR EACH ROW
BEGIN
  DELETE FROM VIZITA WHERE ID_VIZITATOR = :old.ID_VIZITATOR ;
  
  SELECT nume, prenume INTO v_nume, v_prenume FROM vizitatori WHERE ID_DETINUT=:old.ID_VIZITATOR ;
--  DELETE FROM UTILIZATORIDETON  WHERE nume=v_nume AND prenume=v_prenume;
  EXCEPTION
  when NO_DATA_FOUND then
  DBMS_OUTPUT.PUT_LINE('Vizitatorul pe care doriti sa il stergeti nu exista!');  
  
END;
/