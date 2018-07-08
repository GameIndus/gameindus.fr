<!-- <div class="about-container helpus-container">
	<h1 class="title" style="padding-top:20px">GameIndus</h1>
	<h3 class="subtitle" style="margin-top:-15px;font-size:1.2em">Aidez-nous à financer les serveurs</h3>

	<div class="row-container" style="width:960px;margin-top:50px">	
		<div class="progressbar-premium">
			<div class="progressbar" data-state="<?= $d->donateState; ?>" style="background-position:-<?= $d->donateState * 183 ?>px 0px"></div>
			<div class="star-lightning"></div>

			<div class="tooltip" style="bottom:<?= ($d->donateState == 10) ? (($d->donateState * 32) - 32) : (($d->donateState * 32) - 16); ?>px">
				<div class="text" style="font-size:0.9em">Avant le 10/04: <b><?= $d->donations; ?></b> / 5€.</div>
			</div>
		</div>

		<div class="renew-content" style="margin-top:80px">
			<h3 class="subtitle" style="text-align:right">Aidez une plateforme en danger !</h3>
			<br>
			<p>
				Nous avons besoin de votre aide. En effet, payer les serveurs de GameIndus a un coût.<br>
				Sans votre aide, nous ne pouvons pas assurer la qualité de nos services.<br>
				C'est grâce à vos dons que la plateforme peut exister.<br>
				En nous aidant, nous vous promettons un service toujours disponible et de qualité.<br>

				<br><br>
				


				<a href="https://paypal.me/GameIndus" target="_blank" title="Aidez-nous dès maintenant" style="color:#FFF">
					<div class="btn" style="width:263px;float:right"><i class="fa fa-star"></i> Aidez-nous dès maintenant</div>
				</a>

				<div class="clear"></div>
<!-- 				<br>
				<p style="float:right"><strong><i class="fa fa-warning"></i> Avant le 10/04.</strong></p> -->
</p>
</div>


<div class="clear"></div>
</div>

</div>

<script type="text/javascript">
    window.addEventListener("load", function () {
        var starLight = document.querySelector(".progressbar-premium .star-lightning");
        var progressBar = document.querySelector(".progressbar-premium .progressbar");
        var tooltip = document.querySelector(".progressbar-premium .tooltip");

        var currentAnim = 0;
        var currentState = 0;
        var barState = parseInt(progressBar.dataset.state);

        function animLightning() {
            starLight.style.backgroundPosition = "-" + (currentAnim * 183) + "px -455px";

            currentAnim++;
            if (currentAnim > 7) currentAnim = 1;
            setTimeout(animLightning, 300);
        }

        function loadBar() {
            progressBar.style.backgroundPosition = "-" + (currentState * 183) + "px 0px";
            tooltip.style.bottom = ((currentState * 32) - 16) + "px";

            if (currentState == 10) tooltip.style.bottom = ((currentState * 32) - 32) + "px";

            if (currentState >= barState) {
                animLightning();
                return false;
            }

            currentState++;
            setTimeout(loadBar, 50);
        }

        loadBar();
    });
</script> -->