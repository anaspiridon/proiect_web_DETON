DROP TABLE relatii_maxSecuritate;
/
CREATE TABLE relatii_maxSecuritate(id_relatii integer,
                                    nume varchar2(25) not null,
                                    prenume varchar2(25) not null,
                                    id_detinut integer not null,
                                    id_relatie integer not null,
                                    serie varchar2(2) not null,
                                    nr integer not null,
                                    primary key(id_relatii),
                                    foreign key (id_detinut ) references detinuti(id_detinut ));
                                    
DECLARE
CURSOR curs IS select d.id_detinut, d.nume, rownum from detinuti d join institutie i on d.id_institutie=i.id_institutie where i.id_tip_institutie=114;
 v_std_linie curs%ROWTYPE; 
 v_id_relatie integer;
 v_prenume varchar2(25);
 v_serie varchar2(2);
 v_nr integer;
BEGIN
OPEN curs;
LOOP
v_id_relatie := dbms_random.value(3,5);

SELECT prenume into v_prenume FROM
( SELECT prenume FROM vizitatori
ORDER BY dbms_random.value )
WHERE rownum = 1;

select dbms_random.string('U', 2) str into v_serie from dual;

select dbms_random.value(100000, 999999) num into v_nr from dual;

        FETCH curs INTO v_std_linie;
        EXIT WHEN curs%NOTFOUND;
        insert into relatii_maxSecuritate(id_relatii, nume, prenume, id_detinut, id_relatie, serie, nr) values(v_std_linie.rownum,v_std_linie.nume,v_prenume,v_std_linie.id_detinut,v_id_relatie,v_serie,v_nr);
    END LOOP;
CLOSE curs;
END;

select * from relatii_maxSecuritate;


