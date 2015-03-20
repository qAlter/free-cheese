window.onload = function() {
    var loginBlock = document.getElementById('loginBlock');
    var inputs = loginBlock.getElementsByTagName('input');
    function checkLogin() {
        if (!document.getElementById('inviteMask') && inputs.length != 0) {
            createInvite();
        }
    }
    //setTimeout(checkLogin, 2000);
}
function createInvite() {
    var mask = document.createElement('div');
    mask.className = 'inviteMask';
    mask.id = 'inviteMask';
    document.body.appendChild(mask);
    var block = document.createElement('div');
    block.id = 'inviteBlock';
    block.className = 'inviteBlock animated fadeInDownBig';
    mask.appendChild(block);
    var content = document.createElement('div');
    content.className = 'inviteContent';
    block.appendChild(content);
    var header = document.createElement('div');
    header.className = 'colorHeader orange';
    var headerText = document.createElement('span');
    headerText.innerHTML = 'Здравствуйте! Давайте знакомиться?';
    header.appendChild(headerText);
    content.appendChild(header);
    var contentText = document.createElement('span');
    contentText.innerHTML = 'Скорее всего, Вы еще не знаете, что из себя представляет free-cheese.com. ' +
        'Но мы можем Вам подробно рассказать!';
    content.appendChild(contentText);
    var buttonYes = document.createElement('button');
    buttonYes.className = 'inviteButton';
    buttonYes.innerHTML = 'Да, пожалуйста!';
    buttonYes.onclick = function() {
        block.className = 'inviteBlock animated fadeOutUpBig';
        setTimeout(accept, 500);
    }
    function accept() {
        document.location.assign('about');
    }
    var buttonNo = document.createElement('button');
    buttonNo.className = 'inviteButton';
    buttonNo.innerHTML = 'Нет, спасибо!';
    buttonNo.onclick = function() {
        block.className = 'inviteBlock animated fadeOutUpBig';
        setTimeout(deleteMask, 500);
    }
    function deleteMask() {
        document.body.removeChild(mask);
    }
    content.appendChild(buttonYes);
    content.appendChild(buttonNo);
}