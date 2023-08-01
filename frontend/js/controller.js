var terminListe = document.getElementById("terminListe");
var detailTerminListe = document.getElementById("detailTerminListe");
let liveTerminID = "";
let liveOptionTerminID= "";
//Starting point for JQuery init
$(document).ready(function () {
    //$("#searchResult").hide();
    //$("#btn_Search").click(function (e) {
    //loaddata($("#seachfield").val());
    loaddata("GET", "allAppointments");
    //});
});

function loaddata(type, method, data) {
    $.ajax({
        type: type,
        url: "backend/serviceHandler.php",
        //cache: false,
        data: { type: type, method: method, param: data },
        dataType: "json",
        success: function (response) {
            if (method == "allAppointments") {
                console.log(response);
                // Tabelle mit den Terminen füllen
                $.each(response, function (i, termin) {
                    var tr = $('<tr>');
                    tr.attr("id", termin.id);
                    tr.append($('<td>').text(termin.titel));
                    tr.append($('<td>').text(termin.ort));
                    tr.append($('<td>').text(termin.dauer));
                    tr.append($('<td>').text(termin.ablaufdatum));
                    tr.append($('<td>').text(termin.beschreibung));
                    $('#termine-tabelle').append(tr);
                });
            } else if (method == "detailedAppointments") {

                document.getElementById("detailansicht").style.display = "none";
                document.getElementById("kommentaransicht").style.display = "none";
                $('#detail-termine-tabelle').empty();
                $('#kommentar-tabelle').empty();
                if (response != "Keine Daten") {
                    // Detailansicht anzeigen
                    document.getElementById("detailansicht").style.display = "block";
                    $.each(response, function (i, terminoption) {
                        var tr = $('<tr>');
                        tr.attr("id", terminoption.id);
                        tr.append($('<td>').text((terminoption.von).slice(0, 5)));
                        tr.append($('<td>').text((terminoption.bis).slice(0, 5)));
                        tr.append($('<td>').text(terminoption.vote));
                        $('#detail-termine-tabelle').append(tr);
                    });
                    
                }

            } else if (method == "kommentare") {

                document.getElementById("kommentaransicht").style.display = "none";
                $('#kommentar-tabelle').empty();
                if (response != "Keine Daten") {
                    // Detailansicht anzeigen
                    document.getElementById("kommentaransicht").style.display = "block";
                    $.each(response, function (i, kommentare) {
                        var tr = $('<tr>');
                        tr.attr("id", kommentare.id);
                        tr.append($('<td>').text(kommentare.name));
                        tr.append($('<td>').text(kommentare.kommentar));
                        if (kommentare.teilnahme == 1) {
                            tr.append($('<td>').text("positiv"));
                        } else {
                            tr.append($('<td>').text("negativ"));
                        }

                        $('#kommentar-tabelle').append(tr);
                    });
                }
            }
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function saveAppointment(event) {
    //event.preventDefault();
    data = new Array();
    data.push(document.getElementById("titel").value);
    data.push(document.getElementById("ort").value);
    data.push(document.getElementById("dauer").value);
    data.push(document.getElementById("ablaufdatum").value);
    data.push(document.getElementById("beschreibung").value);
    console.log(data);
    loaddata("POST", "saveAppointment", data);
}

function saveOptionAppointment(event) {
    //event.preventDefault();
    data = new Array();
    data.push(document.getElementById("von").value);
    data.push(document.getElementById("bis").value);
    data.push(0);
    data.push(liveTerminID);
    console.log(data);
    loaddata("POST", "saveOptionAppointment", data);
}

function saveKommentar(event) {
    //event.preventDefault();
    data = new Array();
    data.push(document.getElementById("name").value);
    data.push(document.getElementById("kommentar").value);
    var voteCheckbox = document.getElementById('vote');
    if (voteCheckbox.checked) {
        data.push(1);
    } else {
        data.push(0);
    }
    data.push(liveOptionTerminID);
    console.log(data);
    loaddata("POST", "saveKommentar", data);
}

function showAppointmentForm() {
    var myDiv = document.getElementById("addAppointment");
    var myBtn = document.getElementById("showAddAppointmentBtn");

    // Wir fügen die CSS-Klasse hinzu
    myDiv.style.display = "block";
    myBtn.style.display = "none";
};

function showOptionAppointmentForm() {
    document.getElementById("showKommentarFormBtn").style.display = "none";
    document.getElementById("kommentaransicht").style.display = "none";
    document.getElementById("addKommentar").style.display = "none";
    $('#kommentar-tabelle').empty();
    var myDiv = document.getElementById("addOptionAppointment");
    var myBtn = document.getElementById("showAddOptionAppointmentBtn");

    // Wir fügen die CSS-Klasse hinzu
    myDiv.style.display = "block";
    myBtn.style.display = "none";
};


function showKommentarForm() {
    document.getElementById("addOptionAppointment").style.display="none";

    var myDiv = document.getElementById("addKommentar");
    var myBtn = document.getElementById("showKommentarFormBtn");

    // Wir fügen die CSS-Klasse hinzu
    myDiv.style.display = "block";
    myBtn.style.display = "none";
};

terminListe.addEventListener("click", function (event) {
    document.getElementById("showKommentarFormBtn").style.display = "none";
    document.getElementById("addKommentar").style.display = "none";
    document.getElementById("addOptionAppointment").style.display = "none";
    document.getElementById("showAddOptionAppointmentBtn").style.display = "block";
    const clickedRow = event.target.closest('tr'); // findet die geklickte Zeile
    const id = clickedRow.getAttribute('id');
    if (id > 0) {
        console.log('Die ID der geklickten Zeile ist:', id);
        // AJAX-Aufruf, um Details des Termins zu laden
        loaddata("GET", "detailedAppointments", id);
        liveTerminID = id;
    }
})

detailTerminListe.addEventListener("click", function (event) {
    document.getElementById("showKommentarFormBtn").style.display = "block";
    document.getElementById("addKommentar").style.display = "none";
    const clickedRow = event.target.closest('tr'); // findet die geklickte Zeile
    const id = clickedRow.getAttribute('id');
    if (id > 0) {
        console.log('Die ID der geklickten Zeile ist:', id);
        // AJAX-Aufruf, um Details des Termins zu laden
        loaddata("GET", "kommentare", id);
        liveOptionTerminID=id;
    }
})