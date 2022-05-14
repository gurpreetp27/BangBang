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
                                <div class="ibox-title">Add Plan</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/addcontent/plan/save')}}" method="post">
                                 @csrf
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Plan Name</label>
                                            <input class="form-control" type="text" placeholder="Plan Name" value="{{old('planName')}}" name="planName">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Amount</label>
                                            <input class="form-control" type="text" placeholder="Amount" name="amount" value="{{old('amount')}}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Duration(Month)</label>
                                            <input class="form-control" type="text" placeholder="Duration" name="duration" value="{{old('duration')}}">
                                        </div>
                                    </div>
                                      <div class="col-sm-12 form-group">
                                          <label>Stats</label>
                                          <textarea class="form-control" rows="5" name="stats">{{old('stats')}}</textarea>
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
                        <div class="ibox-title">Plans</div>
                    </div>
                    <div class="ibox-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50px">#</th>
                                        <th>Plan Name</th>
                                        <th>Amount</th>
                                        <th>Duration</th>
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
                                      <td>{{number_format($sport['amount'])}}</td>  
                                      <td>{{$sport['duration']}} Month</td>  
                                      <td>{{date('d M,Y',strtotime($sport['created_at']))}}</td>
                                      <td>
                                      <input type="hidden" name="" value="{{$sport['id']}}" class="gamerId">
                                      <a href="{{url('admin/addcontent/plan/edit',$sport['id'])}}" class="btn btn-default btn-xs m-r-5" data-original-title="Edit"> 
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
     if(confirm("Are you sure you want to delete this Plan?")===true){
      var parent = $(this).parent();
      var Ids = parent.find('.gamerId').val();
      $.ajax({
           type:'POST',
           url:'{{url('admin/addcontent/plan/remove')}}',
           data:{'_token': '{{ csrf_token() }}','id':Ids},
           success:function(data) {
              if(data=='sucess'){
                  showMessage('Plan has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
              }
           }
        });
    }

        
    });
</script>
@endpush