@extends('layouts.app')

@section('content')
@section ('page_title')
Ajouter une categorie
@endsection
@if (session('ok'))
   
   <div class="alert alert-success alert-dismissible fade in">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
           <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
   </div>
@endif

<div id="main-content">
    <div class="card alert">
        <div class="card-header">
            <h4></h4>
            <div class="card-header-right-icon">
              
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                <div class="horizontal-form">
                <form class="form-horizontal" method="post" id="form-add-category" action="{{ route('category.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class=" control-label">Nom catégorie</label> <br><br>
                                <div class="">
                                    <input type="text" name="name" required class="form-control" id="cat">
                                </div>
                            </div>
                        </div>

                    </div>

                   
                    <br>
                    <br>
                    <div class="row">
                        <div class="">
                            <button id="ajouter-photo" style="width:160px" name="ajouterSeul" class="btn btn-lg btn-success"> @lang('Ajouter')</button>
                        </div>
                    </div>

                </form>
            </div>

                </div>



                <div class="col-lg-7 col-md-7" id="table-data">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Categorie</th>
                                <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>
                                        <span><a href="" class="update" data-category="{{$category->name}}" data-id="{{$category->id}}"   data-toggle="modal"  data-target="#add-category"  title="@lang('Modifier ') "><i class="large material-icons color-info">edit</i></a></span>
                                        <span><a  href="{{ route('category.delete', $category->id) }}" class="delete" data-toggle="tooltip" title="@lang('supprimer ') "><i class="large material-icons color-danger">delete</i> </a></span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>


            <!-- BEGIN MODAL -->

<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>@lang('Modifier une catégorie') </strong></h4>
            </div>
            <div class="modal-body">
                <form id="formCat">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <label class="control-label">@lang('Catégorie')</label>
                            <span > </span>
                            <input class="form-control form-white" type="text" name="category"  value="" id="category-name">
                        </div>
                    </div>
                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="user_id" value="">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('Fermer')</button>
                <button type="button" id="sauvegarder" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">@lang('Sauvegarder')</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- END MODAL -->

        </div>
    </div>
</div>


@endsection

@section('js-content')

<script>
var table = $('#example').DataTable({

});


$(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#form-add-category').on('submit',function(e) {
        let that = $(this)
        e.preventDefault();
        $.ajax({                        
                url: "{{ route('category.store') }}",
                type: 'POST',
                data: $('#form-add-category').serialize(),
                success: function(data,status){
                    var name = data.name; 
                    var id = data.id; 
                    
                    $("#cat").val("");
                    $('tbody').append( `
                    <tr>
                                    <td>${name}</td>
                                    <td>
                                            <span><a href="" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-info">edit</i></a></span>
            
                                            <span><a  href="" class="delete" data-toggle="tooltip" title="@lang('supprimer ') "><i class="large material-icons color-danger">delete</i> </a></span>
                                            
                                            </td>
                                </tr>

                    
                    `);
                    
                },
                error: function(data,status,error){
                    console.log("erreurv : "+data+status);
                    
                },
            })


        
    });          
});


// MODIFIER

var cat_id = null; 

$('.update').on('click',function(e){
    $('#category-name').val($(this).attr('data-category'));
     id = $(this).attr('data-id');
});

$('#sauvegarder').on('click',function(e){
    
   
    var url = "{{ url('/category/update/') }}";
    url += '/'+id
    $.ajax({                        
            url: url,
            type: 'PUT',
            data: $("#formCat").serialize() ,
            success: function(data,status){
               
                console.log(data);
                location.reload();
                
            },
            error: function(data,status,error){
                console.log("erreurv : "+data+status);
                
            },
        });

   
    
});

// SUPPRIMER
$(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('a.delete').click(function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})
        swalWithBootstrapButtons({
            title: '@lang('Vraiment supprimer cet utilisateur  ?')',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: '@lang('Oui')',
            cancelButtonText: '@lang('Non')',
            
        }).then((result) => {
            if (result.value) {
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url: that.attr('href'),
                        type: 'DELETE'
                    })
                    .done(function (data) {
                            that.parents('tr').remove()
                            console.log(that.parents('tr')[0]);
                            
                    })
                swalWithBootstrapButtons(
                'supprimé!',
                'L\'utilisateur a bien été supprimé.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'L\'utlisateur n\'a pas été supprimé :)',
                'error'
                )
            }
        })
            })
        })



    
</script>                                   
@endsection