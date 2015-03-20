function changeEvent(button) {
    var buttonTD = button.parentNode;
    var targetTR = buttonTD.parentNode;
    var values = [];
    for (var i=0; i<targetTR.children.length-1; i+=1) {
        values[i] = targetTR.children[i].innerHTML;
        if (i==0) {
            targetTR.children[i].innerHTML = '';
            var select = document.createElement('select');
            select.name = 'oldEventType';
            var optionOne = document.createElement('option');
            optionOne.innerHTML = 'Основной';
            optionOne.value = 1;
            var optionTwo = document.createElement('option');
            optionTwo.innerHTML = 'Дополнительный';
            optionTwo.value = 0;
            select.appendChild(optionOne);
            select.appendChild(optionTwo);
            targetTR.children[i].appendChild(select);
            if (values[i] == optionOne.innerHTML) {
                optionOne.selected = true;
            }
            else {
                optionTwo.selected = true;
            }
        }
        else if (i==2) {
            values[i] = targetTR.children[i].textContent;
            targetTR.children[i].innerHTML = '';
            var input = document.createElement('input');
            input.name = 'oldEventName';
            input.type = 'text';
            input.value = values[i];
            targetTR.children[i].appendChild(input);
        }
        else if (i==3) {
            targetTR.children[i].innerHTML = '';
            var textArea = document.createElement('textarea');
            textArea.name = 'oldEventText';
            textArea.value = values[i];
            targetTR.children[i].appendChild(textArea);
        }
        else if (i==4) {
            targetTR.children[i].innerHTML = '';
            var avatar = document.createElement('input');
            avatar.name = 'oldEventAva';
            avatar.placeholder = 'URL';
            avatar.type = 'text';
            targetTR.children[i].appendChild(avatar);
        }
        else if (i==5) {
            targetTR.children[i].innerHTML = '';
            var date = document.createElement('input');
            date.name = 'oldEventStart';
            date.type = 'date';
            date.value = values[i];
            targetTR.children[i].appendChild(date);
        }
        else if (i==6) {
            targetTR.children[i].innerHTML = '';
            var date = document.createElement('input');
            date.name = 'oldEventEnd';
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
            for (var i=0; i<targetTR.children.length-2; i+=1) {
                if (targetTR.children[i].children.length == 0) {
                    if (i==1) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.value = targetTR.children[i].innerHTML;
                        input.name = 'oldEventId';
                        form.appendChild(input);
                    }
                }
                else {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.value = targetTR.children[i].children[0].value;
                    if (i==0) {
                        input.name = 'oldEventType';
                    }
                    else if (i==2) {
                        input.name = 'oldEventName';
                    }
                    else if (i==3) {
                        input.name = 'oldEventText';
                    }
                    else if (i==4) {
                        input.name = 'oldEventAva';
                    }
                    else if (i==5) {
                        input.name = 'oldEventStart';
                    }
                    else if (i==6) {
                        input.name = 'oldEventEnd';
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
function addEvent(button) {
    var targetTR = button.parentNode.parentNode, check = true;
    for (var i=0; i<targetTR.children.length-1; i+=1) {
        if (targetTR.children[i].value == "") {
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
                input.name = 'eventType';
            }
            else if (i==1) {
                input.name = 'eventName';
            }
            else if (i==2) {
                input.name = 'eventText';
            }
            else if (i==3) {
                input.name = 'eventAva';
            }
            else if (i==4) {
                input.name = 'eventStart';
            }
            else if (i==5) {
                input.name = 'eventEnd';
            }
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        form = '';
    }
}
function deleteEvent(button) {
    var targetTR = button.parentNode.parentNode;
    var eventId = targetTR.children[1].innerText;
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = eventId;
    input.name = 'deleteEvent';
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    form = '';
}
function changeUser(button) {
    var buttonPlace = button.parentNode, targetTR = buttonPlace.parentNode, userID = targetTR.children[0].innerText;
    var userPrivilege = targetTR.children[targetTR.children.length - 2];
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.name = 'userId';
    input.value = userID;
    input.type = 'hidden';
    form.appendChild(input);
    var selectPrivilege = document.createElement('select');
    selectPrivilege.name = 'userPrivilege';
    for (var i = 0; i<=2; i+=1) {
        var option = document.createElement('option');
        option.value = i;
        if (i==0) {
            option.innerHTML = 'user';
        }
        else if (i==1) {
            option.innerHTML = 'writer';
            option.value = 3;
        }
        else if (i==2) {
            option.innerHTML = 'banned';
            option.value = 4;
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
function changePost(button) {
    var buttonPlace = button.parentNode, targetTR = buttonPlace.parentNode, length = 1;
    if (targetTR.children.length == 3) {
        length = 0;
    }
    var postTextPlace = targetTR.children[length+1];
    var postID = targetTR.children[length].innerHTML;
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = postID;
    input.name = 'oldPostId';
    form.appendChild(input);
    var textArea = document.createElement('textarea');
    textArea.name = 'oldPostChange';
    textArea.className = 'postArea';
    textArea.placeholder = 'Тэги HTML активированы';
    textArea.value = postTextPlace.innerHTML;
    form.appendChild(textArea);
    postTextPlace.innerHTML = '';
    postTextPlace.appendChild(form);
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
function deletePost(button) {
    var targetTR = button.parentNode.parentNode, length = 1;
    if (targetTR.children.length == 3) {
        length = 0;
    }
    var eventId = targetTR.children[length].innerText;
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = eventId;
    input.name = 'deletePost';
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    form = '';
}
function addPost(button) {
    var addPost = document.getElementById('addPost');
    if (addPost.children[0].value != '') {
        addPost.children[0].value = '<p>' + addPost.children[0].value + '</p>';
        addPost.submit();
        document.body.removeChild(addPost);
        addPost = '';
    }
}
function changeText(button) {
    var changePlace = button.parentNode, changePlaceHeight = changePlace.offsetHeight;
    var changeID = button.children[0].value;
    changePlace.removeChild(button);
    var changeText = changePlace.innerHTML;
    var textPlace = document.createElement('textarea');
    textPlace.style.height = changePlaceHeight + 'px';
    textPlace.value = changeText;
    var buttonDone = document.createElement('button');
    buttonDone.innerHTML = 'Готово';
    buttonDone.className = 'inviteButton';
    var buttonCancel = document.createElement('button');
    buttonCancel.innerHTML = 'Отмена';
    buttonCancel.className = 'inviteButton';
    changePlace.innerHTML = '';
    changePlace.appendChild(textPlace);
    changePlace.appendChild(buttonDone);
    changePlace.appendChild(buttonCancel);
    buttonCancel.onclick = function() {
        document.location.reload();
    }
    buttonDone.onclick = function() {
        var contentLocation = document.location.href.split('/')[3].split('?')[0];
        if (contentLocation == '') {
            contentLocation = 'index';
        }
        var form = document.createElement('form');
        form.method = 'post';
        var inputID = document.createElement('input');
        inputID.type = 'hidden';
        inputID.value = changeID;
        inputID.name = 'contentID';
        var inputLocation = document.createElement('input');
        inputLocation.type = 'hidden';
        inputLocation.value = contentLocation;
        inputLocation.name = 'contentPage';
        var inputText = document.createElement('input');
        inputText.type = 'hidden';
        inputText.value = textPlace.value;
        inputText.name = 'contentText';
        form.appendChild(inputID);
        form.appendChild(inputLocation);
        form.appendChild(inputText);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}