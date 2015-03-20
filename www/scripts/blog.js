onReady(function() {
    var adminPanels = document.querySelectorAll('.aboutUs.blog > span');
    for (var i=0; i<adminPanels.length; i+=1) {
        adminPanels[i].style.height = '32px';
        adminPanels[i].onclick = function() {
            opening(this);

        }
    }
    function opening(panel) {
        for (var i=0; i<adminPanels.length; i+=1) {
            adminPanels[i].style.height = '32px';
            adminPanels[i].className = '';
        }
        panel.className += ' animated fadeInDown';
        panel.style.height = '';
    }
})