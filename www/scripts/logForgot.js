function next() {
    var loginBlock = document.getElementById('loginBlock');
    var inputs = loginBlock.getElementsByTagName('input');
    inputs[1].focus();
}
function logout() {
    var logoutForm = document.createElement('form');
    logoutForm.method = 'post';
    var logoutValue = document.createElement('input');
    logoutValue.type = 'hidden';
    logoutValue.name = 'logout';
    logoutValue.value = true;
    logoutForm.appendChild(logoutValue);
    document.body.appendChild(logoutForm);
    logoutForm.submit();
}
function submit(login, password) {
    var loginForm = document.createElement('form');
    loginForm.method = 'post';
    var log = document.createElement('input');
    log.type = 'hidden';
    log.name = 'login';
    log.value = login;
    var pas = document.createElement('input');
    pas.type = 'hidden';
    pas.name = 'password';
    pas.value = password;
    loginForm.appendChild(log);
    loginForm.appendChild(pas);
    document.body.appendChild(loginForm);
    loginForm.submit();
}
function forgot(email) {
    if (email) {
        var forgotForm = document.createElement('form');
        forgotForm.method = 'post';
        var mail = document.createElement('input');
        mail.type = 'hidden';
        mail.name = 'mail';
        mail.value = email;
        forgotForm.appendChild(mail);
        document.body.appendChild(forgotForm);
        forgotForm.submit();
    }
    else {
        login(true);
    }
}
function login(forget) {
    function nextStep() {
        var block = document.createElement('div');
        block.id = 'loginPanel';
        block.className = 'inviteBlock animated fadeInDownBig';
        mask.appendChild(block);
        var content = document.createElement('div');
        content.className = 'inviteContent';
        block.appendChild(content);
        var header = document.createElement('div');
        header.className = 'colorHeader orange';
        var headerText = document.createElement('span');
        if (forget) headerText.innerHTML = 'Забыли пароль';
        else headerText.innerHTML = 'Вход';
        header.appendChild(headerText);
        content.appendChild(header);
        var contentText = document.createElement('span');
        if (forget) contentText.innerHTML = 'Введите Ваш e-mail, мы вышлем Вам пароль';
        else contentText.innerHTML = 'Введите Ваши данные для входа';
        content.appendChild(contentText);
        var contentTable = document.createElement('table');
        if (forget) contentTable.style.marginTop = '15px';
        for (var i=0; i<2; i+=1) {
            var tableTR = document.createElement('tr');
            contentTable.appendChild(tableTR);
            for (var j=0; j<2; j+=1) {
                var tableTD = document.createElement('td');
                tableTR.appendChild(tableTD);
                if (j==0) {
                    if (i==0) {
                        tableTD.innerHTML = 'E-mail';
                    }
                    else {
                        if (forget) {
                            tableTD.colSpan = '2';
                            tableTD.style.textAlign = 'center';
                            tableTD.style.fontSize = '12px';
                            tableTD.textDecoration = 'underline';
                            tableTD.innerHTML = '<a onclick="login()" style="cursor: pointer">Я вспомнил!</a> '
                        }
                        else {
                            tableTD.innerHTML = 'Пароль';
                        }
                    }
                }
                else {
                    if (i==0) {
                        var tableInput = document.createElement('input');
                        tableInput.type = 'text';
                        tableInput.id = 'tableLogin';
                        tableInput.value = inputs[0].value;
                        tableTD.appendChild(tableInput);
                    }
                    else if (i==1) {
                        if (!forget) {
                            var tableInput = document.createElement('input');
                            tableInput.type = 'password';
                            tableInput.id = 'tablePassword';
                            tableInput.value = inputs[1].value;
                            tableTD.appendChild(tableInput);
                        }
                    }
                }
            }
        }
        content.appendChild(contentTable);
        var buttonYes = document.createElement('button');
        buttonYes.className = 'inviteButton';
        buttonYes.style.padding = '8px 0';
        if (forget) buttonYes.style.marginTop = '15px';
        buttonYes.innerHTML = 'Готово';
        buttonYes.onclick = function() {
            var login = document.getElementById('tableLogin'), password = document.getElementById('tablePassword');
            if (forget) {
                if (login.value != '') {
                    block.className = 'inviteBlock animated fadeOutUpBig';
                    setTimeout(accept, 500);
                    forgot(login.value);
                }
                else {
                    login.placeholder = 'Введите e-mail!';
                }
            }
            else {
                if (login.value != '' && password.value != '') {
                    block.className = 'inviteBlock animated fadeOutUpBig';
                    setTimeout(accept, 500);
                    submit(login.value, password.value);
                }
                else {
                    if (login.value == '') {
                        login.placeholder = 'Введите e-mail!';
                    }
                    if (password.value == '') {
                        password.placeholder = 'Введите пароль!';
                    }
                }
            }
        }
        content.appendChild(buttonYes);
        function accept() {
            document.body.removeChild(mask);
        }
        var buttonNo = document.createElement('button');
        buttonNo.className = 'inviteButton';
        buttonNo.style.padding = '8px 0';
        if (forget) buttonNo.style.marginTop = '15px';
        buttonNo.innerHTML = 'Отмена';
        buttonNo.onclick = function() {
            block.className = 'inviteBlock animated fadeOutUpBig';
            setTimeout(deleteMask, 500);
        }
        function deleteMask() {
            document.body.removeChild(mask);
        }
        content.appendChild(buttonNo)
    }
    if (!document.getElementById('loginPanel')) {
        var loginBlock = document.getElementById('loginBlock');
        var inputs = loginBlock.getElementsByTagName('input');
        if (inputs[0].value != '' && inputs[1].value != '') {
            submit(inputs[0].value, inputs[1].value);
        }
        else {
            if (document.getElementById('inviteMask')) {
                var mask = document.getElementById('inviteMask');
                mask.children[0].className = 'inviteBlock animated fadeOutUpBig';
                function removeBlock() {
                    mask.removeChild(mask.children[0]);
                    nextStep();
                }
                setTimeout(removeBlock, 500);

            }
            else {
                var mask = document.createElement('div');
                mask.className = 'inviteMask';
                mask.id = 'inviteMask';
                document.body.appendChild(mask);
                nextStep();
            }
        }
    }
    else {
        var loginPanel = document.getElementById('loginPanel');
        loginPanel.id = 'inviteBlock';
        if (forget) {
            forgot();
        }
        else {
            login();
        }
    }
}