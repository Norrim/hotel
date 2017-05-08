$('.btn-danger').on('click',function () {
  if (confirm("Voulez-vous vraiment supprimer ?")) {
      return true;
  }

   return false;
});
