$(document).ready(function() {
    
    // Lorsque la case à cocher "Tout sélectionner" est cochée
    $('#select-all').change(function (e) { 
        e.preventDefault();
        // Si elle est cochée
        if ($(this).is(':checked')) {
            // Cocher toutes les cases à cocher des élèves
            $('.class-checkboxes').prop('checked', true);
        } else {
            // Décocher toutes les cases à cocher des élèves
            $('.class-checkboxes').prop('checked', false);
        }
    });
    const selectedIds = []; // Initialiser un tableau pour stocker les IDs des élèves sélectionnés
    // Lorsqu'une case à cocher des élèves est cochée ou décochée
    $('.class-checkboxes').change(function() {
        
        
        // Parcourir toutes les cases à cocher des élèves
        $('.class-checkboxes:checked').each(function() {
            // Ajouter l'ID de l'élève sélectionné au tableau
            selectedIds.push($(this).val());
        });
       console.log(selectedIds)
       
    });

    $('#affect-btn').click(function(){
        if(selectedIds.length === 0) {
            alert("Veuillez sélectionner au moins un élève avant de continuer.");
        } else {
          // Mettre à jour le lien du bouton "Inscription cour" avec les IDs des élèves sélectionnés
        var href ="/eleve/affectation/"+selectedIds;
        $(this).attr('href', href);
         // Envoyer une requête Ajax pour obtenir les informations des élèves sélectionnés
        $.ajax({
            type: "POST",
            url: "app_eleve_affect",
            data: { selectedIds: selectedIds },
            success: function(response) {
                console.log(response); // Afficher la réponse dans la console    
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(errorThrown); // Afficher l'erreur dans la console
            }
        });
    }
       })
});
