(function($){

    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');
        // $a.text('Chargement');
        $.ajax(url, {
            success: function() {
                var res = confirm("Êtes-vous sûr de vouloir supprimer?");
                if(res){
                    $a.parents('tr').fadeOut();
                }
            },
            error: function(jqxhr){
                $a.text('supprimer')
                alert(jqxhr.responseText);
            }
        });
    });

})(jQuery);



// document.addEventListener('DOMContentLoaded', function() {
//     var initialLocaleCode = 'fr';
//     var localeSelectorEl = document.getElementById('locale-selector');
//     var calendarEl = document.getElementById('calendar');

//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         buttonText: {
//             prev: 'Précédent',
//             next: 'Suivant',
//             today: 'Aujourd\'hui',
//             year: 'Année',
//             month: 'Mois',
//             week: 'Semaine',
//             day: 'Jour',
//             list: 'Planning',
//         },
//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title,addEventButton',
//             right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
//         },

//         weekText: 'Sem.',
//         weekTextLong: 'Semaine',
//         allDayText: 'Toute la journée',
//         moreLinkText: 'en plus',
//         noEventsText: 'Aucun évènement à afficher',
//         locale: 'fr',
//         local: 'fr',
//         buttonIcons: false, // show the prev/next text
//         weekNumbers: true,
//         navLinks: true, // can click day/week names to navigate views
//         editable: true,
//         dayMaxEvents: true, // allow "more" link when too many events
//         events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
//     });

//     calendar.render();

//     // build the locale selector's options
//     calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
//         var optionEl = document.createElement('option');
//         optionEl.value = localeCode;
//         optionEl.selected = localeCode === initialLocaleCode;
//         optionEl.innerText = localeCode;
//         localeSelectorEl.appendChild(optionEl);
//     });

//     // when the selected option changes, dynamically change the calendar option
//     localeSelectorEl.addEventListener('change', function() {
//         if (this.value) {
//             calendar.setOption('local', 'fr');
//         }
//     });


// });
