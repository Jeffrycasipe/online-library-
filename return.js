function frmSignup(e) {
    e.preventDefault();
    let brwID = $('#brwID').val();
    let brwquantity = $('#brwquantity').val();
    let bookID = $('#bookID').val();
   
    $.post(
      '../php/return.php',
      {
        brwID: brwID,
        brwquantity: brwquantity,
        bookID: bookID
      },
      function (data) {
        alert(data);
        if (data == 'returned Successfuly') {
          window.location.href = '../php/borrowedBooks.php';
        }
      }
    );
  }
  