<?php
include("db/dataHandler.php");

class SimpleLogic
{
    private $dh;
    function __construct()
    {
        $this->dh = new DataHandler();
    }

    function handleRequest($method, $param)
    {
        switch ($method) {
            case "allAppointments":
                $res = $this->dh->queryAppointments();
                break;
            case "saveAppointment":
                $this->dh->saveAppointment($param);
                $res = null;
                break;
            case "detailedAppointments":
                $res = $this->dh->queryDetailedAppointmentsById($param);
                break;
            case "kommentare":
                $res = $this->dh->queryKommentareById($param);
                break;
            case "saveOptionAppointment":
                $this->dh->saveOptionAppointment($param);
                $res = null;
                break;
            case "saveKommentar":
                $this->dh->saveKommentar($param);
                $res = null;
                break;
            default:
                $res = null;
                break;
        }
        return $res;
    }
}