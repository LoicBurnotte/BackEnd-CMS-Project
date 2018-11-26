// ####################################################################################################
// ----------------------------------------- ADMIN - PRIVATE ------------------------------------------
// ####################################################################################################
$('.message a').click(function(){
    $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

//DATEPICKER
// $(document).ready(function(){
//     let date_input=$('input[name="date"]'); //our date input has the name "date"
//     let container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
//     date_input.datepicker({
//         format: 'dd/mm/yyyy',
//         container: container,
//         todayHighlight: true,
//         autoclose: true,
//     })
// });
    $(document).ready(function () { //.pickadate({})
        let datePickerOptions = {
            format: 'dd/mm/yyyy',
            months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthsShort: ['Jan', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
            weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            weekdaysAbbrev:	['D','L','M','M','J','V','S']
            // yearRange: 15,
            // selectMonths: true, // Creates a dropdown to control month
            // today: 'aujourd\'hui',
            // clear: 'effacer',
            // format_Submit: 'yyyy/mm/dd'
        };

        let datePicker = document.querySelector('.datepicker');
        M.Datepicker.init(datePicker, datePickerOptions);

        // $('.datepicker').datepicker();
        // $('.timepicker').timepicker();
    });

//TOGGLE MENUS - EVENTS - PICTURES - MOVIES - MUSICS
$(document).ready(function(){
    $('.tabs').not('#noeffect').tabs();
});

