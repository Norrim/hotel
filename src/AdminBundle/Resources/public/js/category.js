$(document).ready(function(){
    $('#tableCategoryList').DataTable(
        {
            language: {
                "decimal": "",
                "emptyTable": "Pas de catégories en base de données",
                "info": "Affichage des catégories _START_ à _END_ sur un total de _TOTAL_",
                "infoEmpty": "",
                "infoFiltered": "(filtré sur _MAX_ catégories au total)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ catégories",
                "loadingRecords": "Chargement...",
                "processing": "Exécution...",
                "search": "Recherche:",
                "zeroRecords": "Pas de catégorie trouvée",
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