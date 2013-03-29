<div class="header-wrapper">
    <div class="header">
    	<div class="header__left">
    		<img class="logo" width="200" height="200" src="http://fc08.deviantart.net/fs70/f/2012/178/d/e/de957d5233a90be43dc68aba70903713-d55159s.jpg">
    	</div>
		<div class="header__right">
			<div class="header__username">Hello, <?php print $username; ?></div>
			<div class="header__nav">
				<a href="./home" class="btn">Home</a>
			    <a href="./account" class="btn">Account</a>
			    <form action="./?c=user&d=./" method="POST">
			    	<input type="submit" value="Logout" class="btn">
			    	<input type="hidden" name="CMD" value="unauthenticate">
			    </form>
			</div>
		</div>
    </div>
</div>