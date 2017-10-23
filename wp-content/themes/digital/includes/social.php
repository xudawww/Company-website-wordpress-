<!--   
Package: Free Social Media Icons
Author: Konstantin 
Source: http://kovshenin.com/2011/freebies-a-simple-social-icon-set-gpl/

License: GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
-->

<ul class="spicesocialwidget">

<?php if(of_get_option('digital_fb')) : ?>
<li class="facebook">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_fb'));?>" target="_blank" title="facebook"><i class="fa fa-facebook"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_gp')) : ?>
<li class="googleplus">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_gp'));?>" target="_blank" title="googleplus"><i class="fa fa-google-plus"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_pinterest')) : ?>
<li class="pinterest">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_pinterest'));?>" target="_blank" title="pinterest"><i class="fa fa-pinterest-p"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
	<?php if(of_get_option('digital_tw')) : ?>
<li class="twitter">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_tw'));?>" target="_blank" title="twitter"><i class="fa fa-twitter"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_rss')) : ?>
<li class="rss">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_rss'));?>" target="_blank" title="rss"><i class="fa fa-rss"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_skype')) : ?>
<li class="skype">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_skype'));?>" target="_blank" title="Skype"><i class="fa fa-skype"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_vimeo')) : ?>
<li class="vimeo">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_vimeo'));?>" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_dribbble')) : ?>
<li class="dribbble">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_dribbble'));?>" target="_blank" title="dribble"><i class="fa fa-dribbble"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_flickr')) : ?>
<li class="flickr">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_flickr'));?>" target="_blank" title="flickr"><i class="fa fa-flickr"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_in')) : ?>
<li class="linkedin">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_in'));?>" target="_blank" title="linkedin"><i class="fa fa-linkedin"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_youtube')) : ?>
<li class="youtube">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_youtube'));?>" target="_blank" title="youtube"><i class="fa fa-youtube-play"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
<?php if(of_get_option('digital_instagram')) : ?>
<li class="instagram">
<a rel="nofollow" href="<?php echo esc_url(of_get_option('digital_instagram'));?>" target="_blank" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i>
</a></li>
<?php else : ?>
<?php endif; ?>
</ul>