<?php

class Tehtava extends BaseModel {

    public $id, $kayttajaid, $nimi, $kuvaus, $prioriteetti, $lisayspaiva, $luokat;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
        $query = DB::connection()->prepare('INSERT INTO Tehtava (kayttajaid, nimi, kuvaus, prioriteetti, lisayspaiva) VALUES (:kayttajaid, :nimi, :kuvaus, :prioriteetti, now()) RETURNING id');
        $query->execute(array('kayttajaid' => $this->kayttajaid, 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];

        foreach ($this->luokat as $luokka) {
            $luokkakysely = DB::connection()->prepare('INSERT INTO TehtavanLuokka (tehtavaid, luokkaid) VALUES (:tehtavaid, :luokkaid)');
            $luokkakysely->execute(array('tehtavaid' => $this->id, 'luokkaid' => $luokkaid));
            $rivi = $kysely->fetch();
        }
    }

    public function paivita() {
        $kysely = DB::connection()->prepare('UPDATE Tehtava set (nimi, kuvaus, prioriteetti) = (:nimi, :kuvaus, :prioriteetti) WHERE id = :id');
        $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti));
        $rivi = $kysely->fetch();
        $tyhjenna_luokat = DB::connection()->prepare('DELETE FROM TehtavanLuokka WHERE tehtavaid = :tehtavaid');
        $tyhjenna_luokat->execute(array('tehtava' => $this->id));
        $rivi = $kysely->fetch();
        $luokat = $this->luokat;
        foreach ($luokat as $luokka) {
            $luokkakysely = DB::connection()->prepare('INSERT INTO TehtavanLuokka (tehtavaid, luokkaid) VALUES (:tehtavaid, :luokkaid)');
            $luokkakysely->execute(array('tehtavaid' => $this->id, 'luokkaid' => $luokkaid));
            $rivi = $kysely->fetch();
        }
    }

    public function poista() {
        $luokkakysely = DB::connection()->prepare('DELETE FROM TehtavanLuokka WHERE tehtavaid = :tehtavaid');
        $luokkakysely->execute(array('tehtava' => $this->id));
        $rivi = $luokkakysely->fetch();
        $kysely = DB::connection()->prepare('DELETE FROM Tehtava Where id = :id');
        $kysely->execute(array('id' => $this->id));
        $rivi = $kysely->fetch();
    }

}
