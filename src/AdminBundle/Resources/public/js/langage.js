$(document).ready(function(){
    $('#tableLangageList').DataTable(
        {
            language: {
                "decimal": "",
                "emptyTable": "Pas de langages en base de données",
                "info": "Affichage des langages _START_ à _END_ sur un total de _TOTAL_",
                "infoEmpty": "",
                "infoFiltered": "(filtré sur _MAX_ langages au total)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ langages",
                "loadingRecords": "Chargement...",
                "processing": "Exécution...",
                "search": "Recherche:",
                "zeroRecords": "Pas de langage trouvé",
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