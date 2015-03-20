function bindReady(handler){
    var called = false;
    function ready() {
        if (called) return;
        called = true;
        handler();
    }
    if ( document.addEventListener ) {
        document.addEventListener( "DOMContentLoaded", function(){
            ready()
        }, false )
    } else if ( document.attachEvent ) {
        if ( document.documentElement.doScroll && window == window.top ) {
            function tryScroll(){
                if (called) return
                if (!document.body) return
                try {
                    document.documentElement.doScroll("left")
                    ready()
                } catch(e) {
                    setTimeout(tryScroll, 0)
                }
            }
            tryScroll()
        }
        document.attachEvent("onreadystatechange", function(){
            if ( document.readyState === "complete" ) {
                ready()
            }
        })
    }
    if (window.addEventListener)
        window.addEventListener('load', ready, false)
    else if (window.attachEvent)
        window.attachEvent('onload', ready)
    else
     window.onload=ready
}
readyList = [];
function onReady(handler) {
    if (!readyList.length) {
        bindReady(function() {
            for(var i=0; i<readyList.length; i++) {
                readyList[i]();
            }
        })
    }
    readyList.push(handler);
}
var checkNews = false;
onReady(function() {
    if (document.getElementById('loginBlock') != undefined) {
        var header = document.getElementById('loginBlock').parentNode;
        var buttons = header.querySelectorAll('.button');
        var pageName = document.location.href.split('/')[document.location.href.split('/').length-1].split('?')[0];
        for (var i=0; i<buttons.length; i+=1) {
            var buttonHref = buttons[i].href.split("/")[buttons[i].href.split("/").length-1].split('?')[0];
            if (buttonHref == pageName) {
                buttons[i].className += ' check';
            }
        }
        if (pageName = 'news') {
            checkNews = true;
        }
    }
    if (document.getElementById('articleContent') != undefined) {
        var articleContent = document.getElementById('articleContent'), articleID;
        if (document.getElementById('articleID') != undefined) {
            articleID = document.getElementById('articleID').value;
            document.getElementById('articleID').parentNode.removeChild(document.getElementById('articleID'));
        }
        else {
            articleID = document.location.href.split('id=')[1].split('&')[0];
        }
        articleContent.innerHTML = articleContent.innerHTML.replace(/\(%(\d*)%\)/g, '<img src="/images/articles/'+articleID+'/$1.jpg">');
    }
    if (document.getElementsByTagName('iframe').length != 0) {
        var iframes = document.getElementsByTagName('iframe'), separator;
        for (var i=0; i<iframes.length; i+=1) {
            if (iframes[i].src.indexOf('youtube') != -1 && iframes[i].src.indexOf('wmode=transparent') == -1) {
                if (iframes[i].src.indexOf('?') != -1) {
                    separator = '&';
                }
                else {
                    separator = '?';
                }
                iframes[i].src = iframes[i].src + separator + 'wmode=transparent';
            }
        }
    }
})
window.onload = function() {
    if (checkNews) {
        var newsBlocks = document.querySelectorAll('.news'), memoryHeight;
        for (var i=0; i<newsBlocks.length; i+=1) {
            if (i%2==0) {
                memoryHeight = newsBlocks[i].offsetHeight;
                if (newsBlocks[i+1].offsetHeight <= memoryHeight) {
                    newsBlocks[i+1].style.height = memoryHeight + 'px';
                    newsBlocks[i].style.height = memoryHeight + 'px';
                }
                else {
                    memoryHeight = newsBlocks[i+1].offsetHeight;
                    newsBlocks[i].style.height = memoryHeight + 'px';
                    newsBlocks[i+1].style.height = memoryHeight + 'px';

                }
            }
        }
    }
}
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function message(text, buttonOne, headText, buttonTwo) {
    if (!document.getElementById('inviteMask')) {
        var mask = document.createElement('div');
        mask.className = 'inviteMask';
        mask.id = 'inviteMask';
        document.body.appendChild(mask);
    }
    else {
        if (document.getElementById('inviteMask').children[0] && document.getElementById('inviteMask').children[0].className.indexOf(inviteBlock) >= 0) {
            document.getElementById('inviteMask').children[0].className = 'inviteBlock animated fadeOutUpBig';
            setTimeout(function() {document.getElementById('inviteMask').removeChild(document.getElementById('inviteMask').children[0])}, 500);
        }
    }
    var block = document.createElement('div');
    block.id = 'inviteBlock';
    block.className = 'inviteBlock animated fadeInDownBig';
    mask.appendChild(block);
    var content = document.createElement('div');
    content.className = 'inviteContent';
    block.appendChild(content);
    var header = document.createElement('div');
    header.className = 'colorHeader orange';
    if (headText == '') {
        headText = 'Сервер попросил вам передать:';
    }
    var headerText = document.createElement('span');
    headerText.innerHTML = headText;
    header.appendChild(headerText);
    content.appendChild(header);
    var contentText = document.createElement('span');
    contentText.innerHTML = text;
    content.appendChild(contentText);
    var buttonOneText, buttonTwoText;
    if (buttonOne != undefined && buttonTwo != undefined) {
        buttonOneText = 'Да';
        buttonTwoText = 'Нет';
    }
    else {
        buttonOneText = 'Ок';
    }
    var buttonYes = document.createElement('button');
    buttonYes.className = 'inviteButton';
    buttonYes.innerHTML = buttonOneText;
    buttonYes.onclick = function() {
        block.className = 'inviteBlock animated fadeOutUpBig';
        setTimeout(accept, 500);
    }
    function accept() {
        if (buttonOne == 'forgot') {
            forgot();
        }
        else if (buttonOne == 'no') {
            block.className = 'inviteBlock animated fadeOutUpBig';
            setTimeout(function() {document.body.removeChild(mask);}, 500);
        }
        else if (buttonOne == 'login') {
            login();
        }
        else {
            document.location.assign(buttonOne);
        }
    }
    content.appendChild(buttonYes);
    if (buttonTwo != undefined) {
        var buttonNo = document.createElement('button');
        buttonNo.className = 'inviteButton';
        buttonNo.innerHTML = buttonTwoText;
        buttonNo.onclick = function() {
            block.className = 'inviteBlock animated fadeOutUpBig';
            setTimeout(deleteMask, 500);
        }
        function deleteMask() {
            document.body.removeChild(mask);
        }
        content.appendChild(buttonNo);
    }
    else {
        buttonYes.style.width = '94%';
        buttonYes.style.margin = '3%';
    }
    block.style.height = content.offsetHeight + 'px';
    if (document.body.children[0].tagName == 'INPUT') {
        document.body.removeChild(document.body.children[0]);
    }
}