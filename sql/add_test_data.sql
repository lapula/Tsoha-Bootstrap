INSERT INTO Kayttaja (nimi, salasana) VALUES ('Atte Admin', '1221');
INSERT INTO Kayttaja (nimi, salasana) VALUES ('Seppo Pekka', 'seppis123');

INSERT INTO Aanestys (nimi, luonut, kuvaus, paattyy, kirjautuminen) VALUES ('Vaalit', '1', 'Hienot Vaalit', '2015-12-25', 'True');
INSERT INTO Aanestys (nimi, luonut, kuvaus, paattyy, kirjautuminen) VALUES ('Vaalit 2', '1', 'Toiset Vaalit', '2016-12-25', 'True');

INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('1', 'Juha Sipilä', '3');
INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('1', 'Mr Stubb', '4');
INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('2', 'Jappe Diktaattori', '4000');

INSERT INTO Aanestaneet (kayttaja_id, aanestys_id, ehdokas_id) VALUES ('1', '1', '2');