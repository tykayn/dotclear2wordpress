<?php

// prefill form with post info
require( 'src/tpl/head.php' );
?>
<div>


	<form action="post.php" method="post">
		<div class="form-group">

			<div class="well">
				<ul>
					<li>
						Vous devez disposer des tables de Dotclear et de Wordpress sur le même serveur. Elles peuvent être sur deux
						bases de données mysql différentes si vous voulez.
					</li>
					<li>
						l'utilisateur doit avoir accès aux deux BDD.
					</li>
				</ul>
				<fieldset>
					<div class="row-fluid">
						<div class="col-xs-6">
							user:
							<input type="text" name="user" placeholder="user">
						</div>
						<div class="col-xs-6"> pass:
							<input type="password" name="dc_pass" placeholder="pass">
						</div>
					</div>


				</fieldset>
			</div>
			<div class="row-fluid">
				<div class="col-md-5 col-xs-12">
					<fieldset>
						<h3>Dotclear</h3>
						<div class="row-fluid">
							bdd name:
							<input type="text" name="dc_bdd" placeholder="bdd dotclear"
										value="<?php if (isset($_POST[ 'dc_user' ])) {
                        echo $_POST[ 'dc_user' ];
                    } ?>">
							<label for="blog_name">
								nom du blog à transférer:
							</label>
							<input type="text" name="blog_name" id="blog_name" value="default" placeholder="default">
							<br>

							préfixe des tables:
							<input type="text" name="dc_prefix" placeholder="dc" value="dc_">
						</div>

					</fieldset>
				</div>
				<div class="col-md-2 col-xs-12 middle">
					<i class="fa fa-arrow-right fa-2x"></i>
				</div>
				<div class="col-md-5 col-xs-12">
					<fieldset>
						<h3>Wordpress</h3>

						infos sur la base de données où se trouvent les tables wordpress: <br>
						bdd name:<br>
						<input type="text" name="wp_bdd" placeholder="bdd wordpress"
									value="<?php if (isset($_POST[ 'wp_bdd' ])) {
                      echo $_POST[ 'wp_bdd' ];
                  } ?>">
						<br> préfixe des tables:
						<input type="text" name="wp_prefix" placeholder="wp_"
									value="<?php if (isset($_POST[ 'wp_prefix' ])) {
                      echo $_POST[ 'wp_prefix' ];
                  } else {
                      echo "wp_";
                  } ?>">

					</fieldset>
				</div>
			</div>
			<div class="row-fluid">
				<div class="col-xs-12">
					<div class="padded">

						<input type="submit" class="btn btn-primary btn-block btn-lg" value="test connec">
					</div>

				</div>
			</div>
		</div>

	</form>
</div>
<?php
require( 'src/tpl/foot.php' );
?>
