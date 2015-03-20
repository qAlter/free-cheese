function phone(name) {
    "use strict";
    var r = /([0-9])+/g, arr = name.match(r), res, str = arr.join('');
    if (name.substr(0, 1) === '+') {
        res = "+" + str;
    } else if (str.substr(0, 1) === '8') {
        res = "+7" + str.substr(1);
    } else {
        res = str;
    }
    return res;
}
function reg(button) {
    if (check(button)) {
        button.children[0].submit();
        button.removeChild(button.children[0]);
    }
}
function checkLocation(select) {
    var targetTD = select.parentNode;
    var input = targetTD.children[1];
    var targetTR = targetTD.parentNode;
    if (targetTR.rowIndex == '1') {
        var tbody = targetTR.parentNode;
        var newTR = tbody.children[targetTR.rowIndex + 1];
        var phoneTR = tbody.children[targetTR.rowIndex + 2];
        var newTD = newTR.children[1];
        var phoneTD = phoneTR.children[1]
        var newSelect = newTD.children[0];
        var newInput = newTD.children[1];
        var phoneInput = phoneTD.children[0]
        if (select.value == '2') {
            newSelect.children[newSelect.children.length-1].selected = true;
            newSelect.disabled = true;
            newInput.disabled = false;
            phoneInput.disabled = true;
        }
        else {
            newSelect.children[0].selected = true;
            newSelect.disabled = false;
            newInput.disabled = true;
            newInput.value = '';
            phoneInput.disabled = false;
        }
    }
    if (select.value == '0' || select.value == '1') {
        input.value = '';
        input.disabled = true;
    }
    else {
        input.disabled = false;
    }
}
var warningDone = false;
function warning(select) {
    if (!warningDone) {
        message('Внимание! Если Вы, в случае выигрыша, сможете забрать свой приз в Москве лично, то при регистрации указывайте город "Москва", в противном случае указывайте свой родной город и на данный момент розыгрыши будут Вам не доступны!', 'no', 'Оповещение');
        warningDone = true;
    }
    else {
        return false;
    }
}
function check(button) {
    if (!document.getElementById('regForm')) {
        var regForm = document.createElement('form');
        regForm.id = 'regForm';
        regForm.method = 'post';
        button.appendChild(regForm);
    }
    var regForm = document.getElementById('regForm');
    regForm.innerHTML = '';
    var regBlocks = document.querySelectorAll('.registration.important');
    var regInputs = [], error = true;
    for (var i=0; i<regBlocks.length; i+=1) {
        regInputs[i] = regBlocks[i].getElementsByTagName('input');
    }
    for (var i=0; i<regInputs.length; i+=1) {
        for (var j=0; j<regInputs[i].length; j+=1) {
            var targetTd = regInputs[i][j].parentElement;
            if (regInputs[i][j].value == '') {
                if (i==1 && j==3) {
                    targetTd.parentNode.children[2].innerHTML = '';
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.value = regInputs[i][j].value;
                    input.name = regForm.children.length;
                    regForm.appendChild(input);
                    continue;
                }
                if (i==1 && (j==1 || j==2)) {
                    var select = targetTd.children[0];
                    if (select.value == 1) {
                        targetTd.parentNode.children[2].innerHTML = '';
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        var inner;
                        if (j==1) {
                            inner = 'Россия';
                        }
                        else {
                            inner = 'Москва';
                        }
                        input.value = inner;
                        input.name = regForm.children.length;
                        regForm.appendChild(input);
                        continue;
                    }
                }
                targetTd.parentNode.children[2].innerHTML = 'Обязательное поле!';
                error = false;
                break;
            }
            else {
                targetTd.parentNode.children[2].innerHTML = '';
                var input = document.createElement('input');
                input.type = 'hidden';
                input.value = regInputs[i][j].value;
                if (i==1 && j==3) {
                    input.value = phone(regInputs[i][j].value);
                }
                input.name = regForm.children.length;
                regForm.appendChild(input);
            }
            if (i==0 && j==2) {
                if (regInputs[i][j].value != regInputs[i][j-1].value) {
                    targetTd.parentNode.children[2].innerHTML = 'Не совпадают!';
                    error = false;
                    regInputs[i][j].focus();
                    break;
                }
            }
        }
    }
    regBlocks = document.querySelectorAll('.registration')[2];
    var lastInputs = regBlocks.getElementsByTagName('input');
    for (var i=0; i<lastInputs.length; i+=1) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.value = lastInputs[i].value;
        input.name = regForm.children.length;
        regForm.appendChild(input);
    }
    return error;
}