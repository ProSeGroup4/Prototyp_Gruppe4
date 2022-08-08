function auswahl() {
    var text="";
    /* jede Checkbox überprüfen und wenn ausgewählt dann auflisten : */
    checkboxes = document.getElementsByName('foo');
    // Füge alle IDs als String zusammen, wo die dazugehörige Checkbox markiert ist
    for(var i=0, n=checkboxes.length;i<n;i++) {
        if(checkboxes[i].checked) {
            text=text+checkboxes[i].id+"\n";
        }
    }
    // nehme das Element mit ID "ausgewählteAufträge" und überführe den text als HTMl und setze es in "ausgewählteAufträge"
    document.getElementById("ausgewählteAufträge").innerHTML = text;

}

function dataShare() {
    var aktiveAufträge = Array();                       /* Diese Variable speichert die ausgewählten Aufträge, kann dann im Backend eingespeist werden!*/
    /* jede Checkbox überprüfen und wenn ausgewaehlt dann speichern : */
    checkboxes = document.getElementsByName('foo');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        if(checkboxes[i].checked) {
            aktiveAufträge.push(checkboxes[i].id);      /*Alle Aufträge sind standardmäßig ausgewählt! Deshalb kann Backend die Auftrags-DB ziehen,
                                                        im Sonderfall "nicht alle Aufträge sind ausgewählt" kann Backend die Variable "aktiveAufträge" (links) nutzen.*/
        }
    }
}


