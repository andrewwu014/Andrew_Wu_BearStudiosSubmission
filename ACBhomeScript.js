function logout() {
    fetch('ACB_logout.php')
        .then(function(stuff) {
            document.getElementById("logoutBlock").style.display = "none";
            $("#userHead").hide();
            $("#loginBlock").show();
            $("#regBlock").show();
            $("#edit").hide();
            user_id = "";
        }).catch(function(error) {
            console.log("Found an error " + error);
        });
}
document.getElementById("logout_btn").addEventListener("click", logout, false);


function showDrop() {
    document.getElementById("myDropdown").classList.toggle("show");
}

//Closes dropdown menu if user clicks anywhere elseß
let modal = document.getElementById('ticketModal');
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        let dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    } else if (event.target == modal) {
        modal.style.display = "none";
    }
}

window.onload = logout();