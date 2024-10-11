<?php $siteUrl = site_url(); ?>
<?php $footerMenu = wp_get_nav_menu_items("footer_menu"); ?>


<footer class="py-5">
	<div class="container">
		<div class="row gx-5">

		    <div class="col-md-4 mt-5">
				<h5 class="footer__column_title">Sobre a Bantal</h5>
				
				<div class="footer__items_group">
					<p>A Plataforma B-Talent Funciona como um canal direto entre candidatos e empresas, aumentando significativamente as chances do candidato enxergar as oportunidades, bem como de as empresas encontrarem o perfil ideal para o processo de seleção.</p>
				</div>
			</div>

			<div class="col-md-4 mt-5">
				<h5 class="footer__column_title">Mapa do site</h5>
				
				<div class="footer__items_group">
					<?php foreach($footerMenu as $menuItem){ ?>
						<a href=<?php echo $menuItem->url; ?>>
							<?php echo $menuItem->title; ?>
						</a>
				<?php } ?>
				</div>
			</div>
			


            <div class="col-md-4 mt-5">
				<h5 class="footer__column_title">Encontre-nos</h5>
				
				<div class="footer__items_group">
					<a href="mailto:contato@aristeupires.com.br">contato@bantal.com.br</a>
					<a href="tel:+550543278 1762">(54) 3278 1762</a>
					<a href="https://maps.app.goo.gl/FfT4rwDhLLPLTPhR8" target="_blank">Rua Perimetral, 394 Distrito Industrial.<br/> Canela/RS</a>

					
					<div class="footer__social_links">
						<a href="https://www.facebook.com/aristeupiresdesign" target="_blank"><i class="fa-brands fa-facebook"></i></a>
						<a href="https://www.instagram.com/aristeupiresdesign/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
						<a href="https://www.linkedin.com/in/aristeu-pires-a9888535/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>