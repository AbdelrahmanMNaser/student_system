function confirmEdit(event, itemName) {
  event.preventDefault();
  var form = event.target; 
  swal({
      title: "Are you sure?",
      text: "You are about to edit\n " + itemName + ".",
      icon: "warning",
      buttons: true
  })
  .then((willEdit) => {
      if (willEdit) {
          form.submit();
      }
  });
}

function confirmRemove(event, itemName) {
  event.preventDefault();
  var form = event.target;
  swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover data of\n" + itemName + "!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
      if (willDelete) {
          form.submit();
      }
  });
}
