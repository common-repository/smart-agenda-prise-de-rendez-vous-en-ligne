<?php
/*
Plugin Name: SmartAgenda - Prise de rendez-vous en ligne
Plugin URI:  https://go.smartagenda.fr/activation2.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress
Description: Agenda et Prise de rendez-vous par internet. Insérez facilement la prise de rendez-vous sur votre site.
Version:     4.6
Author:      SmartAgenda
Author URI:  https://go.smartagenda.fr
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: smartagenda
Domain Path: /languages
*/

// Creating admin settings page
/**
 * custom option and settings
 */

$codeBoutonFlottant = "";
$popupBoutonFlottant = "";
 
function smartagenda_admin_page_init() {
    // register a new setting for "SmartAgenda" page
    register_setting( 'smartagenda', 'smartagenda_options' );

    // register a new section in the "SmartAgenda" page
    add_settings_section(
        'smartagenda_section_devloppers',
        __( 'Configuration du plugin', 'smartagenda' ),
        'smartagenda_section_devloppers_cb',
        'smartagenda'
    );

    
}

/**
 * register our smartagenda_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'smartagenda_admin_page_init' );


// Add stylesheet & javascript
function smartagenda_enqueue_style() {   
    wp_enqueue_style( 'smartagenda_style', plugins_url( '/css/smart-agenda.css', __FILE__ ) );
    wp_enqueue_style( 'wp-color-picker' );
}
add_action('admin_print_styles', 'smartagenda_enqueue_style');

function smartagenda_widget_enqueue_script()
{   
   wp_enqueue_script( 'wp-color-picker' );
}
add_action('admin_enqueue_scripts', 'smartagenda_widget_enqueue_script');

function modalSmartAgenda_enqueue_style() {   
    wp_enqueue_style( 'smartagenda_style', plugins_url( '/css/modalSmartAgenda.css', __FILE__ ) );
    wp_enqueue_style( 'wp-color-picker' );
}

add_action( 'wp_enqueue_scripts', 'modalSmartAgenda_enqueue_style' );

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function smartagenda_section_devloppers_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"> <?php esc_html_e("Gérez vos rendez-vous en ligne avec notre plugin WordPress. Intégrez la prise de rendez-vous directement sur votre site." ); ?> </p>

    <?php
}

/**
 * top level menu
 */
function smartagenda_options_page() {
    // add top level menu page
    $a = add_menu_page(
        'SmartAgenda – Prise de rendez-vous en ligne',
        'SmartAgenda',
        'manage_options',
        'smartagenda',
        'smartagenda_options_page_html'
    );
}


/**
 * register our smartagenda_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'smartagenda_options_page' );

/**
 * top level menu:
 * callback functions
 */
