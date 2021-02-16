document.getElementById('remove-user').addEventListener('click', function () {
    const userId = this.dataset.userId;
    const userName = this.dataset.userName;

    removeUsers([{ id:
        userId, name: userName }]);
});

function removeSelectedUsers() {
    const selectedUsers = document.getElementsByName('users[]');
    const users = [];

    for (let i = 0; i < selectedUsers.length; ++i) {
        if (selectedUsers[i].checked) {
            let data = JSON.parse(selectedUsers[i].getAttribute('data-user'));
            users.push(data);
        }
    }

    removeUsers(users);
}

function removeUsers(users) {
    const userNames = users.map(user => `- ${user.name}`);

    if (!confirm(`This users will be deleted: \n ${userNames.join("\n")}`)) {
        return;
    }

    sendPost('/index.php?controller=user&action=delete', `users=${JSON.stringify(users.map(user => user.id))}`);
}

function checkPasswordsEqual(form) {
    const password1 = form.password.value;
    const password2 = form.repeat_password.value;

    if (password1 === '' && password2 === '' && form.formMode.value === 'edit') {
        return true;
    }

    if (password1 === '') {
        alert ("Please enter Password");

        return false;
    }

    if (password2 === '') {
        alert ("Please repeat password");

        return false;
    }

    if (password1 !== password2) {
        alert ("\nPasswords not matching")

        return false;
    }

    return true;
}

function sendPost(url, data) {
    const xhr = new XMLHttpRequest();

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            const responseText = JSON.parse(xhr.responseText);

            if (!responseText.error) {
                alert(responseText.message);
                window.location.href = '?controller=user&action=list';

                return;
            }
        }

        alert('Error removing user');
    };

    xhr.send(data);
}