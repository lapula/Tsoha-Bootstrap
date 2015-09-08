
CREATE TABLE Kayttaja (
    id SERIAL PRIMARY KEY,
    nimi varchar(40) NOT NULL,
    salasana varchar(30) NOT NULL
);

CREATE TABLE Aanestys (
    id SERIAL PRIMARY KEY,
    luonut INTEGER REFERENCES Kayttaja(id),
    nimi varchar(40) NOT NULL,
    kuvaus varchar(400) NOT NULL,
    paattyy DATE,
    kirjautuminen boolean DEFAULT true
);

CREATE TABLE Ehdokas (
    id SERIAL PRIMARY KEY,
    aanestys_id INTEGER REFERENCES Aanestys(id),
    nimi varchar(40),
    aania INTEGER
);

CREATE TABLE Aanestaneet (
    kayttaja_id INTEGER REFERENCES Kayttaja(id),
    aanestys_id INTEGER REFERENCES Aanestys(id),
    ehdokas_id INTEGER REFERENCES Ehdokas(id)
);
