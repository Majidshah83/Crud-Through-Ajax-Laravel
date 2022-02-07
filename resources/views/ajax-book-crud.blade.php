<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Laravel 8 Ajax CRUD Tutorial</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container mt-2">

    <div class="row">

      <div class="col-md-12 card-header text-center font-weight-bold">
        <h2>Laravel 8 Ajax Book CRUD Tutorial</h2>
      </div>
      <div class="col-md-12 mt-1 mb-2">
       <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#AddStudentModal">Add Book</button>
     </div>
     <ul id="save_msgList"></ul>
     <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Book Title</th>
            <th scope="col">Book Code</th>
            <th scope="col">Book Author</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody class="tab"> 

        </tbody>
      </table>
    </div>
  </div>        
</div>
<!--Edit Modal-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit & Update Book Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <ul id="update_msgList"></ul>

        <input type="hidden" id="book_id" />

        <div class="form-group mb-3">
          <label for="">Book Title</label>
          <input type="text" id="title" required class="form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Book Code</label>
          <input type="text" id="code" required class="form-control">
        </div>

        <div class="form-group mb-3">
          <label for="">Book Author</label>
          <input type="text" id="author" required class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_book">Update</button>
      </div>

    </div>
  </div>
</div>
<!--Edn- Edit Modal-->

<!-- Add boostrap model -->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="AddStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddStudentModalLabel">Add Student Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul id="save_msgList"></ul>

        <div class="form-group mb-3">
          <label for="">Enter Title</label>
          <input type="text" required class="title form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Enter Author</label>
          <input type="text" required class="author form-control">
        </div>
        <div class="form-group mb-3">
          <label for="">Enter Code</label>
          <input type="text" required class="code form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_book">Save</button>
      </div>

    </div>
  </div>
</div>


<!-- end Add bootstrap model -->

<!-- Delete  model -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Book Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Confirm to Delete Data ?</h4>
        <input type="hidden" id="deleteing_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_book">Yes Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- End Delete  model -->
<script type="text/javascript">


//Insert new Book

$(document).on('click', '.add_book', function (e) {
  e.preventDefault();

  var data = {
    'title': $('.title').val(),
    'code': $('.code').val(),
    'author': $('.author').val(),

  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    type: "POST",
    url: "/add-book",
    data: data,
    dataType: "json",
    success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                      alert("400 errors");
                      $('#save_msgList').html("");
                      $('#save_msgList').addClass('alert alert-danger');
                      $.each(response.errors, function (key, err_value) {
                        $('#save_msgList').append('<li>' + err_value + '</li>');
                      });
                      $('.add_student').text('Save');
                    } else {
                      $('#save_msgList').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message);
                      $('#AddBookModal').find('input').val('');
                      $('.add_book').text('Save');
                      $('#AddBookModal').modal('hide');
                      window.location.replace("ajax-book-crud");
                    }
                  }
                });

});


//delete button
$(document).on('click', '.deletebtn', function (e) {
  e.preventDefault();
  $('#DeleteModal').modal('show');
  var book_id = $(this).val();
  $('#deleteing_id').val(book_id);
});
$(document).on('click', '.delete_book', function (e) {
  e.preventDefault();
   var id = $('#deleteing_id').val(); //id get book

   $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
   $.ajax({
    type: "DELETE",
    url: "/delete-book/" + id,
    dataType: "json",
    success: function (response) {
      if (response.status == 404) {
        $('.delete_book').text('Yes Delete');
        alert("Errors 404");
      }
      else
      {
        $('#DeleteModal').modal('hide');
        window.location.replace("ajax-book-crud");

      }

    }
  });
 });
// click on Edit button 
$(document).on('click', '.editbtn', function (e) {
 e.preventDefault()
            var book_id = $(this).val(); //edit id 
            $('#editModal').modal('show');
            $.ajax({
              type: "GET",
              url: "/edit-book/"+book_id,
              success: function(response)

              {
                if(response.status ==400)
                {
                  alert("Errors 404");
                  $('#editModal').modal('hide');

                }
                else{
                    // console.log(response.book);
                    //data show in text filed
                    $('#title').val(response.book.title);  
                    $('#code').val(response.book.author);
                    $('#author').val(response.book.code);
                    $('#book_id').val(response.book.id);

                  }
                }
                
              });

            $('.btn-close').find('input').val('');
          });

// click on update button 

$(document).on('click','.update_book', function(e)
{
 e.preventDefault();
 var id=$('#book_id').val(); // get id
 var data = {
  'title': $('#title').val(),
  'code': $('#code').val(),
  'author': $('#author').val(),
}
$.ajaxSetup(
{
  headers:{
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$.ajax({
 type:"Post",
 url:"/update-book/"+id,
       data:data, //in data store tile,code,author
       dataType: "json",
       success: function (response) {
        if(response.status ==400)
        {
         alert("Errors 400");
         
       }
       else
       {
         $('#editModal').find('input').val('');
         $('.update_book').text('Update');
         $('#editModal').modal('hide');
         window.location.replace("ajax-book-crud");
       }
     }

   });
});

//fetch book
$(document).ready(function () {
        fetchbook(); // Fetech data of books
      });

//fuction of fetch book from contrller 
function fetchbook() {
  $.ajax({
    type: "GET",
    url: "/fetch-books",
    dataType: "json",
    success: function (response) {
      var books = response;
                    // console.log("response",books);
                    $('.tab').html("");
                    $.each(response.books, function (key, item) {
                      // console.log("response",item);
                      $('.tab').append('<tr>\
                        <td>'+ item.id +'</td>\
                        <td>'+ item.title +'</td>\
                        <td>'+ item.code +'</td>\
                        <td>'+ item.author +'</td>\
                        <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                        <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td></tr>');
                    });
                  },

                });
}

</script>
</body>
</html>