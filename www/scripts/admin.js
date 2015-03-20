function changeUserAdmin(button) {
    var buttonPlace = button.parentNode, targetTR = buttonPlace.parentNode, userID = targetTR.children[0].innerText;
    var userPrivilege = targetTR.children[targetTR.children.length - 2];
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.name = 'userIdAdmin';
    input.value = userID;
    input.type = 'hidden';
    form.appendChild(input);
    var selectPrivilege = document.createElement('select');
    selectPrivilege.name = 'userPrivilegeAdmin';
    for (var i = 0; i<=4; i+=1) {
        var option = document.createElement('option');
        option.value = i;
        if (i==0) {
            option.innerHTML = 'user';
        }
        else if (i==1) {
            option.innerHTML = 'admin';
        }
        else if (i==2) {
            option.innerHTML = 'moderator';
        }
        else if (i==3) {
            option.innerHTML = 'writer';
        }
        else if (i==4) {
            option.innerHTML = 'banned';
        }
        if (option.innerHTML == userPrivilege.innerText) {
            option.selected = true;
        }
        selectPrivilege.appendChild(option);
    }
    form.appendChild(selectPrivilege);
    userPrivilege.innerHTML = '';
    userPrivilege.appendChild(form);
    var buttonDone = document.createElement('button');
    buttonDone.innerHTML = 'Готово';
    var buttonCancel = document.createElement('button');
    buttonCancel.innerHTML = 'Отмена';
    buttonPlace.innerHTML = '';
    buttonPlace.appendChild(buttonDone);
    buttonPlace.appendChild(buttonCancel);
    buttonCancel.onclick = function() {
        document.location.reload();
    }
    buttonDone.onclick = function() {
        form.submit();
        document.body.removeChild(form);
        form = '';
    }
}
function deleteUserAdmin(button) {
    var buttonPlace = button.parentNode, targetTR = buttonPlace.parentNode, userID = targetTR.children[0].innerText;
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.name = 'userIdAdminDelete';
    input.value = userID;
    input.type = 'hidden';
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    form = '';
}