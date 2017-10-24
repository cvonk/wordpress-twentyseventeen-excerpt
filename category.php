<script>
window.addEventListener("load", function() {
  jQuery("article").each(function(ii,obj) {
      obj.onclick = function() {
        jQuery("article")[ii].setAttribute("data-clicked", "1");
      };
  });
});
  
/*
  jQuery("article").each(function(ii,obj) {
      setTimeout(function(){
        $(obj).animate({opacity:1});
      }, ii * 100);
  });
*/
</script>
<style>
div#primary.content-area {
  max-width: 1800px !important;
}

/* Adds cards and thumbnails to the Wordpress theme twentyseventeen 
   The .css and .html are incorporated in my category.php
   used in e.g. https://coertvonk.com/category/technology/logic
   Copyright (c) 2017 by Coert Vonk

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/*
div#primary.content-area {
  max-width: 100% !important;
}
*/
article.post a {
  border-bottom: 2px solid rgb(180, 230, 250);
  color: inherit;
  transition: background 0.15s cubic-bezier(0.33, 0.66, 0.66, 1);
  -webkit-transition: background 0.15s cubic-bezier(0.33, 0.66, 0.66, 1);
  -moz-transition: background 0.15s cubic-bezier(0.33, 0.66, 0.66, 1);
  text-decoration: none !important;
  box-shadow: none !important;
}
article.post a:hover {
  color: inherit;
  background-color: rgba(180, 230, 250, 0.35);
}
article.post.style2 a {
  border-bottom-color: rgba(180, 230, 250, 0);
}
article.post.style2 a:hover {
  border-bottom: 2px solid #b4e7f8;
  border-bottom-style: solid;
  border-bottom-color: rgb(180, 230, 250);
  color: inherit;
  background-color: rgba(180, 230, 250, 0);
}
article.post a > img {
  border: none;
  vertical-align: top;
}

/* flex-container */

div.flex-container > section {
  /*max-width: 1800px;*/
  padding-left: 2rem;
  padding-right: 2rem;
  margin-left: auto;
  margin-right: auto;
  padding-top: 0;
  padding-bottom: 0;
}

/* see https://css-tricks.com/snippets/css/a-guide-to-flexbox/ */
.article-container {
  display: flex;
  flex-flow: row wrap;
  justify-content: flex-start;
  align-items: stretch;
  align-content: stretch;
}

/* sections */

/* article */

article.post {
  position: relative;
  z-index: 1;
  overflow: hidden;
  opacity: 1;
  font-size: 0; /* prevent space between the div's */
}
article.post.style1 {
  margin-top: 1rem;
  margin-bottom: 1rem;
}
article.post.style2 {
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
}
article.post.style1:first-child {
  margin-top: 0rem;
}

/* article styles */

article.style1 {
  box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 6px, rgba(0, 0, 0, 0.12) 0px 1px 4px;
  background-color: #f8f8f8;
}
article.style2 {
  color: white;
}

/* article picture */

article > .picture-container {
  float: left;
  position: relative;
  overflow: hidden;
  /*max-width: 100%;*/
}

article.style1 > .picture-container {
  margin-right: 2%;
}
article > .picture-container > a:before {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 2;
  background-color: rgba(84, 149, 237, 0.7); /* cornflowerblue */
}

article.mask-circle > .picture-container > a:before {
  width: 0;
  height: 0;
  padding: 25%;
  border-radius: 50%;
  transition: transform 0.3s ease, opacity 0.3s ease-out;
  transform: translate(-50%, -50%) scale(0);
  will-change: opacity, transform;
  opacity: 0;
}
article.mask-circle:hover > .picture-container:before {
  opacity: 1;
  transform: translate(-50%, -50%) scale(4);
  transition-duration: 0.6s;
}
article.mask-triangle > .picture-container > a:before {
  width: 100%;
  height: 100%;
  opacity: 0;
  clip-path: polygon(50% 10%, 15% 90%, 85% 90%);
  transition-property: transform, opacity;
  transition-duration: 0.2s, 0.4s;
  transition-delay: 0.4s, 0s;
  transition-timing-function: ease-out;
  will-change: transform, opacity;
  transform: translate(-50%, -50%) scale(1);
}
article.mask-triangle:hover > .picture-container > a:before {
  opacity: 1;
  transform: translate(-50%, -50%) scale(5);
  transition-delay: 0.1s, 0s;
  transition-duration: 0.4s;
}

article > .picture-container > a > img {
  z-index: 1;
}

article.zoom-photo > .picture-container > a > img {
  transition: transform 0.4s cubic-bezier(0.71, 0.05, 0.29, 0.9);
  will-change: transform;
  transform: scale(1);
}
article.zoom-photo:hover > .picture-container > a > img {
  transform: scale(1.2);
}
article.zoom-rotate-photo > .picture-container > a > img {
  transition: transform 0.4s cubic-bezier(0.71, 0.05, 0.29, 0.9);
  will-change: transform;
  transform: scale(1) rotate(0);
}
article.zoom-rotate-photo:hover > .picture-container > a > img {
  transform: scale(1.2) rotate(5deg);
}
article.zoom-slide-photo > .picture-container > a > img {
  transition: transform 0.4s cubic-bezier(0.71, 0.05, 0.29, 0.9);
  will-change: transform;
  transform: scale(1) translate(0, 0);
}
article.zoom-slide-photo:hover > .picture-container > a > img {
  transform: scale(1.2) translate(4%, 4%);
}

