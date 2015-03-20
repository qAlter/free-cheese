onReady(function() {
    if (document.querySelectorAll('.raffleShortPreview')) {
        short(document.querySelectorAll('.raffleShortPreview'), 38);
    }
    if (document.querySelectorAll('.rafflePreview')) {
        short(document.querySelectorAll('.rafflePreview'), 120);
    }
    if (document.querySelectorAll('.articlePreview')) {
        short(document.querySelectorAll('.articlePreview'), 430);
    }
    if (document.querySelectorAll('.raffleShortHeader')) {
        short(document.querySelectorAll('.raffleShortHeader'), 28);
    }
    if (document.querySelectorAll('.commentPreview')) {
        short(document.querySelectorAll('.commentPreview'), 60);
    }
    if (document.getElementById('commentPosition')) {
        var comment = document.getElementById('commentPosition'), commentPosition = comment.value;
        comment.parentNode.removeChild(comment);
        var inputs = document.getElementsByTagName('input');
        for (var i=0; i<inputs.length; i+=1){
            if (inputs[i].type == 'hidden') {
                if (inputs[i].value == commentPosition && inputs[i].parentNode.tagName.toLowerCase() == 'button') {
                    var comment = inputs[i].parentNode.parentNode;
                    var commentCoord = getOffset(comment);
                    if (commentCoord.top != '0') {
                        document.body.scrollTop = commentCoord.top;
                    }
                }
            }
        }
    }
});
function short(classes, length) {
    for (var i=0; i<classes.length; i+=1) {
        var linkString = classes[i].parentNode.parentNode.parentNode.getElementsByTagName('img')[0].parentNode.href;
        var link = '<a href="' + linkString + '">', linkEnd = '</a>';
        if (classes[i].className == 'rafflePreview' || classes[i].className == 'articlePreview') {
            link = '', linkEnd = '';
            if (classes[i].className == 'articlePreview') {
                classes[i].innerHTML = classes[i].innerHTML.replace(/\(%(\d*)%\)/g, '<br>');
            }
        }
        if (typeof(classes[i].innerText)!='undefined') {
            if (classes[i].innerText.length > length+3) {
                classes[i].innerHTML = link + classes[i].innerText.slice(0, length) + '...' + linkEnd;
            }
        }
        else {
            if (classes[i].textContent.length > length+3) {
                classes[i].innerHTML = link + classes[i].textContent.slice(0, length) + '...' + linkEnd;
            }
        }
    }
}
function getOffset(elem) {
    if (elem.getBoundingClientRect) {
        return getOffsetRect(elem)
    } else {
        return getOffsetSum(elem)
    }
}

function getOffsetSum(elem) {
    var top=0, left=0
    while(elem) {
        top = top + parseInt(elem.offsetTop)
        left = left + parseInt(elem.offsetLeft)
        elem = elem.offsetParent
    }
    return {top: top, left: left}
}

function getOffsetRect(elem) {
    var box = elem.getBoundingClientRect()
    var body = document.body
    var docElem = document.documentElement
    var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop
    var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft
    var clientTop = docElem.clientTop || body.clientTop || 0
    var clientLeft = docElem.clientLeft || body.clientLeft || 0
    var top  = box.top +  scrollTop - clientTop
    var left = box.left + scrollLeft - clientLeft
    return { top: Math.round(top), left: Math.round(left) }
}
