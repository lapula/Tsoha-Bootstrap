INSERT INTO Kayttaja (nimi, salasana) VALUES ('Atte Admin', 'atte');
INSERT INTO Kayttaja (nimi, salasana) VALUES ('Seppo Pekka', 'seppis123');

INSERT INTO Aanestys (nimi, luonut, kuvaus, paattyy, kirjautuminen) VALUES ('Vaalit', '1', 'Hienot Vaalit', '2015-12-25', 'True');
INSERT INTO Aanestys (nimi, luonut, kuvaus, paattyy, kirjautuminen) VALUES ('Vaalit 2', '1', 'Toiset Vaalit', '2016-12-25', 'False');
INSERT INTO Aanestys (nimi, luonut, kuvaus, paattyy, kirjautuminen) VALUES ('Vaalit 3', '1', 'Vanhentunut', '2014-12-25', 'False');

INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('1', 'Juha Sipilä', '0');
INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('1', 'Mr Stubb', '0');
INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('2', 'Jappe Diktaattori', '4000');
INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('3', 'Kylläpäs', '100');
INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('3', 'Eipäs', '101');

