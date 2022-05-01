<section class="block_resultas " style="padding-top:0">
	<div class="container">
		<div class="row block_item_talents" style="margin-top:0">
			<div class="col-md-8" style="padding-top:60px">
				<div class="row">
					<h1 class="text-center mgb_30">
						Mes autres disciplines
					</h1>
                    <?php foreach ($talents as $talent) { ?>
						<div class="col-md-6">
							<a href="<?php echo base_url() . $alias . '/' . $talent->alias; ?>/apropos">
								<div class="col-md-12 item_talent bg_grey">
									<div class="">
										<span class="price_item"><?php echo $talent->prix; ?> <em>€ / H</em></span>
										<div class="row mh_bl mgb_0 ">

											<div class="col-md-4">
												<div class="img_article">
													<span class="avatar"><img src="<?php echo base_url($this->config->item('upload_talents') . $talent->cover); ?>" alt=""></span>
												
												</div>
											</div>
											<div class="col-md-8 text-left ovh-text">
												<h3><?php echo $talent->titre; ?></h3>
												<p>
                                                    <?php
                                                    $nbr_cmt = $this->talent->GetcountCompTalent($talent->id);
                                                    $sum_note = $this->talent->GetSumNoteCmtTalent($talent->id);
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
												</p>
												<p class="mgb_0"><?php echo character_limiter($talent->description, 150); ?></p>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
                    <?php } ?>
				</div>
			</div>
			<div class="col-md-4 ">
				<div class="profil_reservation">
					<div class="price text-left">
                        <?php echo $info_talent->prix; ?></i> <u>€</u> <span class="pull-right">Par heure</span>
					</div>
					<form id="formReservation">
						<input type="hidden" value="h" name="prix_offre">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

						<input type="hidden" name="talent_id" value="<?php echo $info_talent->id; ?>">
						<input type="hidden" name="date_offre" value="<?php echo date('d/m/Y'); ?>" id="my_hidden_input">
						<div class="calendar">
							<h3>Sélectionnez une date</h3>
							<div class="rdrd">
								<div class="date-picker-i datepicker-inline"></div>
								<div class="hours_span text-center html_dispo">
									<span class="horaire_td  <?php if ($disponible['8_10'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="8h-10h" name="crenaux[]" class="<?php if ($disponible['8_10'] == 1) echo 'check_disp'; ?>" <?php if ($disponible['8_10'] != 1) echo 'disabled'; ?>>8h-10h</span>
									<span class="horaire_td  <?php if ($disponible['10_12'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="10h-12h" name="crenaux[]" class="<?php if ($disponible['10_12'] == 1) echo 'check_disp'; ?>" <?php if ($disponible['10_12'] != 1) echo 'disabled'; ?>>10h-12h</span>
									<span class="horaire_td  <?php if ($disponible['12_14'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="12h-14h" name="crenaux[]" class="check_disp" <?php if ($disponible['12_14'] != 1) echo 'disabled'; ?>>12h-14h</span>
									<span class="horaire_td  <?php if ($disponible['14_16'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="14h-16h" name="crenaux[]" class="check_disp" <?php if ($disponible['14_16'] != 1) echo 'disabled'; ?>>14h-16h</span>
									<span class="horaire_td  <?php if ($disponible['16_18'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="16h-18h" name="crenaux[]" class="check_disp" <?php if ($disponible['16_18'] != 1) echo 'disabled'; ?>>16h-18h</span>
									<span class="horaire_td  <?php if ($disponible['18_20'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="18h-20h" name="crenaux[]" class="check_disp" <?php if ($disponible['18_20'] != 1) echo 'disabled'; ?>>18h-20h</span>
									<span class="horaire_td  <?php if ($disponible['20_22'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="20h-22h" name="crenaux[]" class="check_disp" <?php if ($disponible['20_22'] != 1) echo 'disabled'; ?>>20h-22h</span>
								</div>
								<div class="text-left select">
									<label for="">Nombre d'heures</label>
									<select name="nbr_heure" id="js_nbr_heure" onchange="calcul();">
                                        <?php for ($i = 1; $i < 12; $i++) { ?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>

									</select>
								</div>
								<div class="text-left select">
									<label for="">Nombre de personnes</label>
									<select name="nbr_personne" id="js_nbr_personne" onchange="calcul();">
                                        <?php for ($i = 1; $i < 12; $i++) { ?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
									</select>
								</div>
								<div class="row_price_cal text-left mgt30 ">
									<span class="left_spn"><?php echo $info_talent->prix; ?>€ x <span class="nbr_heure">1</span> heure(s)</span>
									<span class="pull-right text-right right_spn prix_par_h"><?php echo $info_talent->prix; ?>€</span>
								</div>
								<div class="row_price_cal text-left" id="div_nbr_personne" style="display:none;">
									<span class="left_spn"><?php echo $info_talent->reduction_personne; ?>€ x <span class="nbr_personne">1</span> personne(s) supp</span>
									<span class="pull-right text-right right_spn prix_personne_p"><?php echo $info_talent->reduction_personne; ?>€</span>
								</div>
								<div class="row_price_cal text-left heure_red_clt" style="display:none;">
									<span class="left_spn heure_red_clt1"><?php echo $info_talent->reduction_personne; ?></span>
									<span class="pull-right text-right right_spn heure_red_clt2"><?php echo $info_talent->reduction_personne; ?>€</span>
								</div>
								<div class="row_price_cal text-left">
									<span class="left_spn">Frais de service</span>
									<span class="pull-right text-right right_spn">8%</span>
								</div>
								<div class="row_price_cal bbn text-left">
									<span class="left_spn">Total</span>
									<span class="pull-right text-right right_spn total_complet"><?php echo $info_talent->prix + $info_talent->prix * (8 / 100); ?>€</span>
								</div>
								<div class="btn-resa">
                                    <?php if ($this->session->userdata('logged_in_site_web')) { ?>
                                        <?php if ($droir_editer) { ?>
											<input type="submit" class="me_reserv" disabled="disabled" value="Envoyer une demande">
                                        <?php } else { ?>
                                            <?php if ($disponible['8_10'] != 1 && $disponible['10_12'] != 1 && $disponible['12_14'] != 1 && $disponible['14_16'] != 1 && $disponible['16_18'] != 1 && $disponible['18_20'] != 1 && $disponible['20_22'] != 1) { ?>
												<input type="submit" class="me_reserv" disabled="disabled" value="Envoyer une demande">
                                            <?php } else { ?>
												<input type="submit" value="Envoyer une demande">
                                            <?php }
                                        } ?>
                                    <?php } else { ?>
										<a href="#" data-toggle="modal" data-target="#ModalConnexion"> Envoyer une demande</a>
                                    <?php } ?>
									<p class="p_under_resa">Vous serez débité que si vous acceptez l'offre.</p>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>