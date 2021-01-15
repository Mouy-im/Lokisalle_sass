$(function() {
    $(document).on('click', '.fa-print', function() {
        window.print();
    });


    window.onscroll = function() {

            if (document.documentElement.scrollTop != 0) {

                document.querySelector('.retour_haut').classList.add('retour_scroll');
                document.querySelector('#banniere').classList.add('scroll_hide');



            } else {
                document.querySelector('#banniere').classList.remove('scroll_hide');
                document.querySelector('.retour_haut').classList.remove('retour_scroll');
            }

        }
        //ajout du calendrier
        // $(".datepicker").datepicker({ inline: true });

    $('.datetimepicker').datetimepicker({

        showOn: "button",
        showSecond: true,
        minDate: 0
    });


    $('#date_recherche').datepicker({ minDate: 0 });

})