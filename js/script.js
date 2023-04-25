function searchTable() {

    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase(); // Set filter value to text in input
    table = document.getElementById("movie_table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide the ones that don't match
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            console.log();
            if (txtValue.toUpperCase().indexOf(filter) > -1 || td.parentElement.parentElement.tagName == "THEAD") {
                tr[i].style.display = "";
            } 
            else {
                tr[i].style.display = "none";
            }
        }
    }

}

function filterTable() {
    
}