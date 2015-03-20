function changeNews(button) {
    var buttonTD = button.parentNode;
    var targetTR = buttonTD.parentNode;
    var values = [], length;
    if (targetTR.children.length == 8) {
        length = 1;
    }
    else {
        length = 0;
    }
    for (var i=0; i<targetTR.children.length-1; i+=1) {
        values[i] = targetTR.children[i].innerHTML;
        if (i==1+length) {
            targetTR.children[i].innerHTML = '';
            var input = document.createElement('input');
            input.name = 'oldNewsName';
            input.type = 'text';
            input.value = values[i];
            targetTR.children[i].appendChild(input);
        }
        else if (i==2+length) {
            targetTR.children[i].innerHTML = '';
            var textArea = document.createElement('textarea');
            textArea.name = 'oldNewsText';
            textArea.value = values[i];
            targetTR.children[i].appendChild(textArea);
        }
        else if (i==3+length) {
            targetTR.children[i].innerHTML = '';
            var avatar = document.createElement('input');
            avatar.name = 'oldNewsAva';
            avatar.placeholder = 'URL';
            avatar.type = 'text';
            targetTR.children[i].appendChild(avatar);
        }
        else if (i==4+length) {
            targetTR.children[i].innerHTML = '';
            var date = document.createElement('input');
            date.name = 'oldNewsStart';
            date.type = 'datetime-local';
            date.value = values[i].replace(' ', 'T').slice(0, 16);
            targetTR.children[i].appendChild(date);
        }
        else if (i==5+length) {
            targetTR.children[i].innerHTML = '';
            var date = document.createElement('input');
            date.name = 'oldNewsEnd';
            date.type = 'date';
            date.value = values[i];
            targetTR.children[i].appendChild(date);
        }
        var buttonDone = document.createElement('button');
        buttonDone.innerHTML = 'Готово';
        var buttonCancel = document.createElement('button');
        buttonCancel.innerHTML = 'Отмена';
        buttonTD.innerHTML = '';
        buttonTD.appendChild(buttonDone);
        buttonTD.appendChild(buttonCancel);
        buttonCancel.onclick = function() {
            document.location.reload();
        }
        buttonDone.onclick = function() {
            var form = document.createElement('form');
            form.method = 'post';
            for (var i=0; i<targetTR.children.length-1; i+=1) {
                if (targetTR.children[i].children.length == 0) {
                    if (i==0) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.value = targetTR.children[i].innerHTML;
                        input.name = 'oldNewsId';
                        form.appendChild(input);
                    }
                }
                else {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.value = targetTR.children[i].children[0].value;
                    if (i==1+length) {
                        input.name = 'oldNewsName';
                    }
                    else if (i==2+length) {
                        input.name = 'oldNewsText';
                    }
                    else if (i==3+length) {
                        input.name = 'oldNewsAva';
                    }
                    else if (i==4+length) {
                        input.name = 'oldNewsStart';
                        var sec = new Date();
                        if (sec.getSeconds() < 10) {
                            sec = '0' + sec.getSeconds();
                        }
                        else {
                            sec = sec.getSeconds();
                        }
                        input.value = targetTR.children[i].children[0].value.replace('T', ' ')+':'+sec;
                    }
                    else if (i==5+length) {
                        input.name = 'oldNewsEnd';
                    }
                    form.appendChild(input);
                }
            }
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            form = '';
        }
    }
}
function addNews(button) {
    var targetTR = button.parentNode.parentNode, check = true;
    for (var i=0; i<targetTR.children.length-1; i+=1) {
        if (targetTR.children[i].children[0].value == "") {
            check = false;
        }
    }
    if (check) {
        var form = document.createElement('form');
        form.method = 'post';
        for (var i=0; i<targetTR.children.length-1; i+=1) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.value = targetTR.children[i].children[0].value;
            if (i==0) {
                input.name = 'newsName';
            }
            else if (i==1) {
                input.name = 'newsText';
            }
            else if (i==2) {
                input.name = 'newsAva';
            }
            else if (i==3) {
                input.name = 'newsStart';
                var sec = new Date();
                if (sec.getSeconds() < 10) {
                    sec = '0' + sec.getSeconds();
                }
                else {
                    sec = sec.getSeconds();
                }
                input.value = targetTR.children[i].children[0].value.replace('T', ' ')+':'+sec;
            }
            else if (i==4) {
                input.name = 'newsEnd';
            }
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        form = '';
    }
    else {
        message('Вы заполнили не все строки!', 'no', 'Ошибка');
    }
}
function deleteNews(button) {
    var targetTR = button.parentNode.parentNode;
    var eventId = targetTR.children[0].innerText;
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = eventId;
    input.name = 'deleteNews';
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    form = '';
}
function changeArticle(button) {
    var targetTD = button.parentNode, targetTR = targetTD.parentNode, length, values = [];
    if (targetTR.children.length == 7) {
        length = 1;
    }
    else {
        length = 0;
    }
    for (var i=0; i<targetTR.children.length-1; i+=1) {
        values[i] = targetTR.children[i].innerHTML;
        if (i==1+length) {
            targetTR.children[i].innerHTML = '';
            var input = document.createElement('input');
            input.name = 'oldArticleName';
            input.type = 'text';
            input.value = values[i];
            targetTR.children[i].appendChild(input);
        }
        else if (i==2+length) {
            targetTR.children[i].innerHTML = '';
            var textArea = document.createElement('textarea');
            textArea.name = 'oldArticleText';
            textArea.value = values[i];
            targetTR.children[i].appendChild(textArea);
        }
        else if (i==3+length) {
            var oldInputs = targetTR.children[i].getElementsByTagName('input'), oldURL = [];
            for (var j=0; j<oldInputs.length; j+=1) {
                oldURL[j] = oldInputs[j].value;
            }
            targetTR.children[i].innerHTML = '';
            for (var j=0; j<oldURL.length; j+=1) {
                var input = document.createElement('input');
                input.name = 'oldArticleAva';
                input.placeholder = 'URL';
                input.type = 'text';
                input.value = oldURL[j];
                var br = document.createElement('br');
                targetTR.children[i].appendChild(input);
                targetTR.children[i].appendChild(br);
            }
            var avatar = document.createElement('input');
            avatar.name = 'oldArticleAva';
            avatar.placeholder = 'URL';
            avatar.type = 'text';
            targetTR.children[i].appendChild(avatar);
            var button = document.createElement('button');
            button.innerHTML = 'Еще';
            button.setAttribute('onclick', 'addArticleAva(this, "oldArticleAva")');
            targetTR.children[i].appendChild(button);
        }
        else if (i==4+length) {
            targetTR.children[i].innerHTML = '';
            var date = document.createElement('input');
            date.name = 'oldArticleStart';
            date.type = 'datetime-local';
            date.value = values[i].replace(' ', 'T').slice(0, 16);
            targetTR.children[i].appendChild(date);
        }
        var buttonDone = document.createElement('button');
        buttonDone.innerHTML = 'Готово';
        var buttonCancel = document.createElement('button');
        buttonCancel.innerHTML = 'Отмена';
        targetTD.innerHTML = '';
        targetTD.appendChild(buttonDone);
        targetTD.appendChild(buttonCancel);
        buttonCancel.onclick = function() {
            document.location.reload();
        }
        buttonDone.onclick = function() {
            var form = document.createElement('form');
            form.method = 'post';
            for (var i=0; i<targetTR.children.length-1; i+=1) {
                if (targetTR.children[i].children.length == 0) {
                    if (i==0) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.value = targetTR.children[i].innerHTML;
                        input.name = 'oldArticleId';
                        form.appendChild(input);
                    }
                }
                else {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.value = targetTR.children[i].children[0].value;
                    if (i==1+length) {
                        input.name = 'oldArticleName';
                    }
                    else if (i==2+length) {
                        input.name = 'oldArticleText';
                    }
                    else if (i==3+length) {
                        var targetTD = targetTR.children[i];
                        var inputs = targetTD.getElementsByTagName('input');
                        for (var j=0; j<inputs.length; j+=1) {
                            if (inputs[j].value != '') {
                                var newInput = document.createElement('input');
                                newInput.type = 'hidden';
                                newInput.value = inputs[j].value;
                                newInput.name = 'oldArticleAva[]';
                                form.appendChild(newInput);
                            }
                        }
                    }
                    else if (i==4+length) {
                        input.name = 'oldArticleStart';
                        var sec = new Date();
                        if (sec.getSeconds() < 10) {
                            sec = '0' + sec.getSeconds();
                        }
                        else {
                            sec = sec.getSeconds();
                        }
                        input.value = targetTR.children[i].children[0].value.replace('T', ' ')+':'+sec;
                    }
                    if (i!=3+length) {
                        form.appendChild(input);
                    }
                }
            }
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            form = '';
        }
    }
}
function addArticle(button) {
    var targetTD = button.parentNode, targetTR = targetTD.parentNode, check = true;
    for (var i=0; i<targetTR.children.length-1; i+=1) {
        if (targetTR.children[i].children[0].value == "") {
            check = false;
            if (i==2) {
                var inputs = targetTR.children[i].getElementsByTagName('input');
                if (inputs.length > 1) {
                    for (var j=0; j<inputs.length; j+=1) {
                        if (inputs[j].value != '') {
                            check = true;
                        }
                    }
                }
            }
        }
    }
    if (check) {
        var inputs = targetTR.children[2].getElementsByTagName('input');
        for (var j=inputs.length-1; j>=0; j-=1) {
            if (inputs[j].value == '') {
                var br = inputs[j].nextSibling;
                targetTR.children[2].removeChild(inputs[j]);
                targetTR.children[2].removeChild(br);
            }
        }
        var form = document.createElement('form');
        form.method = 'post';
        for (var i=0; i<targetTR.children.length-1; i+=1) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.value = targetTR.children[i].children[0].value;
            if (i==0) {
                input.name = 'articleName';
            }
            else if (i==1) {
                input.name = 'articleText';
            }
            else if (i==2) {
                var inputs = targetTR.children[i].getElementsByTagName('input');
                for (var j=0; j<inputs.length; j+=1) {
                    var newInput = document.createElement('input');
                    newInput.type = 'hidden';
                    newInput.value = inputs[j].value;
                    newInput.name = 'articleAva[]';
                    form.appendChild(newInput);
                }
            }
            else if (i==3) {
                input.name = 'articleStart';
                var sec = new Date();
                if (sec.getSeconds() < 10) {
                    sec = '0' + sec.getSeconds();
                }
                else {
                    sec = sec.getSeconds();
                }
                input.value = targetTR.children[i].children[0].value.replace('T', ' ')+':'+sec;
            }
            if (i!=2) {
                form.appendChild(input);
            }
        }
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        form = '';
    }
    else {
        message('Вы заполнили не все строки!', 'no', 'Ошибка');
    }
}
function addArticleAva(button, inputName) {
    if (inputName == undefined) {
        inputName = 'articleAva';
    }
    var targetTd = button.parentNode;
    var inputs = targetTd.getElementsByTagName('input');
    if (inputs[inputs.length-1].value != '') {
        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.placeholder = 'URL';
        newInput.name = inputName;
        var newButton = button.cloneNode(true);
        var br = document.createElement('br');
        targetTd.removeChild(button);
        targetTd.appendChild(br);
        targetTd.appendChild(newInput);
        targetTd.appendChild(newButton);
    }
}
function deleteArticle(button) {
    var targetTR = button.parentNode.parentNode, eventId;
    if (targetTR.children[0].innerText != undefined) {
        eventId = targetTR.children[0].innerText;
    }
    else {
        eventId = targetTR.children[0].textContent;
    }
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = eventId;
    input.name = 'articleDelete';
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    form = '';
}
onReady(function() {
    var adminPanels = document.querySelectorAll('.adminPanel');
    for (var i=0; i<adminPanels.length; i+=1) {
        adminPanels[i].style.height = '45px';
        adminPanels[i].onclick = function() {
            opening(this);

        }
    }
    function opening(panel) {
        for (var i=0; i<adminPanels.length; i+=1) {
            adminPanels[i].style.height = '45px';
            adminPanels[i].className = 'adminPanel';
        }
        panel.className += ' animated fadeInDown';
        panel.style.height = '';
    }
})