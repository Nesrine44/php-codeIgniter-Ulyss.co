<?php /* @var LinkedinScraping $LinkedinScraping */ ?>
<?php /* @var array $profileProfile */ ?>
<?php /* @var array $profileExperiences */ ?>
<?php /* @var array $profileFormations */ ?>
<?php /* @var array $profileCompetences */ ?>
<?php /* @var array $secteur_activites */ ?>
<?php /* @var array $categories */ ?>
<?php /* @var array $fonctions */ ?>
<?php /* @var StdClass $Experiences */ ?>
<?php //var_dump($Experiences); die(); ?>

<section class="hero_ccm hero_dcc bg_prof">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-hr">
                <h1 class="prof_img">
                    <img src="<?php echo $LinkedinScraping->getValueInArray($profileProfile, 'url_picture'); ?>" alt="">
                </h1>
                <p class="title_profl"><?php echo $LinkedinScraping->getValueInArray($profileProfile, 'fullName'); ?></p>
            </div>
        </div>
    </div>
</section>
<section class="pg-ccm pg-dcc">
    <div class="container">
        <form id="f_linkedin" action="<?php echo base_url(); ?>mentor/step3" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row text-center mgb30">
                <div class="col-md-12">
                    <p class="nb_step">Etape 2 sur 4 </p>
                    <h1 class="title_st">Renseignez vos expériences</h1>
                </div>
            </div>
            <div class="row mgb30">
                <div class="col-md-12">
                    <h3 class="title_exper">Expériences</h3>
                </div>
            </div>
            <?php if (is_array($profileExperiences)) { ?>
                <?php foreach ($profileExperiences as $key => $profileExperience) { ?>
                    <?php $ModelTalentExperience = $this->ModelTalent->getExperienceByJobId($LinkedinScraping->getValueInArray($profileExperience, 'idjob')); ?>
                    <?php $profileExperience['period'] = isset($profileExperience['period']) ? $profileExperience['period'] : ''; ?>
                    <input type="hidden" name="experience[<?php echo $key; ?>][idjob]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience, 'idjob'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][title_job]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience, 'title'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][company][code]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'code'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][company][nom]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'name'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][company][industry]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'],
                        'industry'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][company][logo]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'logo'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][period_start]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['period'], 'start'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][period_end]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['period'], 'end'); ?>"/>
                    <input type="hidden" name="experience[<?php echo $key; ?>][company][city]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'city'); ?>"/>
                    <div class="row profileexp">
                        <div class="col-sm-9">
                            <div class="row mgb_15">
                                <div class="col-md-12">
                                    <div class="row">
                                        <p class="col-md-12 title_sect_prof"><?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'name'); ?></p>
                                    </div>
                                    <div class="row mgb30 <?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'industry') != '' ? 'hideitem' : ''; ?>">
                                        <div class="col-sm-4 col-xs-12">
                                            <label class="cl_blue">Choisir un secteur d'activité :</label>
                                        </div>
                                        <div class="col-sm-4 col-xs-12 select_field">
                                            <?php if ($LinkedinScraping->getValueInArray($profileExperience['compagny'], 'industry') != '') { ?>
                                                <?php foreach ($secteur_activites as $secteur): ?>
                                                    <?php if ($secteur->nom == $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'industry')) { ?>
                                                        <input type="hidden" name="experience[<?php echo $key; ?>][secteur]" value="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'],
                                                            'industry') == $secteur->nom ? $secteur->id : ''; ?>"/>
                                                        <?php break; ?>
                                                    <?php } ?>
                                                <?php endforeach ?>
                                            <?php } ?>
                                            <?php
                                            $activityname = $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'industry');
                                            $activityID   = -1;
                                            if ($activityname == '' && $ModelTalentExperience != null) {
                                                $activityID = $ModelTalentExperience->secteur_id;
                                            }
                                            ?>
                                            <select <?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'],
                                                'industry') != '' ? 'disabled' : ''; ?> name="experience[<?php echo $key; ?>][secteur]" class="required">
                                                <option value="">Secteur d'activité</option>
                                                <?php foreach ($secteur_activites as $secteur): ?>
                                                    <option <?php echo $activityname == $secteur->nom || $activityID == $secteur->id ? 'selected' : ''; ?> value="<?php echo $secteur->id; ?>"><?php echo $secteur->nom; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mgb30 rowdepartement">
                                        <div class="col-sm-4 col-xs-12">
                                            <label class="cl_blue"> Choisir un département :</label>
                                        </div>
                                        <div class="col-sm-4 col-xs-12 select_field">
                                            <select name="experience[<?php echo $key; ?>][departement]" class="required departement" lid="<?php echo $key; ?>">
                                                <option value="">Département</option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?php echo $cat->id; ?>" <?php echo $ModelTalentExperience != null && $ModelTalentExperience->departement_id == $cat->id ? 'selected' : ''; ?>><?php echo $cat->nom; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row rowfonction" style="display: none;">
                                        <div class="col-sm-4 col-xs-12">
                                            <label class="cl_blue"> Choisir une fonction :</label>
                                        </div>
                                        <div class="col-sm-4 col-xs-12 select_field">
                                            <select name="experience[<?php echo $key; ?>][fonction]" class="required fonction_<?php echo $key; ?>">
                                                <option value="">Fonction</option>
                                                <?php foreach ($fonctions as $fonc): ?>
                                                    <option value="<?php echo $fonc->id; ?>" <?php echo $ModelTalentExperience != null && $ModelTalentExperience->fonction_id == $fonc->id ? 'selected' : ''; ?>><?php echo $fonc->nom; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mgb30">
                                <div class="col-md-12">
                                    <div class="row">
                                        <p class="col-md-12 ">
                                            <?php if (isset($profileExperience['period'])) { ?>
                                                <?php if ($LinkedinScraping->getFormattedDate($LinkedinScraping->getValueInArray($profileExperience['period'], 'start')) != '') { ?>
                                                    <?php echo $LinkedinScraping->getFormattedDate($LinkedinScraping->getValueInArray($profileExperience['period'], 'start')); ?> -
                                                <?php } ?>
                                                <?php if ($LinkedinScraping->getValueInArray($profileExperience['period'], 'end') != '') { ?>
                                                    <?php echo $LinkedinScraping->getFormattedDate($LinkedinScraping->getValueInArray($profileExperience['period'], 'end')); ?>
                                                <?php } else { ?>
                                                    Aujourd'hui
                                                <?php } ?>
                                            <?php } ?>
                                            <br/><?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'city'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-sm logo_post alignright">
                            <img src="<?php echo $LinkedinScraping->getValueInArray($profileExperience['compagny'], 'logo'); ?>" alt="">
                        </div>
                        <div class="row mgb30 det">
                            <div class="col-md-12">
                                <div class="row mgb_15">
                                    <p class="col-md-12 title_sect_prof">Description</p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-desc_post">
                                        <?php
                                        $description = $LinkedinScraping->getValueInArray($profileExperience, 'description');
                                        if ($ModelTalentExperience != null && $description == '') {
                                            $description = $ModelTalentExperience->description;
                                        }
                                        ?>
                                        <textarea name="experience[<?php echo $key; ?>][description]" class="desc_exp" rows="5" placeholder="Description"><?php echo $description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php if (is_array($profileCompetences) && count($profileCompetences) > 0) { ?>
                <div class="row mgb30">
                    <div class="col-md-12">
                        <div class="row mgb_15">
                            <h3 class="col-md-12 title_exper">Compétences</h3>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="sp_langues pad_22">
                                    <?php foreach ($profileCompetences as $key => $profileCompetence) { ?>
                                        <span class="delete_me1"><?php echo $profileCompetence; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (is_array($profileFormations) && count($profileFormations) > 0) { ?>
                <hr>
                <div class="row mgb_15">
                    <div class="col-md-12">
                        <div class="row mgb_15">
                            <h3 class="col-md-12 title_exper">Formations</h3>
                        </div>
                        <?php foreach ($profileFormations as $key => $profileFormation) { ?>
                            <div class="row mgb_30">
                                <div class="col-md-12">
                                    <p class="title_sect_prof"><?php echo($LinkedinScraping->getValueInArray($profileFormation, 'Name')); ?></p>
                                    <p class="mgb0"><?php echo($LinkedinScraping->getValueInArray($profileFormation, 'fonction')); ?></p>
                                    <p class="mgb0">
                                        <?php if (isset($profileFormation['period'])) { ?>
                                            <?php echo $LinkedinScraping->getFormattedDate($LinkedinScraping->getValueInArray($profileFormation['period'], 'start')); ?> -
                                            <?php if ($LinkedinScraping->getValueInArray($profileFormation['period'], 'end') != '') { ?>
                                                <?php echo $LinkedinScraping->getFormattedDate($LinkedinScraping->getValueInArray($profileFormation['period'], 'end')); ?>
                                            <?php } else { ?>
                                                Aujourd'hui
                                            <?php } ?>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>
            <?php } ?>

            <div class="row mgb_30 btn_add_cours text-right">
                <div class="col-md-12">
                    <p class="etap1_error" style="display:none;"></p>
                </div>
                <div class="col-md-12 mgb_30">
                    <button type="submit" onclick="sendForm('f_linkedin'); return false;">Étape 3/4 <i class="fa fa-angle-right"></i></button>
                </div>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
	$(document).ready(function () {
		$('.profileexp').each(function () {
			if ($(this).find('.rowdepartement select option:selected').text() != $(this).find('.rowfonction select option:selected').text() && parseInt($(this).find('.rowfonction select').val()) > 0)
				$(this).find('.rowfonction').show();
		});
	});
</script>