function checkUsernameOrEmail() {
    let input = document.querySelector("#usernameOrEmail");
    let usernameOrEmail = input.value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check_username.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Construct the data to be sent
    let data = "usernameOrEmail=" + encodeURIComponent(usernameOrEmail);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            handleUsernameOrEmailCheck(xhr.responseText);
        }
    };

    xhr.send(data);
}

function handleUsernameOrEmailCheck(response) {
    // Assuming that you have an element with the id 'usernameOrEmailMessage'
    let messageElement = document.getElementById('usernameOrEmailMessage');

    if (response == "1") {
        messageElement.textContent = "Uživatelské jméno už existuje";
    } else {
        messageElement.textContent = "";
    }
}

let input = document.querySelector("#usernameOrEmail");
input.addEventListener("input", checkUsernameOrEmail);