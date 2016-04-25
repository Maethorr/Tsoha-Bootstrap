<?php

class Tehtava extends BaseModel {

    public $id, $kayttajaid, $nimi, $kuvaus, $prioriteetti, $lisayspaiva, $luokat;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->tarkistukset = array('tarkista_nimi', 'tarkista_nimi2', 'tarkista_prioriteetti', 'tarkista_kuvaus');
    }

    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Tehtava WHERE kayttajaid = :kayttajaid');
        $kysely->execute(array('kayttajaid' => $_SESSION['kayttajaid']));
        $rivit = $kysely->fetchAll();
        $tehtavat = array();

        foreach ($rivit as $rivi) {
            $luokat = array();
            $luokkakysely = DB::connection()->prepare('SELECT Luokka.id, Luokka.nimi FROM Tehtava, Luokka, TehtavanLuokka WHERE TehtavanLuokka.tehtavaid = Tehtava.id and TehtavanLuokka.luokkaid = Luokka.id and Tehtava.id = :id');
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
                'kayttajaid' => $rivi['kayttajaid'],
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

        $luokkakysely = DB::connection()->prepare('SELECT Luokka.id, Luokka.nimi FROM Tehtava, Luokka, TehtavanLuokka WHERE TehtavanLuokka.tehtavaid = Tehtava.id and TehtavanLuokka.luokkaid = Luokka.id and Tehtava.id = :id');
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
                'kayttajaid' => $rivi['kayttajaid'],
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
        $kysely = DB::connection()->prepare('INSERT INTO Tehtava (kayttajaid, nimi, kuvaus, prioriteetti, lisayspaiva) VALUES (:kayttajaid, :nimi, :kuvaus, :prioriteetti, now()) RETURNING id');
        $kysely->execute(array('kayttajaid' => $_SESSION['kayttajaid'], 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];

        foreach ($this->luokat as $luokka) {
            $luokkakysely = DB::connection()->prepare('INSERT INTO TehtavanLuokka (tehtavaid, luokkaid) VALUES (:tehtavaid, :luokkaid)');
            $luokkakysely->execute(array('tehtavaid' => $this->id, 'luokkaid' => $luokka));
            $rivi = $kysely->fetch();
        }
    }

    public function tarkista_nimi() {
        $virheet = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $virheet[] = 'Tehtävällä täytyy olla nimi';
        }
        return $virheet;
    }

    public function tarkista_nimi2() {
        $virheet = array();
        if (strlen($this->nimi) > 50) {
            $virheet[] = 'Tehtävän nimen enimmäispituus on 50 merkkiä';
        }
        return $virheet;
    }

    public function tarkista_prioriteetti() {
        $virheet = array();
        if ($this->prioriteetti < 1 || $this->prioriteetti > 5) {
            $virheet[] = 'Prioriteetin on oltava välillä 1-5';
        }
        return $virheet;
    }

    public function tarkista_kuvaus() {
        $virheet = array();
        if (strlen($this->kuvaus) > 500) {
            $virheet[] = 'Kuvauksen enimmäispituus on 500 merkkiä';
        }
        return $virheet;
    }

    public function paivita() {
        $kysely = DB::connection()->prepare('UPDATE Tehtava set (nimi, kuvaus, prioriteetti) = (:nimi, :kuvaus, :prioriteetti) WHERE id = :id');
        $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti));
        $rivi = $kysely->fetch();
        $tyhjenna_luokat = DB::connection()->prepare('DELETE FROM TehtavanLuokka WHERE tehtavaid = :tehtavaid');
        $tyhjenna_luokat->execute(array('tehtavaid' => $this->id));
        $rivi = $kysely->fetch();
        foreach ($this->luokat as $luokka) {
            $luokkakysely = DB::connection()->prepare('INSERT INTO TehtavanLuokka (tehtavaid, luokkaid) VALUES (:tehtavaid, :luokkaid)');
            $luokkakysely->execute(array('tehtavaid' => $this->id, 'luokkaid' => $luokka->id));
            $rivi = $kysely->fetch();
        }
    }

    public function poista() {
        $luokkakysely = DB::connection()->prepare('DELETE FROM TehtavanLuokka WHERE tehtavaid = :tehtavaid');
        $luokkakysely->execute(array('tehtavaid' => $this->id));
        $rivi = $luokkakysely->fetch();
        $kysely = DB::connection()->prepare('DELETE FROM Tehtava WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
        $rivi = $kysely->fetch();
    }

}
