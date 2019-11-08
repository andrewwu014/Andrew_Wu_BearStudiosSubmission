function regCheck() {
    document.getElementById('regModal').style.display = 'none';
    const email = document.getElementById("userEmail").value;
    const username = document.getElementById("user").value;
    const password = document.getElementById("pass").value;
    const data = { 'email': email, 'user': username, 'pass': password };

    fetch('ACBRegister.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(function(stuff) {
            console.log(JSON.stringify(stuff));
            let result = JSON.parse(JSON.stringify(stuff));
            // if register success
            if (result.success) {
                let userid = result.user;
                $("#loginBlock").hide();
                $("#regBlock").hide();
                $("#userHead").show();
                document.getElementById("logoutBlock").style.display = "inline";
                document.getElementsByClassName("userHeader")[0].textContent = "Registration successful. Now logged in as: " + userid;
            } else {
                alert(result.message);
            }
        })
        .catch(error => console.error('Error:', error));
}
document.getElementById("reg_btn").addEventListener("click", regCheck, false);
// End Citation