function smartagenda_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'smartagenda_messages', 'smartagenda_message', __( 'Modifications enregistrées', 'smartagenda' ), 'updated' );
    }

    settings_errors( 'smartagenda_messages' );
    ?>
    
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
   
    <?php
        settings_fields( 'smartagenda' );
      	do_settings_sections( 'smartagenda' );
    ?>
    
    <script type="text/javascript">
	jQuery(document).ready(function(){
	
	    jQuery('.colorPicker').wpColorPicker();
		
		var btncopy = document.querySelector('#btn-copy');
		if(btncopy) {
			btncopy.addEventListener('click', docopy);
		}
	
		var btncopy = document.querySelector('#btn-copy-2');
		if(btncopy) {
			btncopy.addEventListener('click', docopy);
		}

		function docopy() {

			// Cible de l'élément qui doit être copié
			var target = this.dataset.target;
			var fromElement = document.querySelector(target);
			if(!fromElement) return;

			// Sélection des caractères concernés
			var range = document.createRange();
			var selection = window.getSelection();
			range.selectNode(fromElement);
			selection.removeAllRanges();
			selection.addRange(range);

			try {
				// Exécution de la commande de copie
				var result = document.execCommand('copy');
				if (result) {
					// La copie a réussi
					alert('Copié');
				}
			}
			catch(err) {
				// Une erreur est surevnue lors de la tentative de copie
				alert(err);
			}

			// Fin de l'opération
			selection = window.getSelection();
			if (typeof selection.removeRange === 'function') {
				selection.removeRange(range);
			} else if (typeof selection.removeAllRanges === 'function') {
				selection.removeAllRanges();
			}
		}

	});
	</script>
    
    <div class="wrap">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					
					<div class="smartagenda-wrap">
						<img class="illustration" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/plugin-wordpress.png" alt="Plugin Wordpress SmartAgenda" style="max-width: 220px;" />
						<h1>
							<img style="float: left;" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/logo-smartagenda.svg" width="240" alt="SmartAgenda" />
							<a target="_blank" style="margin-left: 30px;font-size: 12px;line-height: 21px;padding: 8px 16px;background: #3ecf8e;text-transform: uppercase;letter-spacing: 2px;font-weight: 500;color: #fff;display: inline-block;border-radius: 4px; text-decoration: none; " href="https://go.smartagenda.fr/activation2.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Essayez gratuitement</a>
						</h1>
		
						<br>
		
						<p>
							<?php esc_html_e( "Le plugin fonctionne grâce à l'application de réservation en ligne SmartAgenda. Il nécessite d’avoir un compte actif pour utiliser les services.") ?><br>
							<strong><?php esc_html_e( "Vous n'avez pas encore de compte SmartAgenda ?" ); ?></strong> <a href="https://go.smartagenda.fr/activation2.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Je créé mon agenda.</a>
						</p>
					</div>
					
					<div class="smartagenda-wrap">
						<?php 
							
							if (!empty ($_POST['update'])) {
								
								// Widget
								
								$name_agenda = !empty ($_POST['name_agenda']) ? sanitize_text_field($_POST['name_agenda']) : '';
								update_option('name_agenda', $name_agenda);
								
								if (isset($_POST['contenu'])){
									$contenu = "true";
									$contenu_checked = "checked = 'checked'";
									update_option('contenu', $contenu);
									update_option('contenu_checked', $contenu_checked);
								}
								else{
									$contenu = "false";
									$contenu_checked = "";
									update_option('contenu', $contenu);
									update_option('contenu_checked', $contenu_checked);
								}
								
								if (isset($_POST['entete'])){
									$entete = "true";
									$entete_checked = "checked = 'checked'";
									update_option('entete', $entete);
									update_option('entete_checked', $entete_checked);
								}
								else{
									$entete = "false";
									$entete_checked = "";
									update_option('entete', $entete);
									update_option('entete_checked', $entete_checked);
								}
								
								if (isset($_POST['footer'])){
									$footer = "true";
									$footer_checked = "checked = 'checked'";
									update_option('footer', $footer);
									update_option('footer_checked', $footer_checked);
								}
								else{
									$footer = "false";
									$footer_checked = "";
									update_option('footer', $footer);
									update_option('footer_checked', $footer_checked);
								}
								
								if (isset($_POST['bandeau'])){
									$bandeau = "true";
									$bandeau_checked = "checked = 'checked'";
									update_option('bandeau', $bandeau);
									update_option('bandeau_checked', $bandeau_checked);
								}
								else{
									$bandeau = "false";
									$bandeau_checked = "";
									update_option('bandeau', $bandeau);
									update_option('bandeau_checked', $bandeau_checked);
								}
								
								if (isset($_POST['infosimportantes'])){
									$infosimportantes = "true";
									$infosimportantes_checked = "checked = 'checked'";
									update_option('infosimportantes', $infosimportantes);
									update_option('infosimportantes_checked', $infosimportantes_checked);
								}
								else{
									$infosimportantes = "false";
									$infosimportantes_checked = "";
									update_option('infosimportantes', $infosimportantes);
									update_option('infosimportantes_checked', $infosimportantes_checked);
								}
								
								if (isset($_POST['logo'])){
									$logo = "true";
									$logo_checked = "checked = 'checked'";
									update_option('logo', $logo);
									update_option('logo_checked', $logo_checked);
								}
								else{
									$logo = "false";
									$logo_checked = "";
									update_option('logo', $logo);
									update_option('logo_checked', $logo_checked);
								}
								
								if (isset($_POST['photo'])){
									$photo = "true";
									$photo_checked = "checked = 'checked'";
									update_option('photo', $photo);
									update_option('photo_checked', $photo_checked);
								}
								else{
									$photo = "false";
									$photo_checked = "";
									update_option('photo', $photo);
									update_option('photo_checked', $photo_checked);
								}
								
								if (isset($_POST['affrdv'])){
									$affrdv = "true";
									$affrdv_checked = "checked = 'checked'";
									update_option('affrdv', $affrdv);
									update_option('affrdv_checked', $affrdv_checked);
								}
								else{
									$affrdv = "false";
									$affrdv_checked = "";
									update_option('affrdv', $affrdv);
									update_option('affrdv_checked', $affrdv_checked);
								}
								
								// Bouton flottant
								
								$activerBouton = "true";
								$activerBouton_checked = "checked = 'checked'";
								
								$activerPopup = "true";
								$activerPopup_checked = "checked = 'checked'";
								
								
								if (isset($_POST['activerBouton'])){
									$activerBouton = "true";
									$activerBouton_checked = "checked = 'checked'";
									update_option('activerBouton', $activerBouton);
									update_option('activerBouton_checked', $activerBouton_checked);
								}
								else{
									$activerBouton = "false";
									$activerBouton_checked = "";
									update_option('activerBouton', $activerBouton);
									update_option('activerBouton_checked', $activerBouton_checked);
								}
																
								$url_bouton = !empty ($_POST['url_bouton']) ? sanitize_text_field($_POST['url_bouton']) : '';
								update_option('url_bouton', $url_bouton);
								
								$texte_bouton = !empty ($_POST['texte_bouton']) ? sanitize_text_field($_POST['texte_bouton']) : '';
								update_option('texte_bouton', $texte_bouton);
								
								if (isset($_POST['activerPopup'])){
									$activerPopup = "true";
									$activerPopup_checked = "checked = 'checked'";
									update_option('activerPopup', $activerPopup);
									update_option('activerPopup_checked', $activerPopup_checked);
								}
								else{
									$activerPopup = "false";
									$activerPopup_checked = "";
									update_option('activerPopup', $activerPopup);
									update_option('activerPopup_checked', $activerPopup_checked);
								}
								
								$couleur_bouton = !empty ($_POST['couleur_bouton']) ? sanitize_text_field($_POST['couleur_bouton']) : '';
								update_option('couleur_bouton', $couleur_bouton);
								
								$couleur_texte_bouton = !empty ($_POST['couleur_texte_bouton']) ? sanitize_text_field($_POST['couleur_texte_bouton']) : '';
								update_option('couleur_texte_bouton', $couleur_texte_bouton);
								
								$position_bouton = "bottomRight";
								$position_bouton_selected = "selected = 'selected'";
								
								if (isset($_POST['position_bouton'])){
									$position_bouton = "bottomRight";
									$position_bouton_selected = "selected = 'selected'";
									update_option('position_bouton', $position_bouton);
									update_option('position_bouton_selected', $position_bouton_selected);
								}
								if (isset($_POST['position_bouton']) && ($_POST['position_bouton']=="bottomLeft")){
									$position_bouton = "bottomLeft";
									$position_bouton_selected = "selected = 'selected'";
									update_option('position_bouton', $position_bouton);
									update_option('position_bouton_selected', $position_bouton_selected);
								}
								if (isset($_POST['position_bouton']) && ($_POST['position_bouton']=="topRight")){
									$position_bouton = "topRight";
									$position_bouton_selected = "selected = 'selected'";
									update_option('position_bouton', $position_bouton);
									update_option('position_bouton_selected', $position_bouton_selected);
								}
								if (isset($_POST['position_bouton']) && ($_POST['position_bouton']=="topLeft")){
									$position_bouton = "topLeft";
									$position_bouton_selected = "selected = 'selected'";
									update_option('position_bouton', $position_bouton);
									update_option('position_bouton_selected', $position_bouton_selected);
								}
								
								$ciblePage = "nouvelleFenetre";
								$ciblePage_selected = "selected = 'selected'";
								
								if (isset($_POST['ciblePage'])){
									$ciblePage = "nouvelleFenetre";
									$ciblePage_selected = "selected = 'selected'";
									update_option('ciblePage', $ciblePage);
									update_option('ciblePage_selected', $ciblePage_selected);
								}
								if (isset($_POST['ciblePage']) && ($_POST['ciblePage']=="fenetreActive")){
									$ciblePage = "fenetreActive";
									$ciblePage_selected = "selected = 'selected'";
									update_option('ciblePage', $ciblePage);
									update_option('ciblePage_selected', $ciblePage_selected);
								}
								
								/*********/

								$updated = 1;
								
							} else {
								// Widget
								$name_agenda = get_option('name_agenda');
								$contenu = get_option('contenu');
								$contenu_checked = get_option('contenu_checked');
								$entete = get_option('entete');
								$entete_checked = get_option('entete_checked');
								$footer = get_option('footer');
								$footer_checked = get_option('footer_checked');
								$bandeau = get_option('bandeau');
								$bandeau_checked = get_option('bandeau_checked');
								$infosimportantes = get_option('infosimportantes');
								$infosimportantes_checked = get_option('infosimportantes_checked');
								$logo = get_option('logo');
								$logo_checked = get_option('logo_checked');
								$photo = get_option('photo');
								$photo_checked = get_option('photo_checked');
								$affrdv = get_option('affrdv');
								$affrdv_checked = get_option('affrdv_checked');
								
								// Bouton flottant
								$activerBouton = get_option('activerBouton');
								$activerBouton_checked = get_option('activerBouton_checked');
								$url_bouton = get_option('url_bouton');
								$activerPopup = get_option('activerPopup');
								$activerPopup_checked = get_option('activerPopup_checked');
								$couleur_bouton = get_option('couleur_bouton');
								$couleur_texte_bouton = get_option('couleur_texte_bouton');
								$texte_bouton = get_option('texte_bouton');
								$position_bouton = get_option('position_bouton');
								$position_bouton_selected = get_option('position_bouton_selected');
								$ciblePage = get_option('ciblePage');
								$ciblePage_selected = get_option('ciblePage_selected');
							} 
						?>
		
							<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
								<input type="hidden" value="1" name="update">
								
								<div class="parametres-agenda focus">
									<ul class="nomAgenda">
										<li><h2 class="nom-agenda">Nom de votre agenda :</h2> <input class="inputText" type="text" style="width: 370px;" value="<?php echo $name_agenda; ?>" name="name_agenda"><br></li>
									</ul>
								
									<div class="tipsSmartAgenda">
										<p><strong>Comment trouver le nom de mon agenda ?</strong><br/>
										Si l'URL de votre site SmartAgenda est https://www.smartagenda.fr/pro/agenda-demo, alors le nom de votre agenda est :</span> <strong>agenda-demo</strong></p>
									</div>
								</div>
								
								<br/>
								
								<?php if ($name_agenda!="") { ?>
										<div class="accordionSmartAgenda active">
										 	<h2>Bouton flottant de prise de rendez-vous</h2>
										</div>
										<div class="panelSmartAgenda" style="display:block; padding: 30px;">
										
											<p style="margin-top:0;"><b>Avec ce bouton, proposez l'accès à la prise de rendez-vous en ligne partout sur votre site Internet en 1 clic !</b></p>
											<br/>
											<div class="container-illustration-parametres">
												<img class="illustration-parametres" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/parametres-bouton-smartagenda.png" alt="Paramètrage visuel du bouton flottant" />
											</div>
															
											<div class="container-parametres">
										
												<div class="container content-switch" style="margin: 15px 0;">
													<label class="switch" for="activerBouton">
														<input type="checkbox" id="activerBouton" name="activerBouton" value="<?php echo $activerBouton; ?>" <?php if($activerBouton == 'true'){echo $activerBouton_checked;} ?> />
														<div class="sliderSmart sliderSmart-activerBouton round"></div>
													</label>
													<div class="label-switch">Activer le bouton flottant sur mon site <span class="recommended">Recommandé</span></div>
												</div>
											
												<div class="container">
													<label class="labelSmart">Couleur du bouton :</label>
													<input type="text" class="colorPicker" id="couleur_bouton" name="couleur_bouton" value="<?php if ($couleur_bouton=="") {?>#007eff <?php } else { echo $couleur_bouton; }?>" />
												</div>
												
												<div class="container">
													<label class="labelSmart">Couleur du texte du bouton :</label>
													<input type="text" class="colorPicker" id="couleur_texte_bouton" name="couleur_texte_bouton" value="<?php if ($couleur_texte_bouton=="") {?>#ffffff <?php } else { echo $couleur_texte_bouton; }?>" />
												</div>
												
												<div class="container">
														<label class="labelSmart">Texte à afficher :</label>
														<input class="inputText" type="text" style="width: 300px;" id="texte_bouton" name="texte_bouton" value="<?php if ($texte_bouton=="") {?>Prendre rendez-vous en ligne <?php } else { echo $texte_bouton; }?>">
													</div>
												
												<div class="container content-switch" style="margin: 15px 0;">
													<label class="switch" for="activerPopup">
														<input type="checkbox" id="activerPopup" name="activerPopup" value="<?php echo $activerPopup; ?>" <?php if($activerPopup == 'true'){echo $activerPopup_checked;} ?> />
														<div class="sliderSmart sliderSmart-activerPopup round"></div>
													</label>
													<div class="label-switch">Afficher la prise de rendez-vous directement dans une popup <span class="recommended">Recommandé</span></div>
												</div>
												
												<br/>
												
												<div class="accordionSmartAgendaLink">
													<span>+ Personnalisation avancée</span>
												</div>
																														
												<div class="panelSmartAgendaLink" style="display:none;">
													<div class="container">
														<label class="labelSmart">URL de votre page de prise de rendez-vous :</label>
														<input class="inputText" type="text" style="width: 90%;" id="url_bouton" name="url_bouton" value="<?php if ($url_bouton=="") {?>https://www.smartagenda.fr/pro/<?php echo $name_agenda; ?>/rendez-vous?affrdv <?php } else { echo $url_bouton; }?>">
													</div>
													
													<div class="container">
														<label class="labelSmart">Position du bouton :</label>
														<select id="position_bouton" name="position_bouton">
															<option value="bottomRight" <?php if($position_bouton == 'bottomRight'){echo $position_bouton_selected;} ?>>En bas à droite (Recommandé)</option>
															<option value="bottomLeft" <?php if($position_bouton == 'bottomLeft'){echo $position_bouton_selected;} ?>>En bas à gauche</option>
															<option value="topRight" <?php if($position_bouton == 'topRight'){echo $position_bouton_selected;} ?>>En haut à droite</option>
															<option value="topLeft" <?php if($position_bouton == 'topLeft'){echo $position_bouton_selected;} ?>>En haut à gauche</option>
														</select>
													</div>
													
													<div class="container">
														<label class="labelSmart">Ouverture de la page :</label>
														<select id="ciblePage" name="ciblePage">
															<option value="nouvelleFenetre" <?php if($ciblePage == 'nouvelleFenetre'){echo $ciblePage_selected;} ?>>Nouvelle fenêtre</option>
															<option value="fenetreActive" <?php if($ciblePage == 'fenetreActive'){echo $ciblePage_selected;} ?>>Fenêtre active</option>
														</select>
													</div>
												</div>
																																	
											</div>
								
											<div style="clear:both;"></div>
											
										</div>
																		
									<br/>
									
										<div class="accordionSmartAgenda">
											<h2>Widget de prise de rendez-vous en ligne</h2>
										</div>
										<div class="panelSmartAgenda" style="display:none; padding: 30px;">
										    <p style="margin-top:0;"><b>Insérez le widget SmartAgenda sur la page de votre choix pour proposer la prise de rendez-vous en ligne directement sur votre site Internet.</b></p>
											<br/>
											<div class="container-illustration-parametres">
												<img class="illustration-parametres" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/parametres-widget-smartagenda.jpg" alt="Paramètrage visuel du widget" />
											</div>
															
											<div class="container-parametres">
												<div class="container content-switch">
													<label class="switch" for="bandeau">
														<input type="checkbox" id="bandeau" name="bandeau" value="<?php echo $bandeau; ?>" <?php echo $bandeau_checked; ?> />
														<div class="sliderSmart sliderSmart-bandeau round"></div>
													</label>
													<div class="label-switch"><span>1</span> Afficher l'en-tete</div>
												</div>
										
												<div class="container content-switch">
													<label class="switch" for="logo">
														<input type="checkbox" id="logo" name="logo" value="<?php echo $logo; ?>" <?php echo $logo_checked; ?> />
														<div class="sliderSmart sliderSmart-logo round"></div>
													</label>
													<div class="label-switch"><span>2</span> Afficher le logo</div>
												</div>
												
												<div class="container content-switch">
													<label class="switch" for="entete">
														<input type="checkbox" id="entete" name="entete" value="<?php echo $entete; ?>" <?php echo $entete_checked; ?> />
														<div class="sliderSmart sliderSmart-entete round"></div>
													</label>
													<div class="label-switch"><span>3</span> Afficher les informations de votre société</div>
												</div>
										
												<div class="container content-switch">
													<label class="switch" for="infosimportantes">
														<input type="checkbox" id="infosimportantes" name="infosimportantes" value="<?php echo $infosimportantes; ?>" <?php echo $infosimportantes_checked; ?> />
														<div class="sliderSmart sliderSmart-infosimportantes round"></div>
													</label>
													<div class="label-switch"><span>4</span> Afficher les informations importantes</div>
												</div>
												
												<div class="container content-switch">
													<label class="switch" for="photo">
														<input type="checkbox" id="photo" name="photo" value="<?php echo $photo; ?>" <?php echo $photo_checked; ?> />
														<div class="sliderSmart sliderSmart-photo round"></div>
													</label>
													<div class="label-switch"><span>5</span> Afficher la galerie d'image</div>
												</div>
										
												<div class="container content-switch">
													<label class="switch" for="contenu">
														<input type="checkbox" id="contenu" name="contenu" value="<?php echo $contenu; ?>" <?php echo $contenu_checked; ?> />
														<div class="sliderSmart sliderSmart-contenu round"></div>
													</label>
													<div class="label-switch"><span>6</span> Afficher le contenu</div>
												</div>
								
												<div class="container content-switch">
													<label class="switch" for="affrdv">
														<input type="checkbox" id="affrdv" name="affrdv" value="<?php echo $affrdv; ?>" <?php echo $affrdv_checked; ?> />
														<div class="sliderSmart sliderSmart-affrdv round"></div>
													</label>
													<div class="label-switch"><span>7</span> Afficher la prise de rendez-vous avant le contenu</div>
												</div>
										
												<div class="container content-switch">
													<label class="switch" for="footer">
														<input type="checkbox" id="footer" name="footer" value="<?php echo $footer; ?>" <?php echo $footer_checked; ?> />
														<div class="sliderSmart sliderSmart-footer round"></div>
													</label>
													<div class="label-switch"><span>8</span> Afficher le pied de de page</div>
												</div>
										
												<h3 style="font-size: 18px; color: #3ecf8e;">Code court à copier sur la page de votre choix :</h3>
												<div class="codeBouton">
													<div id="codeShortcode">
														<pre><code>&#91;smartagenda agenda="<?php echo $name_agenda;?>"&#93;</code></pre>
													</div>
													<button class="btn btn-default" type="button" id="btn-copy-2" data-target="#codeShortcode">Copier le code court</button>
												</div>
										
											</div>
											<div style="clear:both;"></div>
											
											<br/><br/>
											
											<div id="infos-preview-agenda" class="smartagenda-wrap" style="float:left; width: 36%;">
						<h2 class="nom-agenda padding">Intégrez la prise de rendez-vous directement sur votre site : </h2>
						<ul>
							<li>1. Créez votre compte sur SmartAgenda</li>
							<li>2. Saisissez le nom de votre agenda</li>
							<li>3. Ajouter <code style="color:red;">[smartagenda agenda="<?php if($name_agenda!=""){ echo $name_agenda; } else{ echo "agenda-demo"; } ?>"]</code> dans une page de votre choix</li>
							<li>4. Admirez le résultat !</li>
						</ul>
						
						<br/>
						
						<h4>Paramètres additionnels d'affichage :</h4>
						<ul class="params-add">
							<li><code>utilisateur=""</code><br/>
							Saisissez l'id de l'utilisateur que vous souhaitez afficher directement lors de la prise de rendez-vous.
							Ce paramètre permet de prendre rendez-vous directement avec l'utilisateur concerné.</li>
							<li><code>categ=""</code><br/>
							Saisissez l'id de la catégorie de prestation que vous souhaitez afficher directement lors de la prise de rendez-vous.
							Ce paramètre permet de prendre rendez-vous directement pour une catégorie de prestations souhaitée.</li>
							<li><code>presta=""</code><br/>
							Saisissez l'id de la prestation que vous souhaitez afficher directement lors de la prise de rendez-vous.
							Ce paramètre permet de prendre rendez-vous directement pour une prestation souhaitée.</li>
							<li><code>groupement=""</code><br/>
							Saisissez l'id du groupement d'agenda que vous souhaitez afficher directement lors de la prise de rendez-vous.
							Ce paramètre permet de prendre rendez-vous directement avec un groupement d'agenda souhaité.</li>
							<li><u>Exemple de shortcode possible</u> :<br/><br/>
							<code>[smartagenda agenda="<?php if($name_agenda!=""){ echo $name_agenda; } else{ echo "agenda-demo"; } ?>" utilisateur="1"]</code><br/>
							<code>[smartagenda agenda="<?php if($name_agenda!=""){ echo $name_agenda; } else{ echo "agenda-demo"; } ?>" categ="2"]</code><br/>
							<code>[smartagenda agenda="<?php if($name_agenda!=""){ echo $name_agenda; } else{ echo "agenda-demo"; } ?>" presta="8"]</code><br/>
							<code>[smartagenda agenda="<?php if($name_agenda!=""){ echo $name_agenda; } else{ echo "agenda-demo"; } ?>" utilisateur="2" presta="4"]</code><br/>
							<code>[smartagenda agenda="<?php if($name_agenda!=""){ echo $name_agenda; } else{ echo "agenda-demo"; } ?>" groupement="2"]</code>
							</li>
						</ul>
					</div>
		
					<div id="preview-agenda" class="smartagenda-wrap" style="float:right; width: 58%;">
						<h2 class="nom-agenda padding">Visualisation de votre widget de prise de rendez-vous : </h2>
			
						<script src='https://www.smartagenda.fr/pro/<?php echo $name_agenda; ?>/smartwidget.js' type='text/javascript'></script>
						<script>
							window.onload = function(){
								var options = {
									contenu : <?php echo $contenu; ?>,
									entete : <?php echo $entete; ?>,		
									footer : <?php echo $footer; ?>,		
									bandeau : <?php echo $bandeau; ?>,		
									infosimportantes : <?php echo $infosimportantes; ?>,
									logo : <?php echo $logo; ?>,
									photo : <?php echo $photo; ?>,	
									affrdv : <?php echo $affrdv; ?>
								};
								var smartwidget = new SMARTAGENDAwidget(
									'smart-container',
									'https://www.smartagenda.fr/pro/<?php echo $name_agenda; ?>',
									options);
								smartwidget.render();
							};
						</script>
						<div id="smart-container"></div>
					</div>
					
					<div style="clear:both;"></div>
					
					
										</div>
									
									<?php } ?>
									
									
									<script>
									var acc = document.getElementsByClassName("accordionSmartAgenda");
									var i;

									for (i = 0; i < acc.length; i++) {
									  acc[i].addEventListener("click", function() {
										this.classList.toggle("active");
										var panel = this.nextElementSibling;
										if (panel.style.display === "block") {
										  panel.style.display = "none";
										} else {
										  panel.style.display = "block";
										}
									  });
									}
									
									var acc2 = document.getElementsByClassName("accordionSmartAgendaLink");
									var i2;

									for (i2 = 0; i2 < acc2.length; i2++) {
									  acc2[i2].addEventListener("click", function() {
										this.classList.toggle("active");
										var panel2 = this.nextElementSibling;
										if (panel2.style.display === "block") {
										  panel2.style.display = "none";
										} else {
										  panel2.style.display = "block";
										}
									  });
									}
									</script>
									
									

								
								
								<br/><br/>
											
								<p style="text-align:center;">				
								<?php if ($name_agenda!="") { ?>
									<input style="border:none;font-size: 16px;line-height: 21px;padding: 16px 28px;background: #3ecf8e;text-transform: uppercase;letter-spacing: 2px;font-weight: 500;color: #fff;border-radius: 4px; text-decoration: none;" type="submit" value="Enregistrer les modifications">
								<?php } else { ?>
									<input style="border:none;font-size: 16px;line-height: 21px;padding: 16px 28px;background: #3ecf8e;text-transform: uppercase;letter-spacing: 2px;font-weight: 500;color: #fff;border-radius: 4px; text-decoration: none;" type="submit" value="Enregistrer">
								<?php } ?>
								</p>
								
							</form>
							<br><br>

							<?php if (!empty($updated)): ?>
								<p style="color:#fff; background: #3ecf8e; padding: 15px; font-weight: bold;"><?php esc_html_e( "Modification enregistrée. Vous pouvez commencer à utiliser votre agenda." ); ?></p>
							<?php endif; ?>
					</div>
				</div>
				
				<div id="postbox-container-1" class="postbox-container" >
					<?php if ($name_agenda!="") { ?>
						<a target="_blank" style="font-size: 13px;line-height: 21px;padding: 8px 16px;background: #007eff;text-transform: uppercase;letter-spacing: 2px;font-weight: 500;color: #fff;display: inline-block;border-radius: 4px; text-decoration: none; " href="https://www.smartagenda.fr/pro/<?php echo $name_agenda; ?>/agenda">Accéder à mon agenda</a>
						<br/><br/>
					<?php } ?>
					
					<div class="smartagenda-wrap contact-us" style="background: #000f54; color: #fff; border: 1px solid #e5e5e5; margin-bottom: 20px; padding: 20px; margin-right: 20px;"><h3>Besoin d'aide ?</h3>
						<span>04 82 530 770</span><br/><i style="font-size: 12px;">(du lundi au vendredi de 9h à 19h) </i>
					</div>
					
					<div class="smartagenda-wrap" style="background: #fff; border: 1px solid #e5e5e5; margin-bottom: 20px; padding: 20px; margin-right: 20px;">
						<h3>Avantages :</h3>
						<p><strong>Augmentez rapidement le volume de rendez vous pris en ligne.</strong></p>
						<p>Simple et rapide à utiliser, notre plugin WordPress vous permettra de proposer à vos clients une véritable solution de réservation en ligne.</p>
					</div>
					
					<div class="smartagenda-wrap" style="background: #fff; border: 1px solid #e5e5e5; margin-bottom: 20px; padding: 20px; margin-right: 20px;">
						<p><img style="width: 100%; height: auto;" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/synchronisation-google-agenda.png" alt="Synchronisation Google Agenda" /></p>
						<h3>Gagnez du temps !</h3>
						<p><strong>Connectez SmartAgenda et Google Agenda</strong></p>
						<p>Vos rendez-vous se synchronisent automatiquement avec votre calendrier Google Agenda. Synchronisation bi-directionnelle en temps réel.</p>
						<p><a target="_blank" href="https://go.smartagenda.fr/synchronisation-google-agenda-rdv-internet-smart-agenda.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">En savoir plus</a></p>
					</div>
					
					<div class="smartagenda-wrap" style="background: #fff; border: 1px solid #e5e5e5; margin-bottom: 20px; padding: 20px; margin-right: 20px;">
						<h3>Fonctionnalités :</h3>
						<ul>
							<li><a target="_blank" href="https://go.smartagenda.fr/solution-agenda-partage-planifier-activite.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Agenda partagé</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/solution-prise-rdv-en-ligne-smart-agenda.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Solution de prise de rendez-vous en ligne</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/rappel-de-rendez-vous-par-mail-sms.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Rappel par SMS et par Mail</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/paiement-en-ligne-rdv-internet.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Paiement en ligne</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/synchronisation-google-agenda-rdv-internet-smart-agenda.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Synchronisation avec Google Agenda</a></li>
						</ul>
						<p>De très nombreuses fonctionnalités sont disponibles pour s’adapter précisément à votre activité :</p>
						<ul>
							<li><a target="_blank" href="https://go.smartagenda.fr/rendez-vous-internet-collectif-groupe.html.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Rendez-vous collectifs</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/motifs-rendez-vous-internet-personnalisables.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Motifs de rendez-vous</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/fiches-clients-personnalisees-pour-rdv-en-ligne.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Fichiers clients</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/import-fichier-clients-solution-prise-de-rdv-en-ligne.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Import de fichiers</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/rendez-vous-internet-gerer-droits-utilisateurs.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Gestion d’équipe</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/rendez-vous-en-ligne-plusieurs-lieux.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">Gestion des lieux</a></li>
							<li><a target="_blank" href="https://go.smartagenda.fr/rdv-internet-api.html?source=wordpress&utm_source=plugin-wordpress&utm_campaign=plugin-Wordpress">API, WebServices et Webhooks</a></li>
						</ul>
						<p>Et bien plus encore...</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
        
    <?php
}

