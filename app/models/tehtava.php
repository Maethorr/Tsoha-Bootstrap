<?php

class Tehtava extends BaseModel {

    public $id, $kayttajaId, $nimi, $kuvaus, $prioriteetti, $lisayspaiva, $luokat;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Tehtava WHERE kayttajaId = :kayttajaId');
        $kysely->execute(array('kayttajaId' => $_SESSION['kayttajaId']));
        $rivit = $kysely->fetchAll();
        $tehtavat = array();
        foreach ($rivit as $rivi) {
            $luokat = array();
            $luokkakysely = DB::connection()->prepare('SELECT luokka.id, luokka.nimi FROM Tehtava, Luokka, TehtavanLuokka WHERE TehtavanLuokka.tehtavaId = Tehtava.id and TehtavanLuokka.luokkaId = Luokka.id and Tehtava.id = :id');
            $luokkakysely->execute(array('id' => $rivi['id']));
            $luokkarivit = $luokkakysely->fetchAll();
            foreach ($luokkarivit as $luokkarivi) {
                $luokat[] = new Luokka(array(
                    'id' => $luokkarivi['id'],
                    'nimi' => $luokkarivi['nimi']
                ));
            }
            $tehtavat[] = new Tehtava(array(
                'id' => $rivi['id'],
                'kayttajaId' => $rivi['kayttajaId'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'prioriteetti' => $rivi['prioriteetti'],
                'lisayspaiva' => $rivi['lisayspaiva'],
                'luokat' => $luokat
            ));
            unset($luokat);
        }
        return $tehtavat;
    }

    public static function find($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Tehtava WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();
        $luokkakysely = DB::connection()->prepare('SELECT Luokka.id, Luokka.nimi FROM Tehtava, Luokka, TehtavanLuokka WHERE TehtavanLuokka.tehtavaId = tehtava.id and TehtavanLuokka.luokkaId = Luokka.id and Tehtava.id = :id');
        $luokkakysely->execute(array('id' => $id));
        $luokkarivit = $luokkakysely->fetchAll();
        $luokat = array();
        foreach ($luokkarivit as $luokkarivi) {
            $luokat[] = new Luokka(array(
                'id' => $luokkarivi['id'],
                'nimi' => $luokkarivi['nimi']
            ));
        }
        if ($rivi) {
            $tehtava = new Tehtava(array(
                'id' => $rivi['id'],
                'kayttajaId' => $rivi['kayttajaId'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'prioriteetti' => $rivi['prioriteetti'],
                'lisayspaiva' => $rivi['lisayspaiva'],
                'luokat' => $luokat
            ));
        }
        return $tehtava;
    }

    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Tehtava (kayttajaId, nimi, kuvaus, prioriteetti, lisayspaiva) values (:kayttajaId, :nimi, :kuvaus, :prioriteetti, now()) RETURNING id');
        $kysely->execute(array('kayttaja' => $_SESSION['kayttaja'], 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
        foreach ($this->luokat as $luokka) {
            $luokkakysely = DB::connection()->prepare('INSERT INTO Luokat (luokka, tehtava) VALUES (:luokka, :tehtava)');
            $luokkakysely->execute(array('luokka' => $luokka, 'tehtava' => $this->id));
            $rivi = $kysely->fetch();
        }
    }

}
