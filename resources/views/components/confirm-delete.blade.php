<div
  x-data="{open: false}"
  x-show="open"
  @confirm-delete.window="

    const id = event.detail.id;

    Swal.fire({
      title: 'Está seguro?',
      text: 'Usted no podrá revertirlo una vez realizado!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonText: 'Declinar',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar'
    }).then((result) => {
      if (result.isConfirmed) {
        $wire.confirmDelete(id).then(result => {
          Swal.fire({
            title: 'Eliminado!',
            text: '',
            icon: 'success'
          });
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        Swal.fire({
          title: 'Cancelado!',
          text: '',
          icon: 'error'
        });
      }
    });
  "
></div>