/* Create shortcode */

function smartagenda_shortcode($atts, $content = null, $tag = ''){
    
	$contenu = get_option('contenu');
	$entete = get_option('entete');
	$footer = get_option('footer');
	$bandeau = get_option('bandeau');
	$infosimportantes = get_option('infosimportantes');
	$logo = get_option('logo');
	$photo = get_option('photo');
    
    // start output
    $o = ''; 

	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
	
	// Construction des options
	$options = "var options = {";	
	$options .= "contenu :".$contenu.",";
	$options .= "entete :".$entete.",";
	$options .= "footer :".$footer.",";
	$options .= "bandeau :".$bandeau.",";
	$options .= "infosimportantes :".$infosimportantes.",";
	$options .= "logo :".$logo.",";
	$options .= "photo :".$photo.",";
				
	// On checke si des paramètres spécifiques sont indiqués dans l'URL
	
	if ((isset($atts['categ']) && $atts['categ'] != "") || (isset($atts['presta']) && $atts['presta'] != "") || (isset($atts['utilisateur']) && $atts['utilisateur'] != "") || (isset($atts['groupement']) && $atts['groupement'] != "") || (isset($atts['langue']) && $atts['langue'] != "") || (isset($atts['utm_c4']) && $atts['utm_c4'] != "") || (isset($atts['utm_c5']) && $atts['utm_c5'] != "") || (isset($atts['utm_c6']) && $atts['utm_c6'] != "") || (isset($atts['utm_c7']) && $atts['utm_c7'] != "") || (isset($atts['utm_c8']) && $atts['utm_c8'] != "") || (isset($atts['utm_c9']) && $atts['utm_c9'] != "") || (isset($atts['tkaction']) && $atts['tkaction'] != ""))
	{
		$options .= "affrdv : true,";
		$options .= 'get : "';
	
		$optionsPossibles = array("categ","presta","utilisateur","groupement","langue","utm_c4","utm_c5","utm_c6","utm_c7","utm_c8","utm_c9","tkaction");
	
		$concat = "";
		foreach($atts as $key=>$value)
		{
			if (in_array($key,$optionsPossibles))
			{
				if ($concat.$key=="utilisateur"){
					$options .= "agenda=".$value;
				}
				else{
					$options .= $concat.$key."=".$value;
				}
				$concat = "&";
			}
		}
		$options .= '",';
	}
	
	else
	{
		$affrdv = get_option('affrdv');
		$options .= "affrdv :".$affrdv;
	}	
	
	$options .= "};";
 
	if (isset($atts['agenda']) && $atts['agenda'] != "")
	{
		$o .= '<script src="https://www.smartagenda.fr/pro/'.$atts['agenda'].'/smartwidget.js" type="text/javascript"></script>
		<script>
			window.onload = function(){
				'.$options.'
				var smartwidget = new SMARTAGENDAwidget(
					"smart-container",		
					"https://www.smartagenda.fr/pro/'.$atts['agenda'].'",
				options);
				smartwidget.render();
			};
		</script>';
	
		// start box
		$o .= '<div>';
		$o .= '<div id="smart-container"></div>';
	  
		// enclosing tags
		if (!is_null($content)) {
			// secure output by executing the_content filter hook on $content
			$o .= apply_filters('the_content', $content);
	 
			// run shortcode parser recursively
			$o .= do_shortcode($content);
		}
	 
		// end box
		$o .= '</div>';
	}
	else
	{
		$o .= '<div>';
		$o .= 'ERREUR : Il manque l\'attribut agenda (par exemple [smartagenda agenda="agenda-demo"])';
		// enclosing tags
		if (!is_null($content)) {
			// secure output by executing the_content filter hook on $content
			$o .= apply_filters('the_content', $content);
	 
			// run shortcode parser recursively
			$o .= do_shortcode($content);
		}
		$o .= '</div>';
	}
    // return output
    return $o;
}
 
