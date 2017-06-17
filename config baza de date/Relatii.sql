--cream tabelul relatie in care inseram tipul relatiei dintre vizitator si detinut, si natura vizitei

drop table relatie;
/
create table relatie(id_relatie integer, tip_relatie varchar2(35), natura_vizita varchar2(35), primary key(id_relatie));
/
INSERT INTO relatie VALUES(1, 'avocat', 'asistenta juridica');
INSERT INTO relatie VALUES(2, 'prieten', 'vizita amicala');
INSERT INTO relatie VALUES(3, 'sot/sotie', 'vizita conjugala');
INSERT INTO relatie VALUES(4, 'mama/tata', 'vizita de familie');
INSERT INTO relatie VALUES(5, 'frate/sora', 'vizita de familie');
INSERT INTO relatie VALUES(6, 'ruda gradul 2', 'vizita de familie');


select * from relatie;


