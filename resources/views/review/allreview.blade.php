@extends('layouts.main')
@section('content')

  <section class="wi-full py-5 text-center all-margin">
        <div class="container">
            <div class="title-main wi-full">
                <h2>{{ __('member.reviews_menu') }}</h2>
            </div>
            <div class="wi-full pt-5">
             @if(count($data) < 1)
                <div class="ibox-head">
                    <a href="{{url('reviews')}}" class="btn btn-default">{{ __('member.add_review') }}</button>
                </div>
                <h3>{{ __('member.now_review_found') }}!!</h3>
             @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm result-table reviw-table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>{{ __('member.name') }}</th>
                                    <th>{{ __('member.stars') }}</th>
                                    <th>{{ __('member.comment') }}</th>
                                    <th>{{ __('member.datetime') }}</th>
                                    <th>{{ __('member.status') }}</th>
                                    <th>{{ __('member.action') }}</th>
                                  </tr>
                                </thead>
                                <tbody>
                                   @if(count($data) > 0)
                                    @php 
                                      $counter=1;
                                    @endphp
                                     @foreach($data as $review)
                                  <tr>
                                    <td>{{$counter++}}</td>
                                    <td>{{$review['name']}}</td>
                                    <td>{{$review['star']}}</td>
                                    <td class="text-left">{{trim($review['comment'])}}</td>
                                    <td>{{$review['created_at'] }}</td>
                                    <input type="hidden" name="" value="{{$review['id']}}" class="betId">
                                     <td class="statustd">
                                       @if($review['status']=='Pending')
                                        <span class="badge badge-warning badge-pill m-b-5">{{ __('member.pending') }}</span>
                                       @endif
                                       @if($review['status']=='Approved')
                                        <span class="badge badge-success badge-pill m-b-5">{{ __('member.approved') }}</span>
                                       @endif
                                       @if($review['status']=='Disapproved')
                                        <span class="badge badge-danger badge-pill m-b-5">{{ __('member.disapproved') }}</span>
                                       @endif
                                     </td>
                                    <td>
                                   
                                      <a href="{{url('review/edit',$review['id'])}}" class="btn btn-default btn-xs m-r-5 editReview" data-original-title="Edit"> 
                                               <i class="fa fa-pencil font-14"></i>
                                            </a>
                                          <a href="javascript:void(0)" class="btn btn-default btn-xs deleteReview" data-original-title="Delete"> 
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
                @endif
            </div>
        </div>
    </section>

   
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
     <script type="text/javascript">
          $('.deleteReview').click(function(e){
      if(confirm("Are you sure you want to delete this Review?")===true){
            var parent = $(this).parent().parent();
            var Ids = parent.find('.betId').val();
            $.ajax({
             type:'POST',
             url:'{{url('review/deleteReview')}}',
             data:{'_token': '{{ csrf_token() }}','id':Ids},
             success:function(data) {
                if(data=='success'){
                  alert('Review has been Removed, Successfully!','success');
                  setTimeout(function(){ location.reload(); }, 4000);
                }
             }
          });
      }
    });
     </script>
    @endsection