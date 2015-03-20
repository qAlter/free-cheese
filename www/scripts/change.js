function changeData(button) {
    var changeInput = button.parentNode.previousElementSibling.children[0];
    if (changeInput.value == '') {
        if (changeInput.name == 'pass') {
            return false;
        }
    }
    var changeForm = document.createElement('form');
    changeForm.method = 'post';
    var newInput = document.createElement('input');
    newInput.type = 'hidden';
    newInput.name = changeInput.name;
    newInput.value = changeInput.value;
    changeForm.appendChild(newInput);
    document.body.appendChild(changeForm);
    changeForm.submit();
}
function sendTwit() {
    var input = document.getElementsByName('userTwit')[0];
    var form = document.createElement('form');
    form.method = 'post';
    var inputText = document.createElement('input');
    inputText.name = 'userTwit';
    inputText.type = 'hidden';
    var string = input.value.replace(/'/g, "&#039");
    inputText.value = string;
    form.appendChild(inputText);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
function changeTwit(place) {
    var oldText = place.innerText;
    var twit = {
        length: 144,
        text: ''
    }
    var twitForm = document.createElement('form');
    twitForm.method = 'post';
    var input = document.createElement('textarea');
    input.type = 'text';
    input.name = 'userTwit';
    input.placeholder = 'Введите статус';
    var span = document.createElement('span');
    span.innerHTML = twit.length;
    place.innerHTML = '';
    place.appendChild(twitForm);
    twitForm.appendChild(input);
    twitForm.appendChild(span);
    twitForm.action = 'javascript: sendTwit()';
    input.focus();
    input.onkeydown = function() {
        if (twit.length - input.value.length <= 0) {
            input.value = input.value.slice(0, 144);
            return false;
        }
    }
    input.onkeyup = function() {
        twit.text = input.value;
        if (twit.length - input.value.length < 0) {
            input.value = input.value.slice(0, 144);
            return false;
        }
        span.innerHTML = twit.length - input.value.length;
    }
    input.onblur = function() {
        var form = document.createElement('form');
        form.method = 'post';
        var inputText = document.createElement('input');
        inputText.name = 'userTwit';
        inputText.type = 'hidden';
        var string = input.value.replace(/'/g, "&#039");
        inputText.value = string;
        form.appendChild(inputText);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}
onReady(function() {
    var avatarNames = document.querySelectorAll('.avatarName');
    for (var i=0; i<avatarNames.length; i+=1) {
        if (typeof(avatarNames[i].innerText)!='undefined') {
            if (avatarNames[i].innerText.length > 13) {
                if (avatarNames[i].innerHTML.split('<br>').length > 1) {
                    var links = avatarNames[i].innerHTML.split('<br>');
                    avatarNames[i].innerHTML = '';
                    for (var j=0; j<links.length; j+=1) {
                        if (links[j].split('$')[0].length > 13) {
                            avatarNames[i].innerHTML += '...' + links[j].split('$')[0].slice(links[j].split('$')[0].length-10, links[j].split('$')[0].length) + links[j].split('$')[1] + '<br>';
                        }
                    }
                }
                else {
                    avatarNames[i].innerHTML = '...' + avatarNames[i].innerText.slice(avatarNames[i].innerText.length-10, avatarNames[i].innerText.length);
                }
            }
        }
        else {
            if (avatarNames[i].textContent.length > 13) {
                if (avatarNames[i].innerHTML.split('<br>').length > 1) {
                    var links = avatarNames[i].innerHTML.split('<br>');
                    avatarNames.innerHTML = '';
                    for (var j=0; j<links.length; j+=1) {
                        if (links[j].length > 13) {
                            avatarNames[i].innerHTML += '...' + links[j].slice(links[j].length-10, links[j].length) + '<br>';
                        }
                    }
                }
                else {
                    avatarNames[i].innerHTML = '...' + avatarNames[i].textContent.slice(avatarNames[i].textContent.length-10, avatarNames[i].textContent.length);
                }
            }
        }
    }
});