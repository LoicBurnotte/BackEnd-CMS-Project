

// ####################################################################################################
// -------------------------------------------- HOME - PUBLIC------------------------------------------
// ####################################################################################################
$(document).ready(function () {
    $('.img-parallax').each(function(){
        let img = $(this);
        let imgParent = $(this).parent();
        let imgPercent;
        function parallaxImg () {
            let speed = img.data('speed');
            let imgY = imgParent.offset().top;
            let winY = $(this).scrollTop();
            let winH = $(this).height();
            let parentH = imgParent.innerHeight();

            // The next pixel to show on screen
            let winBottom = winY + winH;

            // If block is shown on screen
            if (winBottom > imgY && winY < imgY + parentH) {
                // Number of pixels shown after block appear
                let imgBottom = ((winBottom - imgY) * speed);
                // Max number of pixels until block disappear
                let imgTop = winH + parentH;
                // Porcentage between start showing until disappearing
                let imgPercent = ((imgBottom / imgTop) * 100) + (50 - (speed * 50));
                img.css({
                    top: imgPercent + '%',
                    transform: 'translate(-50%, -' + imgPercent + '%)'
                });
            }
        }
        $(document).on({
            scroll: function () {
                parallaxImg();
            }, ready: function () {
                parallaxImg();
            }
        });
    });
    $(document).ready(function(){
        $('.collapsible').collapsible();
    });
});
/* PERMET DE RALENTIR LA TRANSITION DU BOUTON POUR DESCENDRE DANS LA PAGE href -> id*/
$('a[href^="#"]').on('click',function (e) {  //.not(".notanimated")
    //ajouter condition IF : si class de href est différent de "artiste"
    e.preventDefault();
    let target = this.hash,
        $target = $(target);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top
    }, 900, 'swing', function() {
        window.location.hash = target;
    });
});

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

