@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
 <link href="{{asset('public/adminn/assets/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
<style type="text/css">
                #teamSelected,#playerSelected{
                  display: none;
                }
                #playerSelected span.select2.select2-container {
    width: 100%!important;
}
#teamSelected span.select2.select2-container {
    width: 100%!important;
}
.list-group-item{
  padding: 0 !important;
}
</style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Add Singel Bet</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/bets/addsinglesave')}}" method="post" id="form-id-tosub">
                                 @csrf
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Competition</label>
                                             <select class="form-control input-sm select2_demo_1" name="competition">
                                             <option value="">Select Option</option>
                                             @if(count($data['competition']) > 0)
                                               @foreach($data['competition'] as $com)
                                                <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                @endforeach
                                             @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Sport</label>
                                            <select class="form-control input-sm select2_demo_2" name="sport">
                                                <option value="">Select Option</option>
                                                 @if(count($data['sport']) > 0)
                                                   @foreach($data['sport'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                    </div>
                                      <div class="row">
                                        <div class="col-sm-8 form-group">
                                            <label>Date and Time</label>
                                              <div class='input-group date' id='datetimepicker1' >
                                                  <input type='text' class="form-control" name="datetime" id="datetimer" />
                                                  <span class="input-group-addon">
                                                      <span class="glyphicon glyphicon-calendar"></span>
                                                  </span>
                                              </div>
                                        </div>
                                      </div> 
                                      <hr> 
                                      <div class="col-12 m-b-20">
                                          <label>Whos is Playing</label>
                                          <div class="check-list">
                                          <div class="row">
                                           <input type="hidden" name="whostype" id="selectedwhoestype" value="">
                                            <div class="col-6">
                                                <label class="ui-radio ui-radio-success">
                                                <input type="radio" name="whosplaying" value="team">
                                                <span class="input-span"></span>Team</label>
                                            </div>
                                            <div class="col-6">
                                                <label class="ui-radio ui-radio-success">
                                                <input type="radio" name="whosplaying" value="individual">
                                                <span class="input-span"></span>Individual</label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12 " id="teamSelected">
                                        <div class="col-sm-6 form-group">
                                            <label>Team A</label>
                                             <select class="form-control input-sm select2_demo_3" name="teamA">
                                                <option value="">Select Option</option>
                                                 @if(count($data['team']) > 0)
                                                   @foreach($data['team'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Team B</label>
                                             <select class="form-control input-sm select2_demo_4" name="teamB">
                                                <option value="">Select Option</option>
                                                 @if(count($data['team']) > 0)
                                                   @foreach($data['team'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 " id="playerSelected">
                                        <div class=" col-sm-6 form-group" >
                                            <label>Player A</label>
                                             <select class="form-control input-sm select2_demo_5" name="playerA">
                                                <option value="">Select Option</option>
                                                 @if(count($data['player']) > 0)
                                                   @foreach($data['player'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Player B</label>
                                             <select class="form-control input-sm select2_demo_6" name="playerB">
                                                <option value="">Select Option</option>
                                                 @if(count($data['player']) > 0)
                                                   @foreach($data['player'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                       </div> 
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-sm-6 form-group" >
                                        <label>Tip Type</label>
                                         <select class="form-control select2_demo_6" name="tiptype">
                                             <option value="">Select Option</option>
                                                 @if(count($data['tiptype']) > 0)
                                                   @foreach($data['tiptype'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                        </select>
                                    </div>
                                     <div class="col-sm-6 form-group" >
                                        <label>Odds</label>
                                        <input class="form-control oddsa removechar" type="text" name="odds">
                                     </div>
                                    </div>
                                   <div class="row">
                                      <div class="col-sm-6 form-group" >
                                        <label>Actual Tip</label>
                                        <input class="form-control actualtips" type="text" placeholder="Actual Tip" name="actualtip">
                                      </div>
                                     <div class="col-sm-6 form-group" >
                                        <label>Bet Category</label>
                                         <select class="form-control" name="betcategory" style="    height: 35px;">
                                             @if(count($data['betcategory']) > 0)
                                               @foreach($data['betcategory'] as $com)
                                                <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                @endforeach
                                             @endif
                                        </select>
                                    </div>
                                   </div> 
                                   <hr>
                                   <div class="row">
                                      <div class="col-sm-6 form-group" >
                                            <label>Trust Note</label>
                                             <select class="form-control" name="rating" style="height: 35px;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                    </div>
                                   <!--  <div class="col-sm-6 form-group" >
                                        <label>Comment</label>
                                          <input class="form-control" type="text" placeholder="(optional)">
                                    </div> -->
                                   </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="button" id="createPreview">Save</button>
                                        <!-- <button class="btn btn-default" type="submit">Save</button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bit Preview</h4>
                  </div>
                  <div class="modal-body">
                     <ul class="list-group list-group-full list-group-divider">
                      
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-succees" id="saveForm">Save</button>
                  </div>
                </div>
                
              </div>
          </div>
@endsection

@push('script')
<script type="text/javascript">
   
     $("input[name='whosplaying']").click(function(){
            var radioValue = $("input[name='whosplaying']:checked").val();
            if(radioValue=='team'){
                $('#playerSelected').hide();
                $('#teamSelected').show();
                $('#selectedwhoestype').val('team');
            }else{
                $('#playerSelected').show();
                $('#teamSelected').hide();
                $('#selectedwhoestype').val('individual');
            }
        });

     $('#createPreview').click(function(e){
        var competionid = $('select[name="competition"] option:selected').attr("data-title");
        var sportid = $('select[name="sport"] option:selected').attr("data-title");
        var tyep =  $('#selectedwhoestype').val();
        if(tyep=='team'){
           var teamid1 = $('select[name="teamA"] option:selected').attr("data-title");
           var teamid2 = $('select[name="teamB"] option:selected').attr("data-title");
           var player1 = 'none';
           var player2 = 'none';
        }else{
           var player1 = $('select[name="playerA"] option:selected').attr("data-title");
           var player2 = $('select[name="playerB"] option:selected').attr("data-title");
           var teamid1 = 'none';
           var teamid2 = 'none';
        }
        var datetime = $('#datetimer').val();
        var tiptypeid = $('select[name="tiptype"] option:selected').attr("data-title");
        var betcatid = $('select[name="betcategory"] option:selected').attr("data-title");
        var rating = $('select[name="rating"] option:selected').val();
        var actualtips = $('.actualtips').val();
        var odds = $('.oddsa').val();
        if(competionid!='' && teamid1!='' && teamid2!='' &&  player1!='' &&  player2!='' && sportid!='' && tiptypeid!='' && betcatid!='' && datetime!='' && odds!='' && actualtips!='' && rating!='' ){
          var datat = createPreviewfun(competionid,teamid1,teamid2,player1,player2,sportid,tiptypeid,betcatid,actualtips,odds,rating);
          //console.log(datat);
        }else{
          showMessage('All fields Are Require!','danger');
        }


     });

     function createPreviewfun(competionid,t1,t2,p1,p2,sportid,tiptypeid,betcatid,tips,odds,rating) {
           var timeStamp = "EST";
            $('.list-group-full').html('');
             var datetime = $('#datetimer').val();
            var html = "<li class='list-group-item'>Date Time:- "+datetime+" "+timeStamp+"</li><li class='list-group-item'>Competition Name:-"+competionid+"</li><li class='list-group-item'>Sport Name:-"+sportid+"</li>";
             var tyep =  $('#selectedwhoestype').val();
             if(tyep=='team'){
              html+="<li class='list-group-item'>TeamA Name:-"+t1+"</li><li class='list-group-item'>TeamB Name:-"+t2+"</li>";
             }else{
                  html+="<li class='list-group-item'>PlayerA Name:-"+p1+"</li><li class='list-group-item'>PlayerB Name:-"+p2+"</li>";
             }
             html+="<li class='list-group-item'>whosplaying:- "+tyep+"</li><li class='list-group-item'>Tip Type:-"+tiptypeid+"</li><li class='list-group-item'>Odds:-"+odds+"</li><li class='list-group-item'>Actual Tips:-"+tips+"</li><li class='list-group-item'>Bet Category:-"+betcatid+"</li><li class='list-group-item'>Rating:-"+rating+"</li>";
            $('.list-group-full').append(html);
             //console.log(data)
             $('#myModal').modal({
                  backdrop: 'static',
                  keyboard: false
              })
   
     }

     $('#saveForm').click(function(e){
          $("#form-id-tosub").submit();
     });


</script>
  
   
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        
        
        <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
        
   <script src="{{asset('public/adminn/assets/vendors/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $('#datetimer').datetimepicker({
             format: "D MMM,YYYY - HH:mm",
        });
        $(".select2_demo_1").select2();
        $(".select2_demo_2").select2();
        $(".select2_demo_3").select2();
        $(".select2_demo_4").select2();
        $(".select2_demo_5").select2();
        $(".select2_demo_6").select2();
        $(".select2_demo_7").select2();
    });

$(".removechar").keyup(function() {
    var $this = $(this);
    $this.val($this.val().replace(/[^\d.]/g, ''));        
});
    </script>
@endpush