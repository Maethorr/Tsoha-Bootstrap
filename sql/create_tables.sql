CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    kayttajatunnus varchar(50) NOT NULL,
    salasana varchar(50) NOT NULL
);

CREATE TABLE Tehtava(
    id SERIAL PRIMARY KEY,
    kayttajaId INTEGER REFERENCES Kayttaja(id),
    nimi varchar(50) NOT NULL,
    kuvaus varchar(500),
    prioriteetti INTEGER,
    lisayspaiva date
);

CREATE TABLE Luokka(
    id SERIAL PRIMARY KEY,
    kayttajaId INTEGER REFERENCES Kayttaja(id),
    nimi varchar(50)
);

CREATE TABLE TehtavanLuokka(
    tehtavaId INTEGER REFERENCES Tehtava(id),
    luokkaId INTEGER REFERENCES Luokka(id)
);  
