<section class="hero_home bg_recherche bg_bllue">
    <div class="search_container">
        <div class="container ">
            <form action="<?php echo base_url(); ?>recherche/comp" method="post" class="row" autocomplete="off" id="formHomesearch">

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 search_row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="col-md-5 col-sm-6 padlr_0">
                            <input type="text" id="competence" placeholder="Compétences">
                            <!--    <input name="competence_id" id="competence_id" value="0" type="hidden"> -->
                            <div class="drop_list drop_list_c" style="display:none;">
                                <ul id="cmp_list">
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 padlr_0 field_talent hidden-xs">
                            <span class="icon_close" onclick="initializeClose();"><i class="fa fa-angle-down"></i></span>
                            <input name="secteur" id="secteur_id" value="<?php if ($this->session->userdata('secteur')) {
                                echo $this->session->userdata('secteur');
                            } else {
                                echo 0;
                            } ?>" type="hidden">
                            <input type="text" id="secteur" value="<?php echo $this->user_info->getSecteurName($this->session->userdata('secteur')); ?>" placeholder="Secteur d'activité">
                            <div class="drop_list drop_list_s">
                                <ul id="secteur_list">
                                    <?php
                                    foreach ($secteur_activites as $item):

                                        ?>
                                        <li class="auto_cat_s" item="<?php echo $item->nom; ?>" item_id="<?php echo $item->id; ?>"><a href="#"><?php echo $item->nom; ?></a></li>
                                    <?php
                                    endforeach ?>
                                </ul>
                            </div>
                        </div>

                        <!-- on mobile -->
                        <div class="col-md-4 col-sm-6 field_talent padlr_0 visible-xs">
                            <span class="icon_close" onclick="initializeClose();"><i class="fa fa-angle-down"></i></span> <input name="secteur" id="secteur_id" value="0" type="hidden">
                            <select name="" id="secteur_list" class="select_home_srch">
                                <option value="">Secteur d'activité</option>
                                <?php
                                foreach ($secteur_activites as $item):

                                    ?>
                                    <option value="<?php echo $item->nom; ?>"><?php echo $item->nom; ?></option>
                                <?php
                                endforeach ?>
                            </select>

                        </div>
                        <!-- end mobile -->

                        <div class="col-md-3 padlr_0">
                            <button type="submit" class="btn_srch" name="touver" value="Trouver">Trouver un mentor</button>
                        </div>

                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="sp_comp sp_langues1">

                            <?php
                            if (!empty($competence_id)) {
                                foreach ($competence_id as $key => $value): ?>
                                    <span class='delete_me' lid="<?php echo $value; ?>" id="delete_langue_r_<?php echo $value; ?>"><?php echo $this->user_info->getTagName($value); ?>
                                        <i class='ion-android-close'></i></span>
                                    <input id='delete_langue_input_<?php echo $value; ?>' type='hidden' value="<?php echo $value; ?>" name='competence_id[]'>
                                <?php endforeach;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section><!-- end hero home -->
<section class="block_result_search">
    <div class="container">
        <div class="row">


            <div class="col-md-3">
                <div class="fl_100">
                    <p class="col-md-12 pph_f_relt"><i class="ion-android-options"></i> Filtres</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 bg_grey block_left">
                            <form method="POST" action="<?php echo base_url(); ?>recherche/comp" id="Formsearch" autocomplete="off">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


                                <div class="row filter_search_ul">
                                    <div class="col-md-12">
                                        <h2>Entreprise</h2>

                                        <div class="h_radio">
                                            <?php foreach ($entreprises as $key => $item):
                                                $checked = "";
                                                if ($this->session->userdata('entreprise') && $this->session->userdata('entreprise') == $item->id) {
                                                    $checked = "checked";
                                                }
                                                ?>
                                                <div class="checkbox_2 checkbox-info">
                                                    <input id="rddd_<?php echo $item->id; ?>" class="styled" type="radio" value="<?php echo $item->id; ?>" name="entreprise" <?php echo $checked; ?>>
                                                    <label for="rddd_<?php echo $item->id; ?>">
                                                        <?php echo $item->nom; ?> (<?php echo count($this->user->getCountEntreprise($item->id)); ?>) </label>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                        <?php if (count($entreprises) > 4) { ?>
                                            <p class="show_all_r">Tout afficher (<?php echo count($entreprises) - 4; ?>)</p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row filter_search_ul">
                                    <div class="col-md-12">
                                        <h2>Département</h2>

                                        <div class="h_radio">
                                            <?php foreach ($categories as $key => $item):
                                                $checked = "";
                                                if ($this->session->userdata('categorie') && $this->session->userdata('categorie') == $item->id) {
                                                    $checked = "checked";
                                                }
                                                ?>
                                                <div class="checkbox_2 checkbox-info">
                                                    <input id="rd_<?php echo $item->id; ?>" class="styled" type="radio" value="<?php echo $item->id; ?>" name="departement" <?php echo $checked; ?>>
                                                    <label for="rd_<?php echo $item->id; ?>">
                                                        <?php echo $item->nom; ?> (<?php echo $this->user->getCountDepartement($item->id); ?>) </label>
                                                </div>
                                            <?php endforeach ?>


                                        </div>
                                        <?php if (count($categories) > 4) { ?>
                                            <p class="show_all_r">Tout afficher (<?php echo count($categories) - 4; ?>)</p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row filter_search_ul">
                                    <div class="col-md-12">
                                        <h2>Fonction</h2>

                                        <div class="h_radio">
                                            <?php foreach ($fonctions as $key => $item):

                                                $checked = "";
                                                if ($this->session->userdata('scat') && $this->session->userdata('scat') == $item->id) {
                                                    $checked = "checked";
                                                }
                                                ?>
                                                <div class="checkbox_2 checkbox-info">
                                                    <input id="rdd_<?php echo $item->id; ?>" class="styled" type="radio" value="<?php echo $item->id; ?>" name="fonction" <?php echo $checked; ?>>
                                                    <label for="rdd_<?php echo $item->id; ?>">
                                                        <?php echo $item->nom; ?> (<?php echo $this->user->getCountFonctions($item->id); ?>) </label>
                                                </div>
                                            <?php endforeach ?>


                                        </div>
                                        <?php if (count($fonctions) > 4) { ?>
                                            <p class="show_all_r">Tout afficher (<?php echo count($fonctions) - 4; ?>)</p>
                                        <?php } ?>
                                    </div>
                                </div>


                            </form>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center ">
                            <div class="col-md-12 btn_blue">
                                <button onclick="gotoSearch();" class="row">Je n'ai pas trouvé le Mentor idéal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-9  block_right">
                <div class="row" id="nbr_of_prof">
                    <p class="col-md-7 p_title_relt"><b><?php echo count($result_count); ?> mentors</b> <br>prêts à vous conseiller</p>
                    <div class="col-md-5 sort_search">
                        <div class="row">
                            <div class="col-xs-4 text-right">
                                <span>Trier par</span>
                            </div>
                            <div class="col-xs-8">
                                <select class="field_sort_search ">
                                    <option value="">Prix croissant</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <?php foreach ($result as $row): ?>

                        <a href="<?php echo base_url(); ?><?php echo $row->alias_u; ?>/<?php echo $row->alias_t; ?>/apropos">

                            <div class="col-md-6 result_pers">
                                <div class="bg_white_2 pad_0">
                                    <div class="row display_flex">
                                        <div class="col-md-5 col-sm-5 img_membre">
                                            <?php if (strpos($row->avatar, "https://") !== false) { ?>
                                                <span class="avatar img_linkedin" style="background: url('<?php echo $row->avatar; ?>') center center no-repeat;">
										</span>
                                            <?php } else { ?>
                                                <span class="avatar" style="background: url('<?php echo base_url(); ?>image.php/<?php echo $row->avatar; ?>?height=200&width=170&cropratio=1:1&image=<?php echo $this->s3file->getUrl($this->config->item('upload_avatar') . $row->avatar); ?>') center center no-repeat;">
										</span>
                                            <?php } ?>


                                        </div>
                                        <div class="col-md-7 col-sm-7 padl-0">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="name_entreprise"><?php echo $row->entreprise; ?></h4>
                                                    <p class="name_pers_2">Chef de projet</p>
                                                    <div class="inf_pr_ava">

                                                        <div class="rate">
                                                            <p class="name_pers">
                                                                <?php echo $row->prenom; ?>
                                                            </p>
                                                            <?php
                                                            $nbr_cmt       = $this->talent->GetcountCompTalent($row->id);
                                                            $sum_note      = $this->talent->GetSumNoteCmtTalent($row->id);
                                                            $nombre_etoile = 0;
                                                            if (!empty($sum_note) && $nbr_cmt > 0) {
                                                                $nombre_etoile = round($sum_note->note / $nbr_cmt);
                                                            }
                                                            ?>
                                                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                                                <?php if ($i < $nombre_etoile) { ?>
                                                                    <i class="fa fa-star"></i>
                                                                <?php } else { ?>
                                                                    <i class="fa fa-star-o"></i>

                                                                <?php }
                                                            } ?>

                                                            <span>(<?php echo $nbr_cmt; ?>)</span>
                                                        </div>
                                                    </div>
                                                    <p class="pos_pers">
                                                        <span><i class="fa fa-map-marker"></i><?php echo $row->ville; ?> <?php echo $row->ville_code_postal; ?></span>
                                                    </p>
                                                    <!-- <p class="text fz17"><?php echo $row->description; ?></p> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="prix_heure">
                                                        <span><?php echo $row->prix; ?> € / <u>30 min</u></span>
                                                    </p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <!-- detail -->
                                <!-- <div class="col-md-8 col-sm-8 details_pers text-left">
								<p class="text"><?php echo $row->description; ?></p>
								<p class="tags"><?php echo $this->user_info->getcategories_talent($row->id); ?></p>
								<p class="prix_heure">
									<span><?php echo $row->prix; ?> <em>€ / H</em></span>
								</p>
								<p class="link_profil text-center"><a href="<?php echo base_url(); ?><?php echo $row->alias_u; ?>/<?php echo $row->alias_t; ?>/apropos">Voir le profil</a></p>
							</div> -->
                                <!-- end detail -->
                            </div>
                        </a>

                    <?php endforeach ?>
                </div>
                <div class="row pagination_result text-center">
                    <div class="col-md-12">
                        <?php if ($links) { ?>
                            <label class="title_sort">Page:</label>
                        <?php } ?>
                        <?php echo $links; ?>


                        <!-- 							<span class="bnt_nxt"><a href="#">Précédent</a></span>

                                                    <span class="page active"><a href="#">1</a></span>
                                                    <span class="page"><a href="#">2</a></span>
                                                    <span class="page"><a href="#">3</a></span>
                                                    <span class="page"><a href="#">4</a></span>

                                                    <span class="bnt_nxt"><a href="#">Suivant</a></span> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
	function gotoSearch() {
		$('#Formsearch').submit();
	}

	$(document).ready(function () {


		$(window).resize(function () {
            <?php    if(count($result_count) == 0){ ?>
			$('html, body').animate({
				scrollTop: $("#nbr_of_prof").offset().top
			}, 2000);
            <?php    } ?>
		});

		$('.date-picker-n').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			language: 'fr'
		});

		$('.date-picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: "true",
			startDate: '1d',
			language: 'fr'
		});
		$(".chargement_b").hide();
		$("#carousel_coup").owlCarousel({
			autoPlay: 3000, //Set AutoPlay to 3 seconds
			items: 3,
			itemsDesktop: [1199, 3],
			itemsDesktopSmall: [979, 3]

		});


		$("#gcat").change(function () {
			$("#scat").html('');
			$.ajax({
				type: "GET",
				url: base_url + "recherche/get_sous_categorie",
				dataType: 'html',
				data: {id: $(this).val()},
				success: function (list) {
					$("#scat").html(list);
				}
			});
		});
		$('.show_all_r').click(function () {
			$(this).parent().toggleClass('show');
		});
	});
</script>