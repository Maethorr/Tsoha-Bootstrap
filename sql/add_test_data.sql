INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('käyttäjä1', 'salasana1');
INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('käyttäjä2', 'salasana2');

INSERT INTO Tehtava (kayttajaId, nimi, kuvaus, prioriteetti, lisayspaiva) VALUES ((SELECT id FROM Kayttaja WHERE kayttajatunnus='käyttäjä1'), 'testitehtävä1', 'kuvaus', 5, '2016-04-01');
INSERT INTO Tehtava (kayttajaId, nimi, kuvaus, prioriteetti, lisayspaiva) VALUES ((SELECT id FROM Kayttaja WHERE kayttajatunnus='käyttäjä2'), 'testitehtävä2', 'lisäinfoa', 4, '2016-04-01');

INSERT INTO Luokka (kayttajaId, nimi) VALUES ((SELECT id FROM Kayttaja WHERE kayttajatunnus='käyttäjä1'), 'testiluokka1');
INSERT INTO Luokka (kayttajaId, nimi) VALUES ((SELECT id FROM Kayttaja WHERE kayttajatunnus='käyttäjä1'), 'testiluokka2');
INSERT INTO Luokka (kayttajaId, nimi) VALUES ((SELECT id FROM Kayttaja WHERE kayttajatunnus='käyttäjä2'), 'testiluokka3');

INSERT INTO TehtavanLuokka (tehtavaId, luokkaId) VALUES ((SELECT id FROM Tehtava WHERE nimi='testitehtävä1'), (SELECT id FROM Luokka WHERE nimi='testiluokka1'));
INSERT INTO TehtavanLuokka (tehtavaId, luokkaId) VALUES ((SELECT id FROM Tehtava WHERE nimi='testitehtävä1'), (SELECT id FROM Luokka WHERE nimi='testiluokka2'));
INSERT INTO TehtavanLuokka (tehtavaId, luokkaId) VALUES ((SELECT id FROM Tehtava WHERE nimi='testitehtävä2'), (SELECT id FROM Luokka WHERE nimi='testiluokka3'));