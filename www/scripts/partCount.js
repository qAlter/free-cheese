function animateThis(target, value) {
    var check = value-target, sec;
    if (target != 0) {
        sec = 500+(1000/target*0.25);
    }
    else {
        sec = 800;
    }
    checkAnimate(check, sec, target, value);
}
function checkAnimate(check, sec, target, value) {
    setTimeout(function() {part(check)}, sec);
    target -= 1;
    if (target != -1) {
        setTimeout(function() {animateThis(target, value)}, sec);
    }
}
onReady(function() {
    var serverMembers = document.getElementById('serverMembers');
    var animateSome = getRandomInt(1, 5);
    var value = serverMembers.value;
    serverMembers.parentNode.removeChild(serverMembers);
    if (animateSome > value) {
        animateSome = value;
    }
    part(value-animateSome);
    animateThis(animateSome, value);
});
function flippedLast() {
    var count = document.getElementById('count'), number = [], newNumber = '';
    for (var i=0; i<count.children.length-1; i+=1) {
        number[i] = count.children[i].children[0].innerHTML;
    }
    for (var i=0; i<number.length; i+=1) {
        if (number[i] == ',') {
            continue;
        }
        newNumber += number[i];
    }
    newNumber = newNumber.toString();
    var forRotate = (newNumber/1 - 1).toString()
    var flipped = 0;
    for (var i=0; i<newNumber.length; i+=1) {
        if (newNumber[i] != forRotate[i]) {
            flipped += 1;
        }
    }
    var counts = count.children.length - 1;
    var countsFlip = count.children.length-flipped-1;
    for (var i=counts; i>countsFlip; i-=1) {
        count.children[i-1].className += ' animated flipInX ';
    }
    count.children[count.children.length-2].className = 'count animated flipInX';
}
function flippedMany(oldValue, newValue) {
    var number = '';
    for (var i=0; i<oldValue.length; i+=1) {
        number += oldValue[i];
    }
    var count = document.getElementById('count');
    if (number.length == newValue.length) {
        if (number/1 == newValue/1) {
            return false;
        }
        else {
            for (var i=0; i<newValue.length; i+=1) {
                if (number[i] != newValue[i]) {
                    count.children[i].className += ' animated flipInX ';
                }
            }
        }
    }
    else {
        for (var i=0; i<count.children.length-1; i+=1) {
            count.children[i].className += ' animated flipInX ';
        }
    }
}
function part(serverValue) {
    if (serverValue == undefined) {
        var loginBlock = document.getElementById('loginBlock');
        var inputs = loginBlock.getElementsByTagName('input');
        if (!document.getElementById('inviteMask') && inputs.length != 0) {
            login();
            return false;
        }
    }
    var count = document.getElementById('count'), number = [], newNumber = '';
    for (var i=0; i<count.children.length-1; i+=1) {
        number[i] = count.children[i].children[0].innerHTML;
    }
    for (var i=0; i<number.length; i+=1) {
        if (number[i] == ',') {
            continue;
        }
        newNumber += number[i];
    }
    newNumber = (newNumber/1).toString();
    if (serverValue) {
        newNumber = serverValue.toString();
    }
    if (newNumber.length > number.length || number.length > 3) {
        count.removeChild(count.children[count.children.length-1]);
        var commas = newNumber.length/3;
        commas = Math.floor(commas-0.00001);
        for (var i=0; i<newNumber.length-number.length+commas; i+=1) {
            var oneCount = document.createElement('div');
            oneCount.className = 'count flipInX animated';
            oneCount.innerHTML = '';
            var countSpan = document.createElement('span');
            countSpan.innerHTML = '';
            count.appendChild(oneCount);
            oneCount.appendChild(countSpan);
        }
        var countLabel = document.createElement('span');
        countLabel.innerHTML = 'чел.';
        count.appendChild(countLabel);
    }
    for (var i=0; i<count.children.length - 1; i+=1) {
        count.children[i].className = 'count';
    }
    var separator = 0;
    for (var i=0; i<count.children.length-1; i+=1) {
        if ((count.children.length-1 - i) % 4 == 0) {
            count.children[i].children[0].innerHTML = ',';
            separator += 1;
        }
        else {
            count.children[i].children[0].innerHTML = newNumber[i-separator];
        }
    }
    if (serverValue != undefined) {
        setTimeout(function () {flippedMany(number, newNumber)}, 1);
    }
    else {
        send();
        //setTimeout(flippedLast, 1);
    }
}
function send() {
    var form = document.createElement('form');
    form.method = 'post';
    var input = document.createElement('input');
    input.type = 'hidden';
    var check = document.getElementById('check');
    input.value = check.value;
    input.name = 'requestRaffle';
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    form = '';
}