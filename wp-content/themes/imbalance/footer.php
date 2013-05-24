<div id="about">
	<a id="gotop">go top</a>
	<h1>About</h1>
	<h2><?php the_field("claim",2); ?></h2>
	<p class="side"><?php the_field("about",2); ?></p>
	<div id="network"></div>
	<div class="cats">
		<ul>
	    	<li><a id="meet_team" href="#meet_team" rel="toggle[team]" title="" <?php if ( is_front_page()) { ?> class="active"<?php } ?> >Meet the team</a></li>
	    </ul>
	</div>
	
	<div id="team">
		<ul class="mcol2">
			<?php the_contributors();?>
		</ul>
	</div>
</div>
        <div id="footer">
        	<div id="copyright"><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" /></a></div>
            <div id="credits">The Doers s.r.l ~ P.IVA 10766230014 ~ Torino, Via San Domenico 30 ~ we@thedoersproject.com ~ Designed by <a href="http://wpshower.com/">WPSHOWER</a></div>
        </div>
    </div>
<?php wp_footer(); ?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</body>
</html>
