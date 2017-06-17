
CREATE OR REPLACE FUNCTION verificare_prog111(p_data_programare varchar2,  p_id_detinut integer) 
RETURN INTEGER
IS
v_nr_vizite_pe_saptamana integer;
v_nr_vizite_pe_zi integer;
v_nr_intervale integer;

v_data date;

CURSOR lista_detinuti  IS
       SELECT * FROM detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=111;
   v_std_linie lista_detinuti%ROWTYPE;     

BEGIN

v_data := TO_DATE(p_data_programare, 'DD-Mon-YY');

select count(*) into v_nr_vizite_pe_saptamana from programare_vizita_tip1 where to_char(data_programarii,'W')=to_char(v_data,'W') and id_detinut=p_id_detinut;
select count(*) into v_nr_vizite_pe_zi from programare_vizita_tip1 where extract(day from data_programarii)=extract(day from v_data) and id_detinut=p_id_detinut;


if (v_nr_vizite_pe_saptamana>3) then
return 0;
else 
  if (v_nr_vizite_pe_zi>2) then
     return 0;
     else
       if(v_nr_intervale!=0)then
       return 0;
       else
       return 1;
      end if;
  end if;
end if;  
END;
/
--set serveroutput on;
--declare
--v_rez integer;
--begin
--v_rez := verificare_prog111('04-MAR-80','13:15-13:45',382);
--DBMS_OUTPUT.PUT_LINE(v_rez);
--end;

select * FROM programare_vizita_tip1