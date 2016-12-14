$(document).ready(function(){
    $('#tableHeadingList').DataTable(
        {
            language: {
                "decimal": "",
                "emptyTable": "Pas de typographies en base de données",
                "info": "Affichage des typographies _START_ à _END_ sur un total de _TOTAL_",
                "infoEmpty": "",
                "infoFiltered": "(filtré sur _MAX_ typographies au total)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ typographies",
                "loadingRecords": "Chargement...",
                "processing": "Exécution...",
                "search": "Recherche:",
                "zeroRecords": "Pas de typographie trouvée",
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

$(function() {
    /* Gestion des polices dans le select */
    $('#heading_font').children().each(
        function () {
            $(this).css('font-family', $(this).val());
        }

    );

    /* Gestion de la taille des polices dans le select */
    $('#heading_size').children().each(
        function () {
            $(this).css('font-size', $(this).val()+"px");
        }
    );

    /* Gestion du colorPicker */
    var  colorInput = $('#heading_color');
    var parent = colorInput.parent();
    colorInput.attr('readonly','true');
    parent.attr('id', 'colorInputGroup');
    parent.addClass('input-group colorpicker-component');
    parent.append('<span class="input-group-addon"><i></i></span>');
    $('#colorInputGroup').colorpicker();
});

;

