$(document).ready(function(){
    $('#tableContentList').DataTable(
        {
            language: {
                "decimal": "",
                "emptyTable": "Pas de contenus en base de données",
                "info": "Affichage des contenus _START_ à _END_ sur un total de _TOTAL_",
                "infoEmpty": "",
                "infoFiltered": "(filtré sur _MAX_ contenus au total)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ contenus",
                "loadingRecords": "Chargement...",
                "processing": "Exécution...",
                "search": "Recherche:",
                "zeroRecords": "Pas de contenu trouvé",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": Activer pour trier la colonne dans l'ordre croissant",
                    "sortDescending": ": Activer pour trier la colonne dans l'ordre décroissant"
                }
            }
        }
    );
});