// Init shortcode
function smartagenda_shortcodes_init(){
    add_shortcode('smartagenda', 'smartagenda_shortcode');
}
 
add_action('init', 'smartagenda_shortcodes_init');

// Create bouton flottant

function smartagenda_boutonFlottant_init() {

	$activerBouton = get_option('activerBouton');
	$url_bouton = get_option('url_bouton');
	$activerPopup = get_option('activerPopup');
	$couleur_bouton = get_option('couleur_bouton');
	$couleur_texte_bouton = get_option('couleur_texte_bouton');
	$texte_bouton = get_option('texte_bouton');
	$position_bouton = get_option('position_bouton');
	$ciblePage = get_option('ciblePage');
	$name_agenda = get_option('name_agenda');

	
	//On récupère la position du bouton
	if ($position_bouton=='bottomRight') { $codePosition ='bottom:0;right:10px;border-bottom-right-radius:none;border-bottom-left-radius:none;border-top-left-radius:4px;border-top-right-radius:4px;0;'; }
	if ($position_bouton=='bottomLeft') { $codePosition ='bottom:0;left:10px;border-bottom-right-radius:none;border-bottom-left-radius:none;border-top-left-radius:4px;border-top-right-radius:4px;0;'; }
	if ($position_bouton=='topRight') { $codePosition ='top:0;right:10px;border-top-right-radius:none;border-top-left-radius:none;border-bottom-left-radius:4px;border-bottom-right-radius:4px;'; }
	if ($position_bouton=='topLeft') { $codePosition ='top:0;left:10px;border-top-right-radius:none;border-top-left-radius:none;border-bottom-left-radius:4px;border-bottom-right-radius:4px;'; }
	
	//On récupère le type d'ouverture de la page
	if ($ciblePage=='nouvelleFenetre') { $codeCiblePage ='target="_blank"'; }
	
	// On affiche la modal si le paramètre est coché
	
	/* On crée le widget en forçant l'affichage souhaité */
	$widget = '<div id="smart-container"></div>
				<script src="https://www.smartagenda.fr/pro/'.$name_agenda.'/smartwidget.js" type="text/javascript"></script>
				<script>
					window.onload = function(){
					var options = {
					contenu : false,
					entete : false,
					footer : true,
					bandeau : true,
					logo : true,
					photo : false,
					infosimportantes : true,
					affrdv : true
					};
					var smartwidget = new SMARTAGENDAwidget(
					"smart-container",
					"https://www.smartagenda.fr/pro/'.$name_agenda.'/",
					options);
					smartwidget.render();
					};
				</script>';
	
	if ($activerPopup == "true"){
		$codeBoutonFlottant = '<style id="smartagenda-css" scoped>.btnSmartAgenda{display:block;text-align:center;background-color:'.$couleur_bouton.';color:'.$couleur_texte_bouton.';font-size:16px;text-transform: uppercase;text-decoration:none !important;letter-spacing: 1px;overflow:hidden;padding: 6px 18px;position:fixed;'.$codePosition.';z-index:100000000000;line-height:30px;}.btnSmartAgenda:hover{color:'.$couleur_texte_bouton.' !important; padding: 6px 18px 11px 18px;}@media (max-width: 767px) {.btnSmartAgenda{width: 94%;right:3%;font-size: 14px; top: auto; bottom:0; border-bottom-right-radius:0;border-bottom-left-radius:0;border-top-left-radius:4px;border-top-right-radius:4px;}}</style><a id="modal-external-button-smartagenda" class="btnSmartAgenda" href="#smartagenda-modal">'.$texte_bouton.'</a>'; 
		$codeBoutonFlottant.= '<div id="smartagenda-modal" class="modalSmartAgenda">
								  <div class="modalSmartAgenda_content">
								  	'.$widget.'
									<a href="#" class="modalSmartAgenda_close">&times;</a>
								  </div>
								</div>';
	}
	
	else{
		$codeBoutonFlottant = '<style id="smartagenda-css" scoped>.btnSmartAgenda{display:block;text-align:center;background-color:'.$couleur_bouton.';color:'.$couleur_texte_bouton.';font-size:16px;text-transform: uppercase;text-decoration:none !important;letter-spacing: 1px;overflow:hidden;padding: 6px 18px;position:fixed;'.$codePosition.';z-index:100000000000;line-height:30px;}.btnSmartAgenda:hover{color:'.$couleur_texte_bouton.' !important; padding: 6px 18px 11px 18px;}@media (max-width: 767px) {.btnSmartAgenda{width: 94%;right:3%;font-size: 14px; top: auto; bottom:0; border-bottom-right-radius:0;border-bottom-left-radius:0;border-top-left-radius:4px;border-top-right-radius:4px;}}</style><a '.$codeCiblePage.' id="external-button-smartagenda" class="btnSmartAgenda" href="'.$url_bouton.'">'.$texte_bouton.'</a>'; 
	}
	
	if ($activerBouton == "true"){
		echo $codeBoutonFlottant;
	}

} 

add_action( 'wp_footer', 'smartagenda_boutonFlottant_init');
