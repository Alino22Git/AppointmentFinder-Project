<?php
class Appointment {
    public $id;
    public $titel;
    public $ort;
    public $dauer;
    public $ablaufdatum;
    public $beschreibung;

    function __construct($id, $tit, $ort,$dauer, $adatum, $besc) {
        $this->id = $id;
        $this->titel = $tit;
        $this->ort=$ort;
        $this->dauer=$dauer;
        $this->ablaufdatum=$adatum;
        $this->beschreibung=$besc;
    }
}
