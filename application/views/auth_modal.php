<!-- Modal connexion -->
<div class="modal fade text-center modal_home" id="ModalConnexion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <h1>Connexion</h1>
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row mgb_0">
                            <div class="col-md-12 conex_fb">
                                <form action="/auth/linkedinConnect" method="get" name="loginlinkedin">
                                    <input type="hidden" name="callback" value=""/>
                                    <a href="#" onclick="$(this).closest('form').submit(); return false;" class="connect_with_linkedin"><span><i class="fa fa-linkedin"></i></span>LinkedIn</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <p><span>------------------------------------</span>&nbsp;&nbsp; ou &nbsp;&nbsp; <span>------------------------------------</span></p>
                <?php echo form_open('/auth/ulyssConnect') ?>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <input class="inputText" name="email" type="email" placeholder="E-mail">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <input class="inputText" type="password" name="password" placeholder="Mot de passe">
                    </div>
                </div>
                <a class="mgb_15" href="" style="display: block;margin-left: 260px;" data-toggle="modal" data-target="#forgetModalUsers">Mot de passe oublié ?</a>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <input class="btnDefault" type="submit" value="SE CONNECTER">
                    </div>
                    <br><br>
                    <p>Pas encore inscrit ? <a href="#" data-toggle="modal" data-target="#modalInscription" data-dismiss="modal">Candidat</a> -
                        <a href="#" data-toggle="modal" data-target="#modalInscriptionMentor" data-dismiss="modal">Mentor</a></p>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- end modal connexion -->

<div class="modal fade" id="forgetModalUsers" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <?php echo form_open() ?>
                <p>Entrez votre email pour réinitialiser votre mot de passe :</p>
                <input id="email_oublier" type="email" name="email_oublier" placeholder="Adresse mail de connexion">

                <input onclick="return ForgetMypassword()" class="forgot_btn" type="submit" value="ENVOYER">
                <div class="row">
                    <div class="col-md-12 text-center block_pass" style="display:none;" id="erreur-mdp-oublier">
                        <p class="error">Merci de renseigner votre adresse mail</p>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>