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
    $('#date_arrivee_r').datetimepicker({ minDate: 0, format: 'Y/m/d', timepicker: false });
    $('#date_depart_r').datetimepicker({
        onShow: function(ct) {
            this.setOptions({
                minDate: $('#date_arrivee_r').val() ? $('#date_arrivee_r').val() : false,
                value: $('#date_arrivee_r').val() ? $('#date_arrivee_r').val() : false,
                format: 'Y/m/d',
                timepicker: false
            })
        }
    });

    //admin/gestion des produits
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
    //show password page connexion
    if (document.querySelector('#mdp')) {
        const togglePassword = document.querySelector('.toggle-password');
        const password = document.querySelector('#mdp');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    }

    //show password page reinit_mdp
    if (document.querySelector('#new_mdp')) {
        const togglePassword = document.querySelector('.toggle-password3');
        const password = document.querySelector('#new_mdp');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    }
    if (document.querySelector('#new_mdp2')) {
        const togglePassword = document.querySelector('.toggle-password4');
        const password = document.querySelector('#new_mdp2');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    }

    //confirmation mdp page inscription
    if (document.querySelector('#mdp2')) {
        const togglePassword = document.querySelector('.toggle-password2');
        const password = document.querySelector('#mdp2');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    }

})