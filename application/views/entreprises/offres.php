<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 31/07/2018
 * Time: 14:15
 */
?>
<style><?php include "/assets/css/job/job-style.css"; ?></style>
<div class="modal fade" id="jobsModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <section class="section-job1">
                <div class="row">
                    <h1>AJOUTER UNE OFFRE D'EMPLOI</h1>
                    <div class="col-md-12 col-xs-12">
                        <img src="<?php echo $BusinessEntreprise->getLogo() ?>" alt="logo-entreprise" class="logo_ent_job"></div>
                    <div class="col-md-12 col-xs-12">
                        <select name="Departement" id="">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <input type="text" name="poste" placeholder="Intitulé du poste">
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <input type="text" name="lieu" placeholder="Lieu">
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <button class="btn_srch"><a href="/create_job">Lancez-vous !</a></button>
                    </div>
                </div>
            </section>
            <section class="section-job2">
                <div class="row">
                    <h1>VOS OFFRES EN COURS</h1>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-2">
                            <button>Modifier</button>
                        </div>
                        <div class="col-md-1">
                            <button></button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
