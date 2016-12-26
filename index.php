<?php

// prefill form with post info
require( 'src/tpl/head.php' );
?>
<div>


	<form action="post.php" method="post">
		<div class="alert alert-info">

			infos sur la base de données où se trouvent les tables dotclear: bdd name:
		</div>
		<div class="form-group">
			<input type="text" name="dc_bdd" placeholder="bdd dotclear"
						value="<?php if (isset( $_POST[ 'dc_user' ] )) {
							echo $_POST[ 'dc_user' ];
						} ?>">
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
			</div>

			user:
			<input type="text" name="user" placeholder="user">
			pass:
			<input type="password" name="dc_pass" placeholder="pass">
			<fieldset>
				<h3>Dotclear</h3>
				<div class="row">
							<div class="col-xs-6">
								<label for="blog_name">
									nom du blog à transférer:
								</label>
								<input type="text" name="blog_name" id="blog_name" value="default" placeholder="default">
							</div>
							<div class="col-xs-6">
								préfixe des tables:
								<input type="text" name="dc_prefix" placeholder="dc" value="dc_">
							</div>
				</div>

			</fieldset>
			<hr>
			<fieldset>
				<h3>Wordpress</h3>

				infos sur la base de données où se trouvent les tables wordpress: bdd name:
				<input type="text" name="wp_bdd" placeholder="bdd wordpress"
							value="<?php if (isset( $_POST[ 'wp_bdd' ] )) {
								echo $_POST[ 'wp_bdd' ];
							} ?>">
				préfixe des tables:
				<input type="text" name="wp_prefix" placeholder="wp_"
							value="<?php if (isset( $_POST[ 'wp_prefix' ] )) {
								echo $_POST[ 'wp_prefix' ];
							} else {
								echo "wp_";
							} ?>">

			</fieldset>

		</div>

		<input type="submit" class="btn btn-primary" value="test connec">

	</form>
</div>
<?php
require( 'src/tpl/foot.php' );
?>
