@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')

@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Add Bet Category</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/addcontent/betcategory/save')}}" method="post">
                                 @csrf
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>BetCategory Name</label>
                                            <input class="form-control" type="text" placeholder="Betcategory Name" value="{{old('betcategoryName')}}" name="betcategoryName">
                                        </div>
                                        <!-- <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" placeholder="First Name">
                                        </div> -->
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">BetCategory</div>
                    </div>
                    <div class="ibox-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50px">#</th>
                                        <th>BetCategory Name</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if(count($sports) > 0)
                                     @php 
                                      $counter = 1;
                                     @endphp
                                     @foreach($sports as $sport)
                                     <tr>
                                      <td>{{$counter++}}</td>   
                                      <td>{{$sport['name']}}</td>   
                                      <td>{{date('d M,Y',strtotime($sport['created_at']))}}</td>
                                      <td>
                                      <input type="hidden" name="" value="{{$sport['id']}}" class="gamerId">
                                      <a href="{{url('admin/addcontent/betcategory/edit',$sport['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit"> 
                                         <i class="fa fa-pencil font-14"></i>
                                      </a>
                                       <a href="javascript:void(0)" class="btn btn-default btn-xs deletes" data-original-title="Delete"> 
                                         <i class="fa fa-trash font-14"></i>
                                      </a>
                                    </td>
                                    </tr>
                                     @endforeach
                                   @endif 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
@endsection

@push('script')
<script type="text/javascript">
    $('.deletes').click(function(e){
    if(confirm("Are you sure you want to delete this BetCategory?")===true){
      var parent = $(this).parent();
      var Ids = parent.find('.gamerId').val();
      $.ajax({
           type:'POST',
           url:'{{url('admin/addcontent/betcategory/remove')}}',
           data:{'_token': '{{ csrf_token() }}','id':Ids},
           success:function(data) {
              if(data=='sucess'){
                  showMessage('BetCategory has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
              }
           }
        });
    }

        
    });
</script>
@endpush