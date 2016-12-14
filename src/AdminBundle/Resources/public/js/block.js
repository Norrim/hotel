$('document').ready(function(){
    $("body").on('click','#block_enregistrer',function(e){
        if($("#bloc_image").length){
            e.preventDefault();
            var lineId = $("#block_line").val();

            if($("#block_id").length) {
                var blockId = $("#block_id").val();
            }
            else{
                var blockId = 0;
            }

            $.ajax({
                url : Routing.generate('admin_block_ajax_total_width', { lineId: lineId, blockId: blockId}),
                method: 'GET',
                success:function(totalWidth){
                    console.log(totalWidth);
                    var width = $('#block_width').val();
                    if(parseInt(width) + parseInt(totalWidth) > 12) {
                        alert("Erreur : \n \n Les largeurs cumulées des blocs de la ligne dépassent un total de 4 ! \n \n Modifier la largeur de ce bloc ou celle des autres bloc de cette ligne !");
                    }
                    else{
                        console.log('submit');
                        $('form[name="block"]').submit();
                    }
                }
            });
        }
    });
});