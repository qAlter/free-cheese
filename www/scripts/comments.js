function sendComment(button, answerID) {
    var addCommentBlock = button.parentNode;
    var textarea = addCommentBlock.children[0];
    if (textarea.value != '') {
        var commentLocation = document.location.href.split('/')[3].split('?')[0];
        if (commentLocation == '') {
            commentLocation = 'index';
        }
        var form = document.createElement('form');
        form.method = 'post';
        var inputText = document.createElement('input');
        inputText.type = 'hidden';
        inputText.name = 'commentText';
        inputText.value = textarea.value;
        inputText.value = inputText.value.replace(/'/g, "&#039");
        if (answerID != '') {
            var inputID = document.createElement('input');
            inputID.type = 'hidden';
            inputID.value = answerID;
            inputID.name = 'answerID';
        }
        var inputLocation = document.createElement('input');
        inputLocation.type = 'hidden';
        inputLocation.name = 'commentLocation';
        inputLocation.value = commentLocation;
        form.appendChild(inputText);
        form.appendChild(inputLocation);
        if (inputID) {
            form.appendChild(inputID);
        }
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
    else {
        textarea.placeholder = 'Вы не ввели свой комментарий!';
    }
}
function answerComment(button) {
    var comment = button.parentNode, commentID = button.children[0].value;
    comment.removeChild(button);
    var newCommentBlock = document.createElement('div');
    newCommentBlock.className = 'newCommentBlock';
    var textarea = document.createElement('textarea');
    textarea.placeholder = 'Введите Ваш ответ на комментарий';
    var sendButton = document.createElement('button');
    sendButton.className = 'inviteButton';
    sendButton.innerHTML = 'Ответить';
    sendButton.setAttribute('onclick', 'sendComment(this, '+commentID+')');
    newCommentBlock.appendChild(textarea);
    newCommentBlock.appendChild(sendButton);
    insertAfter(newCommentBlock, comment);
}
function deleteComment(button) {
    var comment = button.parentNode;
    var input = comment.getElementsByTagName('input')[0];
    var form = document.createElement('form');
    form.method = 'post';
    var inputText = document.createElement('input');
    inputText.type = 'hidden';
    inputText.name = 'commentID';
    inputText.value = input.value;
    form.appendChild(inputText);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
function insertAfter(elem, refElem) {
    var parent = refElem.parentNode, next = refElem.nextSibling;
    if(next)return parent.insertBefore(elem, next);
    else return parent.appendChild(elem);
}