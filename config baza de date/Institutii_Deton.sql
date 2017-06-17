
DROP TABLE institutie CASCADE CONSTRAINTS;

CREATE TABLE institutie(id_institutie integer, nume_institutie varchar(100), id_tip_institutie integer, adresa clob, nr_telefon varchar2(35), capacitate integer, PRIMARY KEY (id_institutie) );

INSERT INTO institutie VALUES(1, 'Scoala de corectie Iasi', 111, 'Str. Dr. Theodor, nr. 13, Loc. Iasi, jud. Iasi, Romania','0234-456234',45);  
INSERT INTO institutie VALUES(2, 'Scoala de corectie Bacau', 111, 'Str. Mircea Eliade, nr. 122, Loc. Bacau, jud. Bacau, Romania','0234-452224',55);     
INSERT INTO institutie VALUES(3, 'Scoala de corectie Timisoara', 111, 'Str.  Codrescu, nr. 130, Loc. Timisoara, jud. Timisoara, Romania','0234-453234',35);     
INSERT INTO institutie VALUES(4, 'Scoala de corectie Brasov', 111, 'Str.  Cuza, nr. 10, Loc. Brasov, jud. Brasov, Romania','0234-456259',45);   
INSERT INTO institutie VALUES(5, 'Scoala de corectie Vaslui', 111, 'Str. Stefan cel Mare, nr. 1, Loc. Vaslui, jud. Vaslui, Romania','0234-986234',40);     
INSERT INTO institutie VALUES(6, 'Scoala de corectie Cluj', 111, 'Str. Stefan cel Mare, nr. 1, Loc. Cluj, jud. Cluj, Romania','0234-986204',40);     

INSERT INTO institutie VALUES(7, 'Inchisoare Bacau', 112, 'Str. Marin Preda, nr. 122, Loc. Bacau, jud. Bacau, Romania','0235-452224',35);     
INSERT INTO institutie VALUES(8, 'Inchisoare Timisoara', 112, 'Str.  Elena Cuza, nr. 130, Loc. Timisoara, jud. Timisoara, Romania','0235-453234',45);     
INSERT INTO institutie VALUES(9, 'Inchisoare Brasov', 112, 'Str.  Ion Creanga, nr. 10, Loc. Brasov, jud. Brasov, Romania','0235-456259',45);   
INSERT INTO institutie VALUES(10, 'Inchisoare Vaslui', 112, 'Str. Mircea cel Batran, nr. 1, Loc. Vaslui, jud. Vaslui, Romania','0235-986234',40);     
INSERT INTO institutie VALUES(11, 'Inchisoarea Iasi', 112, 'Str. Regina Maria, nr. 13, Loc. Iasi, jud. Iasi, Romania','0235-456234',55);  
INSERT INTO institutie VALUES(12, 'Inchisoarea Constanta', 112, 'Str. Regina Maria, nr. 13, Loc. Constanta, jud. Constanta, Romania','0205-456234',55);  

INSERT INTO institutie VALUES (13,'Penitenciar Bihor', 113, 'Str. Parcul Traian, nr.3, Loc. Oradea, jud. Bihor, Romania','0259-419991',70);
INSERT INTO institutie VALUES (14,'Penitenciar Braila', 113, 'Str. Carantina, nr. 4A, Loc. Braila. jud. Braila, Romania','0239-679314',55);
INSERT INTO institutie VALUES (15, 'Penitenciar Botosani', 113, 'Str. I C Bratianu, nr. 118, -  Loc. Botosani. jud. Botosani, Romania','0232-515937',75);
INSERT INTO institutie VALUES (16, 'Penitenciar Constanta', 113, 'Str. Dr. Vicol, nr. 10, Loc. Constanta, jud. Constanta, Romania','0239-210700',55);
INSERT INTO institutie VALUES (17, 'Penitenciar Iasi', 113, 'Str. Dr. Vicol, nr. 10, Loc. Iasi, jud. Iasi, Romania','0239-216700',50);
INSERT INTO institutie VALUES (18, 'Penitenciar Vaslui', 113, 'Str. Avicola, nr. 2, Loc. Muntenii de Jos,jud. Vaslui, Romania','0237-216700',60);

INSERT INTO institutie VALUES (19,'Inchisoare de maxima securitate Braila', 114, 'Str. Carantina, nr. 4A, Loc. Braila. jud. Braila, Romania','0239-679314',55);
INSERT INTO institutie VALUES (20, 'Inchisoare de maxima securitate Botosani', 114, 'Str. I C Bratianu, nr. 118, -  Loc. Botosani. jud. Botosani, Romania','0232-515937',75);
INSERT INTO institutie VALUES (21, 'Inchisoare de maxima securitate Iasi', 114, 'Str. Salcamilor, nr. 19, Loc. Iasi, jud. Iasi, Romania','0249-216700',55);
INSERT INTO institutie VALUES (22, 'Inchisoare de maxima securitate Vaslui', 114, 'Str. Avicola, nr. 2, Loc. Muntenii de Jos,jud. Vaslui, Romania','0237-216700',60);
INSERT INTO institutie VALUES (23,'Inchisoare de maxima securitate Bihor', 114, 'Str. Parcul Traian, nr.3, Loc. Oradea, jud. Bihor, Romania','0259-419991',70);
INSERT INTO institutie VALUES (24, 'Inchisoare de maxima securitate Galati', 114, 'Str. Avicola, nr. 2, Loc. Muntenii de Sus,jud. Galati, Romania','0237-216710',60);
INSERT INTO institutie VALUES (25,'Inchisoare de maxima securitate Tulcea', 114, 'Str. Parcul Lebedelor, nr.3, Loc. Tulcea, jud. Tulcea, Romania','0259-419981',70);


select * from institutie;