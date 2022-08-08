function sortTableByColumn(table, column, asc = true) {
    const dirModifier = asc ? 1 : -1; // Konstante der sortier Richtung
    const tBody = table.tBodies[0]; // Konstante der Tabelle
    const rows = Array.from(tBody.querySelectorAll("tr")); // Konstante der Zeilen

    // Jede Zeile sortieren
    const sortedRows = rows.sort((a, b) => {
        const aColText = a.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();
        const bColText = b.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();

        return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
    });

    // Alle vorhandenen TRs von Tabelle entfernen
    while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
    }

    // Neue Sortierung der Zeilen hinzufügen
    tBody.append(...sortedRows);

    // Merken wie die Tabelle aktuelle sortiert ist
    table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-asc", asc);
    table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-desc", !asc);
}