/* article text */

article > .article-text {
  font-family: Segoe UI, Roboto, Open Sans, Ubuntu, Fira Sans, Helvetica Neue,
    sans-serif;
  font-size: 1rem;
}
article.style2 > .article-text {
  padding: 0px 5px 5px 10px;
  position: absolute;
  left: 0;
  bottom: 0;
  z-index: 3;
  background-color: rgba(84, 149, 237, 0.85);
  background: linear-gradient(
    75deg,
    rgba(84, 149, 237, 0.85) 70%,
    rgba(84, 149, 237, 0) 100%
  );
}

article > .article-text > a {
  margin-top: 0;
  margin-bottom: 0;
  font-size: 1.2em;
  display: block;
  align: top;
}
article.style2 > .article-text > a {
  font-weight: 400;
  font-size: 1em;
  color: white;
}

article > .article-text > span {
  margin-top: 0.5em;
  font-size: 1em;
  line-height: 0.9;
}

article.style2 > .article-text > span {
  font-size: 0.7em;
}

/* article footer */

article.style1 > .article-footer {
  display: inline-block;
  width: 100%; /* spread out over the whole width */
  bottom: 0;
  left: 0;
  font-family: Segoe UI, Roboto, Open Sans, Ubuntu, Fira Sans, Helvetica Neue,
    sans-serif;
  font-size: 0.8rem;
  background: #eeeeee;
  color: #999;
  text-align: center;
}

article.style1 > .article-footer > a {
  color: #999;
  text-decoration: none;
}

article.style2 > .article-footer {
  font-size: 0;
  width: 0;
}

/* spinner */

.spinner {
  position: absolute;
  left: 30%;
  top: 30%;
  width: 40%;
  height: 40%;
  -webkit-animation: rotator 1.6s linear infinite;
  opacity: 0;
  z-index: 2;
}
article[data-clicked="1"] .picture-container > a > .spinner {
  opacity: 1;
}
@keyframes rotator {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(270deg); }
}
.path {
  stroke-dasharray: 187;
  stroke-dashoffset: 0;
  transform-origin: center;
  animation: dash 1.6s ease-in-out infinite, colors 6.4s ease-in-out infinite;
}
@keyframes colors {
  0% {
    stroke: #4285f4;
  }
  25% {
    stroke: #de3e35;
  }
  50% {
    stroke: #f7c223;
  }
  75% {
    stroke: #1b9a59;
  }
  100% {
    stroke: #4285f4;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 187;
  }
  50% {
    stroke-dashoffset: 47;
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 187;
    transform: rotate(450deg);
  }
}
@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 187;
  }
  50% {
    stroke-dashoffset: 47;
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 187;
    transform: rotate(450deg);
  }
}
@-moz-keyframes dash {
  0% {
    stroke-dashoffset: 187;
  }
  50% {
    stroke-dashoffset: 47;
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 187;
    transform: rotate(450deg);
  }
}

article {
  margin-right: 2%;
}
article.style1 {
  width: 100%;
}
article > .picture-container > a > img {
  width: 100%;
  maximum-width: 200px;
}
article.style2 > .picture-container {
  width: 100%;
}

@media screen and (min-width: 1601px) {
  article,
  article.style1 > .picture-container {
    width: 10.5%;
  }
}
@media screen and (min-width: 801px) and (max-width: 1600px) {
  article.style2,
  article.style1 > .picture-container {
    width: 23%;
  }
}
@media screen and (min-width: 401px) and (max-width: 800px) {
  article.style2,
  article.style1 > .picture-container {
    width: 48%;
  }
}
@media screen and (max-width: 400px) {
  article.style2,
  article.style1 > .picture-container {
    width: 100%;
  }
  article {
    margin-right: 0;
  }
}

@media screen and (max-width: 600px) {
  html {
    font-size: 70%;
  }
}
</style>
<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
	  <main id="main" class="site-main" role="main">

            <div class="flex-container">
              <section>
                <div class="article-container">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

			      $this_category = get_the_category()[0]->cat_name;

			      $thumbnail_categories = explode(',', get_theme_mod('cvonk_thumb_categories'));
			      $style = "style1";
			      foreach($thumbnail_categories as $thumb_category_id) {
			      	  $thumb_category = &get_category((int)$thumb_category_id);
				  if( !strcasecmp($thumb_category->slug, $this_category)) {
				      $style = "style2";
				  }
			      }
                              ?>

                              <article class="post <?php echo($style); ?> mask-triangle zoom-rotate-photo">
                                <div class="picture-container">
				  <a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                                    <?php if(has_post_thumbnail()): the_post_thumbnail($size="200 200"); endif; ?>
                                    <svg name="spinner" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                      <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                                    </svg>    
                                  </a>          
                                </div>
                                <div class="article-text">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                    <span><?php echo preg_replace('|<a.*?/a>|', '', get_the_excerpt()); ?></span>
                                </div>
                                <div class="article-footer">By <?php the_author(); ?>  |  <?php edit_post_link() ?></div>
                              </article>
				
			<?php endwhile; ?>
                </div>
              </section>
            </div>
	    <?php

			the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		else :
                       echo("OH NO");
                       auth_redirect();
                       get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();

