<?php /* @var $this CI_Loader */ ?>
<section class="hero_home hero_mentor" style="background: url('/assets/img/employeur/Background-Employeur.jpg') center center no-repeat;-webkit-background-size: cover;background-position:0px -100px;background-size: cover;min-height:430px">

    <!-- and carousel -->
    <div class="container employeur_contain">
        <div class="row text-center text_hero">
            <div class="col-md-12">
                <p class="p_2">VOS COLLABORATEURS SONT VOS MEILLEURS AMBASSADEURS</p>
                <p class="p_45">90% des candidats souhaitent contacter un employé avant de postuler.<br/>Mettez vos collaborateurs au centre de votre stratégie de Marque Employeur pour attirer les
                    meilleurs talents.</p>
            </div>
        </div>
    </div>
</section>
<section class="block_decouvert bg_grey">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12 title_decouvert">
                <h2>Contactez-nous</h2>
            </div>
        </div>
        <div class="row content_decouvert">
            <div class="col-md-7 col-sm-6">
                <form action="/contact?message" name="f_ulyss_contact" method="post" class="f_el f_ulyss_contact">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="col-sm-4 col-xs-12">
                        <label class="cl_blue"> Choisir un service a contacter</label>
                    </div>
                    <div class="row mgb30">
                        <div class="col-sm-4 col-xs-12 select_field">
                            <select name="service" class="required">
                                <option value="hello@ulyss.co">Contact Général</option>
                                <option value="employeur@ulyss.co">Contact Employeur</option>
                                <option value="presse@ulyss.co">Contact Relation Presse</option>
                                <option value="legal@ulyss.co">Contact Légal / RGPD</option>
                            </select>
                        </div>
                    </div>

                    <input type="text" name="nom" value="" placeholder="Votre Nom*" class="required"/> <input type="text" name="prenom" value="" placeholder="Votre prenom*" class="required"/>
                    <input type="email" name="email" value="" placeholder="Votre email*" class="required"/>
                    <input type="tel" name="telephone" value="" placeholder="Votre numéro de téléphone*" class="required" maxlength="10"/>
                    <textarea name="message" rows="10" placeholder="Renseignez un message*" class="required" maxlength="500"></textarea>

                    <div>
                        <fieldset>
                            <legend>Aceptez-vous recevoir toute l'actualité de ulyss.co ?</legend>

                            <div name="checkbox" class="required">
                                <input type="radio" name="accept" value="accept" type="radio" checked/> <label for="scales">Oui</label>
                                <input type="radio" name="accept" value="dont_accept"/><label for="horns">Non</label>
                            </div>

                        </fieldset>

                    </div>


                    <div class="btn_tem_ment center">
                        <a href="/contact" onclick="postForm('f_ulyss_contact');return false;">Envoyez</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
