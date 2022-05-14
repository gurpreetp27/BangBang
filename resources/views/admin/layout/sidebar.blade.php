<nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="{{asset('public/adminn/assets/img/admin-avatar.png')}}" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">{{Auth::user()->name.' '.Auth::user()->last_name}} </div><small>@if(Auth::user()->role_id == 1) Administrator @else User @endif</small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="{{url('admin/home')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    @if(Auth::user()->role_id == 1)
                    <li class="heading">FEATURES</li>
                    <li class="@if(Request::segment(2)=='addcontent') active @endif">
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Add Content</span><i class="fa fa-angle-left arrow"></i></a>
                          <ul class="nav-2-level collapse">
                            <li>
                                <a class="@if(Request::segment(3)=='sport') active @endif" href="{{url('admin/addcontent/sport')}}">Add Sports</a>
                            </li>
                            <li>
                                <a class="@if(Request::segment(3)=='competition') active @endif" href="{{url('admin/addcontent/competition')}}">Add Competition</a>
                            </li>
                            <li>
                                <a class="@if(Request::segment(3)=='player') active @endif" href="{{url('admin/addcontent/player')}}">Add Player</a>
                            </li>
                            <li>
                                <a class="@if(Request::segment(3)=='team') active @endif" href="{{url('admin/addcontent/team')}}">Add Team</a>
                            </li>
                            <li>
                                <a class="@if(Request::segment(3)=='tiptype') active @endif" href="{{url('admin/addcontent/tiptype')}}">Add Tip Type</a>
                            </li>
                            <li>
                                <a class="@if(Request::segment(3)=='plan') active @endif" href="{{url('admin/addcontent/plan')}}">Add Plan</a>
                            </li>
                            <li>
                                <a class="@if(Request::segment(3)=='betcategory') active @endif" href="{{url('admin/addcontent/betcategory')}}">Add Bet Category</a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="@if(Request::segment(2)=='bets') active @endif">
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-sitemap"></i>
                            <span class="nav-label">Bets</span><i class="fa fa-angle-left arrow"></i></a>
                          <ul class="nav-2-level collapse">
                            <li>
                                <a class="@if(Request::segment(3)=='addnewbet') active @endif" href="{{url('admin/bets/addnewbet')}}">Add New Bets</a>
                            </li>
                              <li>
                                <a class="@if(Request::segment(3)=='sport') active @endif" href="{{url('admin/addcontent/sport')}}">All Bets</a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="@if(Request::segment(2)=='bets') active @endif">
                        <a href="javascript:;" aria-expanded="@if(Request::segment(2)=='bets') true @endif"><i class="sidebar-item-icon fa fa-sitemap"></i>
                            <span class="nav-label">Bets</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse @if(Request::segment(3)=='addnewbet') in @endif " aria-expanded="@if(Request::segment(3)=='addnewbet') true @endif" style="">
                          <li>
                                <a class="@if(Request::segment(3)=='allbets') active @endif" href="{{url('admin/bets/allbets')}}">
                                    <span class="nav-label">All Bets</span></a>
                              </li>      
                            <li class="@if(Request::segment(3)=='addnewbet') active @endif">
                                <a href="javascript:;" aria-expanded="true">
                                    <span class="nav-label">Add New Bets</span><i class="fa fa-angle-left arrow"></i></a>
                                  <ul class="nav-3-level collapse @if(Request::segment(4)=='singlebet') in @endif @if(Request::segment(4)=='multiplebet') in @endif " aria-expanded="true" style="">
                                    <li>
                                        <a class="@if(Request::segment(4)=='singlebet') active @endif" href="{{url('admin/bets/addnewbet/singlebet')}}">Single Bet</a>
                                    </li>
                                    <li>
                                        <a class="@if(Request::segment(4)=='multiplebet') active @endif" href="{{url('admin/bets/addnewbet/multiplebet')}}">Multiple Bet</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                     <li class="@if(Request::segment(2)=='memberships') active @endif">
                        <a href="{{url('admin/memberships/users')}}"><i class="sidebar-item-icon fa fa-users"></i>
                            <span class="nav-label">Memberships</span>
                        </a>
                    </li>
                    <li class="@if(Request::segment(2)=='result') active @endif">
                        <a href="javascript:;" aria-expanded="@if(Request::segment(2)=='result') true @endif"><i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Platform Result</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse @if(Request::segment(3)=='allresult') in @endif " aria-expanded="@if(Request::segment(3)=='allresult') true @endif" style="">
                          <li>
                            <a class="@if(Request::segment(3)=='allresult') active @endif" href="{{url('admin/result/allresult')}}">
                                <span class="nav-label">All Result</span></a>
                          </li>  
                          <li>
                            <a class="@if(Request::segment(3)=='monthlyresult') active @endif" href="{{url('admin/result/monthlyresult')}}">
                                <span class="nav-label">Monthly Result</span></a>
                          </li>      
                        
                        </ul>
                    </li>
                      <li class="@if(Request::segment(2)=='review') active @endif">
                        <a href="{{url('admin/review/allreview')}}"><i class="sidebar-item-icon fa fa-star"></i>
                            <span class="nav-label">Reviews</span>
                        </a>
                    </li>
                    @else
                    <li class="heading">MANAGE ACCOUNT</li>
                    <li class="@if(Request::segment(2)=='manageaccount' && Request::segment(3)=='user') active @endif">
                        <a href="{{url('/admin/manageaccount/user')}}"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">UPDATE INFO</span>
                        </a>
                    </li>

                    <li class="@if(Request::segment(3)=='membership') active @endif">
                        <a href="{{url('/admin/manageaccount/membership')}}"><i class="sidebar-item-icon fa fa-handshake-o"></i>
                            <span class="nav-label">YOUR MEMBERSHIP</span>
                        </a>
                    </li>

                    <li class="@if(Request::segment(2)=='BETS') active @endif">
                        <a href="{{url('/bets-day')}}"><i class="sidebar-item-icon fa fa-users"></i>
                            <span class="nav-label">YOUR BETS FOR TODAY</span>
                        </a>
                    </li> 


                    <li class="@if(Request::segment(2)=='Result') active @endif">
                        <a href="{{url('/results')}}"><i class="sidebar-item-icon fa fa-file"></i>
                            <span class="nav-label">BANG BANG RESULTS</span>
                        </a>
                    </li>

                    <li class="@if(Request::segment(2)=='review') active @endif">
                        <a href="{{url('admin/review/allreview')}}"><i class="sidebar-item-icon fa fa-star"></i>
                            <span class="nav-label">YOUR REVIEWS</span>
                        </a>
                    </li>
                    @endif
                     <li class="@if(Request::segment(2)=='template') active @endif">
                        <a href="{{url('admin/template/alltemplate')}}"><i class="sidebar-item-icon fa fa-file"></i>
                            <span class="nav-label">Email Templates</span></a>
                    </li>

                </ul>
            </div>
        </nav>