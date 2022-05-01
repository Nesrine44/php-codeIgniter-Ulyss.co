<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 04/02/2019
 * Time: 13:16
 */
?>


<div class="modal fade text-center modal_home" id="modalInscription" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row mgb_0">
                            <div class="col-md-12 conex_fb">
                                <form action="/auth/linkedinConnect" method="get" name="loginlinkedin">
                                    <input type="hidden" name="callback" value="/mentor/etape1"/>
                                    <a href="#" onclick="$(this).closest('form').submit(); return false;" class="connect_with_linkedin"><span><i class="fa fa-linkedin"></i></span>M'inscrire avec mon
                                        profil LinkedIn</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <p><span>------------------------------------</span>&nbsp;&nbsp; ou &nbsp;&nbsp; <span>------------------------------------</span></p>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                             width="26" height="26"
                             viewBox="0 0 224 224"
                             style=" fill:#000000;position: absolute;left: 40px;top: 7px;">
                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-size="none" style="mix-blend-mode: normal">
                                <path d="M0,224v-224h224v224z" fill="none"></path>
                                <g fill="#ffffff">
                                    <g id="surface1">
                                        <path d="M25.84615,34.46154c-14.26923,0 -25.84615,11.57692 -25.84615,25.84615v103.38462c0,14.26923 11.57692,25.84615 25.84615,25.84615h172.30769c14.26923,0 25.84615,-11.57692 25.84615,-25.84615v-103.38462c0,-14.26923 -11.57692,-25.84615 -25.84615,-25.84615zM25.84615,51.69231h172.30769c4.74519,0 8.61538,3.87019 8.61538,8.61538v4.30769l-94.76923,51.15385l-94.76923,-51.15385v-4.30769c0,-4.74519 3.87019,-8.61538 8.61538,-8.61538zM17.23077,67.03846l56.26923,43.88462l-55.19231,56.53846l67.30769,-47.92308l26.38462,16.96154l26.38462,-16.96154l67.30769,47.92308l-55.19231,-56.53846l56.26923,-43.88462v96.65385c0,1.41347 -0.47115,2.59134 -1.07692,3.76923c-1.41346,2.79327 -4.17308,4.84615 -7.53846,4.84615h-172.30769c-3.36538,0 -6.125,-2.05288 -7.53846,-4.84615c-0.60576,-1.17789 -1.07692,-2.35576 -1.07692,-3.76923z"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <a href="<?php echo base_url() ?>inscription/etape1"><input type="button" value="M'inscrire avec mon e-mail"></a>
                    </div>
                </div>
                <hr>
                <p>Vous avez déjà un compte Ulyss ? <a href="">Connectez-vous</a></p>
            </div>
        </div>
    </div>
</div>
