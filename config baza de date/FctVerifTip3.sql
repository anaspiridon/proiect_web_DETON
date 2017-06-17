
CREATE OR REPLACE FUNCTION verificare_prog113(p_data_programare varchar2, p_id_detinut integer) 
RETURN INTEGER
IS
v_nr_vizite_pe_saptamana integer;
v_nr_vizite_pe_zi integer;
v_nr_intervale integer;
v_data_nastere date;
v_nr_detinuti integer;
v_day varchar2(10);

v_data date;

CURSOR lista_detinuti  IS
       SELECT * FROM detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=113;
   v_std_linie lista_detinuti%ROWTYPE;     

BEGIN

v_data := TO_DATE(p_data_programare, 'DD-Mon-YY');

select count(*) into v_nr_vizite_pe_saptamana from programare_vizita_tip3 where to_char(data_programarii,'W')=to_char(v_data,'W') and id_detinut=p_id_detinut;
select count(*) into v_nr_vizite_pe_zi from programare_vizita_tip3 where data_programarii=p_data_programare and id_detinut=p_id_detinut;


select to_char(to_date(v_data,'DD-Mon-YY'), 'DY') into v_day from dual;
--select to_char(to_date('03/09/1982','dd/mm/yyyy'), 'DY') from dual;

   if((v_day!='MON' and v_day!='FRI') or (v_day!='FRI' and v_day!='MON'))then
   DBMS_OUTPUT.PUT_LINE('Vizitele se fac doar luni sau vineri!');
   return 0;
   else if(v_day='MON' or v_day='FRI') then
   
          if (v_nr_vizite_pe_saptamana>1) then
          DBMS_OUTPUT.PUT_LINE('Ziua solicitata este deja programata!');
          return 0;
          else 
            if (v_nr_vizite_pe_zi>1) then
            DBMS_OUTPUT.PUT_LINE('Ziua solicitata este deja programata!');
               return 0;
               else
                 if(v_nr_intervale!=0)then
                 DBMS_OUTPUT.PUT_LINE('Ora solicitata este deja programata!');
                 return 0;
                 else
                   return 1;
                   end if;
                end if;
            end if;
          end if;  
       end if;


END;

--select count(*) from programare_vizita_tip3 where id_detinut=280;
--select count(*) from programare_vizita_tip3 where data_programarii='16-JAN-01' and id_detinut=94;
--
--set serveroutput on;
--declare
--v_rez integer;
--begin
--v_rez := verificare_prog113('16-JAN-01','21-JUL-02','14:39-15:10', 94);
--DBMS_OUTPUT.PUT_LINE(v_rez);
--end;