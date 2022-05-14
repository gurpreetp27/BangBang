	<footer class="wi-full py-5">
	
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="footer-logo">
						<a href="{{url('/')}}"><img src="{{asset('public/front/images/bang-logo.svg')}}" class="img-fluid"></a>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="footer-menu">
						<ul>
							<li><a href="{{url('/')}}">{{__('member.home_menu')}}</a></li>
							<li><a href="{{url('/bets-day')}}">{{__('member.bet_menu')}}</a></li>
							<li><a href="{{url('/results')}}">{{__('member.results_menu')}}</a></li>
							<li><a href="{{url('/reviews')}}">{{__('member.reviews_menu')}}</a></li>
							<li><a href="{{url('/contact')}}">{{__('member.contact_menu')}}</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="footer-menu">
						<ul>
							<li><a href="{{url('/gdpr')}}">{{__('member.ld')}}</a></li>
							<li><a href="{{url('/terms-conditions')}}">{{__('member.T_C')}}</a></li>
							<li><a href="{{url('/privacy-policy')}}">{{__('member.P_P')}}</a></li>
						</ul>
						<div class="prohbit">
							<p>{{__('member.gipfm')}}</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="footer-menu copyright">
						<p>&copy; 2019 Bang Bang, LLC</p>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<div class="loader" style="display: none;">
		<img src="{{asset('public/front/images/loading.gif')}}">
	</div>