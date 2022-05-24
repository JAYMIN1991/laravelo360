@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-11">
                <h2>Article List</h2>
        </div>
        <div class="col-lg-1">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addModal">Add</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered" id="articleTable">
		<thead>
			<tr>
				<th>id</th>
				<th>Title</th>
				<th>Content</th>
				<th>userId</th>
				<th width="280px">Action</th>
			</tr>
		</thead>	
		<tbody>
        @foreach ($articles as $article)
            <tr id="{{ $article['id'] }}">
                <td>{{ $article['id'] }}</td>
                <td>{{ $article['title'] }}</td>
                <td>{{ $article['content'] }}</td>
                <td>{{ $article['userid'] }}</td>
                <td>
		     <a data-id="{{ $article['id'] }}" class="btn btn-primary btnEdit">Edit</a>
		     <a data-id="{{ $article['id'] }}" class="btn btn-danger btnDelete">Delete</button>
                </td>
            </tr>
        @endforeach
		</tbody>
    </table>
	

<!-- Add Student Modal -->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Article</h4>
      </div>
	  <div class="modal-body">
		<form id="addStudent" name="addArticle" action="{{ route('article.store') }}" method="post">
			@csrf
			<div class="form-group">
				<label for="txtTitle">Title:</label>
				<input type="text" class="form-control" id="txtTitle" placeholder="Enter Title" name="txtTitle">
			</div>
			<!-- <div class="form-group">
				<label for="txtuserid">User id:</label>
				<input type="text" class="form-control" id="txtuserid" placeholder="Enter User id" name="txtuserid">
			</div> -->
			<div class="form-group">
				<label for="txtContent">Contents:</label>
				<textarea class="form-control" id="txtContent" name="txtContent" rows="10" placeholder="Enter Contents"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	
<!-- Update Student Modal -->
<div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Article</h4>
      </div>
	  <div class="modal-body">
		<form id="updateArticle" name="updateArticle" action="{{ route('article.update') }}" method="post">
			<input type="hidden" name="articleId" id="articleId"/>
			@csrf
			<div class="form-group">
				<label for="txtTitle">Title:</label>
				<input type="text" class="form-control" id="txtTitle" placeholder="Enter Title" name="txtTitle">
			</div>
			<div class="form-group">
				<label for="txtContent">Content:</label>
				<textarea class="form-control" id="txtContent" name="txtContent" rows="10" placeholder="Enter Content"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	

<script>
  $(document).ready(function () {
	//Add the Student  
	$("#addArticle").validate({
		 rules: {
				txtTitle: "required",
				txtContent: "required",
				txtUserid: "required"
			},
			messages: {
			},
 
		 submitHandler: function(form) {
		  var form_action = $("#addArticle").attr("action");
		  $.ajax({
			  data: $('#addArticle').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
				  var article = '<tr id="'+data.id+'">';
				  article += '<td>' + data.id + '</td>';
				  article += '<td>' + data.title + '</td>';
				  article += '<td>' + data.content + '</td>';
				  article += '<td>' + data.userid + '</td>';
				  article += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
				  article += '</tr>';            
				  $('#studentTable tbody').prepend(article);
				  $('#addArticle')[0].reset();
				  $('#addModal').modal('hide');
			  },
			  error: function (data) {
			  }
		  });
		}
	});
  
 
    //When click edit student
    $('body').on('click', '.btnEdit', function () {
      var article_id = $(this).attr('data-id');
      $.get('article/' + article_id +'/edit', function (data) {
          $('#updateModal').modal('show');
          $('#updateArticle #articleId').val(data.id); 
          $('#updateArticle #txtTitle').val(data.title);
          $('#updateArticle #txtContent').val(data.content);
          $('#updateArticle #txtUserId').val(data.userid);
      })
   });
    // Update the student
	$("#updateArticle").validate({
		 rules: {
                txtTitle: "required",
				txtContent: "required"
			},
			messages: {
			},
 
		 submitHandler: function(form) {
		  var form_action = $("#updateArticle").attr("action");
		  $.ajax({
			  data: $('#updateArticle').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
				  var article = '<td>' + data.id + '</td>';
				  article += '<td>' + data.title + '</td>';
				  article += '<td>' + data.content + '</td>';
				  article += '<td>' + data.userid + '</td>';
				  article += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
				  $('#articleTable tbody #'+ data.id).html(article);
				  $('#updateArticle')[0].reset();
				  $('#updateModal').modal('hide');
			  },
			  error: function (data) {
			  }
		  });
		}
	});		
		
   //delete student
	$('body').on('click', '.btnDelete', function () {
      var article_id = $(this).attr('data-id');
      $.get('article/' + article_id +'/delete', function (data) {
          $('#articleTable tbody #'+ article_id).remove();
      })
   });	
	
});	  
</script>
@endsection