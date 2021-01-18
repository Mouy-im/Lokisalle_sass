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
        //recherche
    $('#date_recherche').datepicker({ minDate: 0 });

    //gestion des produits
    $('.datetimepicker').datetimepicker({
        minDate: 0,
        onShow: function(ct) {
            this.setOptions({
                //maxDate: $('.datetimepicker2').val() ? $('.datetimepicker2').val() : false
            })
        }
    });
    $('.datetimepicker2').datetimepicker({

        onShow: function(ct) {
            this.setOptions({
                minDate: $('.datetimepicker').val() ? $('.datetimepicker').val() : false,
                value: $('.datetimepicker').val() ? $('.datetimepicker').val() : false
            })
        }
    });
})