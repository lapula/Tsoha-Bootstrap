INSERT INTO Kayttaja (nimi, salasana) VALUES ('Atte Admin', '1221');
INSERT INTO Kayttaja (nimi, salasana) VALUES ('Seppo Pekka', 'seppis123');

INSERT INTO Aanestys (paattyy, kirjautuminen) VALUES ('2015-12-25', 'True');

INSERT INTO Ehdokas (aanestys_id, nimi, aania) VALUES ('1', 'Juha Sipilä', '3');

INSERT INTO Aanestaneet (kayttaja_id, aanestys_id) VALUES ('1', '1');