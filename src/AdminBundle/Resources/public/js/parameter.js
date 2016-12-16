$(document).ready(function(){
    $('#tableParameterList').DataTable(
        {
            language: {
                "decimal": "",
                "emptyTable": "Pas de paramètres en base de données",
                "info": "Affichage des paramètres _START_ à _END_ sur un total de _TOTAL_",
                "infoEmpty": "",
                "infoFiltered": "(filtré sur _MAX_ paramètres au total)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ paramètres",
                "loadingRecords": "Chargement...",
                "processing": "Exécution...",
                "search": "Recherche:",
                "zeroRecords": "Pas de paramètre trouvé",
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