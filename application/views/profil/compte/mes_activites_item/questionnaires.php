<?php /* @var $this CI_Loader */ ?>
<div class="modal fade ent_mod" id="questionModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="informations-questionnaire">
                <i class="fa fa-exclamation-triangle"></i> ULYSS.CO est un service totalement gratuit. Pour continuer d'en bénéficier, pouvez-vous s'il vous plait répondre à ces quelques questions.
            </div>

            <h3>Vous questionner en tant que utilisateur ulyss.co</h3>
            <?php if ($this->getController()->hasQuestionnairesUser()) { ?>
                <h3>Votre questionner en tant qu'utilisateur Ulyss.co</h3>
                <section class="block_resultas wanted_block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">
                                <?php $ModelQuestionnaires = $this->getController()->getModelQuestionnairesUser() ?>
                                <?php if (count($ModelQuestionnaires) > 0) { ?>

                                    <?php foreach ($ModelQuestionnaires as $Conversation) { ?>
                                        <?php $BusinessConversation = new BusinessConversation($Conversation); ?>

                                        <div class="f_reservation questionnaire">
                                            <b>Votre RDV avec <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> a eu lieu
                                                le <?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(); ?></b> <br/><br/> Nous espérons que ce RDV vous a été utile.<br/>
                                            Pour pouvoir réutiliser notre service et contacter notre communauté de Mentors, veuillez répondre à ces quelques questions :<br/> "Suite à votre entretien
                                            avec un Mentor, estimez-vous que cette entreprise..."<br/>
                                            <form action="/messages/questionaire/<?php echo $BusinessConversation->getId(); ?>" method="post" id="form_questionnaire_<?php echo $BusinessConversation->getId(); ?>">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                <div class="question1 questions">
                                                    <p class="quest">De quelle entreprise avez-vous discuté ?</p>
                                                    <div class="answer">
                                                        <select name="entreprise">
                                                            <option value="-1">Choisissez une entreprise</option>
                                                            <?php foreach ($BusinessConversation->getBusinessUserInterlocutor()->getBusinessTalent()->getBusinessEntreprises() as $BusinessEntreprise) {
                                                                /* @var $BusinessEntreprise BusinessEntreprise */ ?>
                                                                <option value="<?php echo $BusinessEntreprise->getId(); ?>"><?php echo $BusinessEntreprise->getNom(); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="cf buttons">
                                                        <a href="#" class="btn_style_send floatright" onclick="nextQuestion($(this), '2');return false;">Prochaine question</a>
                                                    </div>
                                                </div>
                                                <div class="question2 questions">
                                                    <p class="quest">est innovante ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="entInnovante" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="entInnovante" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="entInnovante" value="2">Ne se prononce pas</label>
                                                    </div>
                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'1');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '3');return false;">Prochaine question</a>
                                                    </div>
                                                </div>
                                                <div class="question3 questions">
                                                    <p class="quest">est à l'écoute de ses collaborateurs ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="ecouteCollabo" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="ecouteCollabo" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="ecouteCollabo" value="2">Ne se prononce pas</label>
                                                    </div>

                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'2');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '4');return false;">Prochaine question</a>
                                                    </div>
                                                </div>
                                                <div class="question4 questions">
                                                    <p class="quest">favorise les bonnes conditions de travail ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="goodconditions" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="goodconditions" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="goodconditions" value="2">Ne se prononce pas</label>
                                                    </div>

                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'3');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '5');return false;">Prochaine question</a>
                                                    </div>
                                                </div>
                                                <div class="question5 questions">
                                                    <p class="quest">accorde de l'importance à l'ambiance de travail ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="ambianceEnt" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="ambianceEnt" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="ambianceEnt" value="2">Ne se prononce pas</label>
                                                    </div>

                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'4');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '6');return false;">Prochaine question</a>

                                                    </div>
                                                </div>

                                                <div class="question6 questions">
                                                    <p class="quest">favorise l'évolution professionnelle ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="evolutionEnt" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="evolutionEnt" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="evolutionEnt" value="2">Ne se prononce pas</label>
                                                    </div>

                                                    <div class="cf buttons">

                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'5');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '7');return false;">Prochaine question</a>

                                                    </div>
                                                </div>

                                                <div class="question7 questions">
                                                    <p class="quest">valorise ses collaborateurs ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="valoriseCollabo" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="valoriseCollabo" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="valoriseCollabo" value="2">Ne se prononce pas</label>
                                                    </div>

                                                    <div class="cf buttons">

                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'6');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '8');return false;">Prochaine question</a>

                                                    </div>
                                                </div>

                                                <div class="question8 questions">
                                                    <p class="quest">rémunère bien ses employés ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="remuneration" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="remuneration" value="0">Non</label>
                                                        <label class="radio-inline"><input type="radio" name="remuneration" value="2">Ne se prononce pas</label>
                                                    </div>

                                                    <div class="cf buttons">

                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'7');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '9');return false;">Prochaine question</a>

                                                    </div>
                                                </div>


                                                <div class="question9 questions">
                                                    <p class="quest">Souhaiteriez-vous intégrer cette entreprise ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="integration_entreprise" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="integration_entreprise" value="0">Non</label>
                                                    </div>

                                                    <div class="cf buttons">

                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'8');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '10');return false;">Prochaine question</a>

                                                    </div>
                                                </div>
                                                <div class="question10 questions">
                                                    <p class="quest">Recommanderiez-vous ce Mentor ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" name="recommandation" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" name="recommandation" value="0">Non</label>
                                                    </div>

                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'9');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestion($(this), '11');return false;">Prochaine question</a>

                                                    </div>
                                                </div>
                                                <div class="question11 questions">
                                                    <p class="quest">Recommanderiez-vous le service ULYSS.CO ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion7($(this));" name="recommandation_ulyss" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion7($(this));" name="recommandation_ulyss" value="0">Non</label>
                                                    </div>

                                                    <div class="complement" style="display:none;margin-top:10px;">
                                                        <p class="quest">Pour quelle(s) raison(s) ?</p>
                                                        <div class="answer">
                                                            <textarea placeholder="Dites nous en quelques mots pourquoi vous ne souhaiteriez pas recommander Ulyss.co..." name="recommandation_ulyss_non" style="width:100%;height:100px;resize:none;padding:10px;"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="cf buttons">

                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'6');return false;">Précédente question</a>

                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestion($(this),'10');return false;">Précédente question</a>

                                                        <a href="#" class="button next btn_style_send floatright" onclick="validQuest($(this));return false;">Terminer</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>
            <h3>Vous questionner en tant que mentor</h3>
            <?php if ($this->getController()->hasQuestionnairesMentor()) { ?>
                <h3>Votre questionnaire en tant que Mentor</h3>
                <section class="block_resultas wanted_block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">

                                <?php $ModelQuestionnaires = $this->getController()->getModelQuestionnairesMentor() ?>
                                <?php if (count($ModelQuestionnaires) > 0) { ?>
                                    <?php foreach ($ModelQuestionnaires as $Conversation) { ?>
                                        <?php $BusinessConversation
                                            = new BusinessConversation($Conversation); ?>

                                        <div class="f_reservation questionnaire">
                                            <b>Votre RDV avec <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> a eu lieu
                                                le <?php echo $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(); ?></b> <br/><br/> Nous espérons que ce RDV vous a été utile.<br/>
                                            Pour pouvoir réutiliser notre service et contacter notre communauté de Mentors, veuillez répondre à ces quelques questions :<br/><br/>
                                            <form action="/messages/questionairementor/<?php echo $BusinessConversation->getId(); ?>" method="post" id="form_questionnaire_mentor<?php echo $BusinessConversation->getId(); ?>">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                <div class="question1 questions">
                                                    <p class="quest">Votre RDV avec <?php echo $BusinessConversation->getBusinessUserInterlocutor()->getFullName(); ?> a-t-il eu lieu ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" onclick="$('.question1 .buttons .next').show();$('.question1 .buttons .valid').hide();" name="issetrdv" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" onclick="$('.question1 .buttons .next').hide();$('.question1 .buttons .valid').show();" name="issetrdv" value="0">Non</label>
                                                    </div>
                                                    <div class="cf buttons">
                                                        <a href="#" style="display:none;" class="button next btn_style_send floatright next" onclick="nextQuestionMentor($(this), '2');return false;">Prochaine
                                                            question</a>
                                                        <a href="#" style="display:none;" class="button next btn_style_send floatright valid" onclick="validQuestMentor($(this));return false;">Terminer</a>
                                                    </div>
                                                </div>
                                                <div class="question2 questions">
                                                    <p class="quest">Etes-vous satisfait de votre expérience globale sur la plateforme ULYSS.CO ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion2mentor($(this));" name="experience_globale" value="Pas du tout satisfait">Pas
                                                            du tout satisfait</label>
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion2mentor($(this));" name="experience_globale" value="Pas satisfait">Pas
                                                            satisfait</label>
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion2mentor($(this));" name="experience_globale" value="Satisfait">Satisfait</label>
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion2mentor($(this));" name="experience_globale" value="Tout à fait satisfait">Tout
                                                            à fait satisfait</label>
                                                    </div>

                                                    <div class="complement" style="display:none;margin-top:10px;">
                                                        <p class="quest">Pour quelle(s) raison(s) ?</p>
                                                        <div class="answer">
                                                            <textarea placeholder="Expliquez nous en quelques mots la raison..." name="experience_globale_non" style="width:100%;height:100px;resize:none;padding:10px;"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestionMentor($(this),'1');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="nextQuestionMentor($(this), '3');return false;">Prochaine question</a>
                                                    </div>
                                                </div>
                                                <div class="question3 questions">
                                                    <p class="quest">Recommanderiez-vous le service ULYSS.CO ?</p>
                                                    <div class="answer">
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion3mentor($(this));" name="recommandation_ulyss" value="1">Oui</label>
                                                        <label class="radio-inline"><input type="radio" onclick="showComplementQuestion3mentor($(this));" name="recommandation_ulyss" value="0">Non</label>
                                                    </div>

                                                    <div class="complement" style="display:none;margin-top:10px;">
                                                        <p class="quest">Pour quelle(s) raison(s) ?</p>
                                                        <div class="answer">
                                                            <textarea placeholder="Expliquez nous en quelques mots la raison..." name="recommandation_ulyss_non" style="width:100%;height:100px;resize:none;padding:10px;"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="cf buttons">
                                                        <a href="#" class="button next btn_style_send floatleft" onclick="prevQuestionMentor($(this),'2');return false;">Précédente question</a>
                                                        <a href="#" class="button next btn_style_send floatright" onclick="validQuestMentor($(this));return false;">Terminer</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>
    </div>
</div>