<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 06/09/2018
 * Time: 17:24
 */
/* @var $BusinessEntreprise BusinessEntreprise */ ?>

<div class="modal fade ent_mod" id="visiModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h2>Présentez vos fils d'actualité Twitter - Facebook en renseignant les liens de vos pages</h2>
            <?php echo form_open('tw_fb_link') ?>
            <input type="hidden" name="id_ent" value="<?php echo $BusinessEntreprise->getId() ?>"/>
            <p>Lien Twitter : <input type="text" name="tw_link" value="<?php echo set_value('tw_link'); ?>" placeholder="Lien de votre page"></p>
            <p>Lien Facebook : <input type="text" name="fb_link" value="<?php echo set_value('fb_link'); ?>" placeholder="Lien de votre page"></p>
            <p>Lien Youtube : <input type="text" name="yt_link" value="<?php echo set_value('yt_link'); ?>" placeholder="Lien de votre vidéo"></p>
            <p>Lien Instagram : <input type="text" name="insta_link" value="<?php echo set_value('insta_link'); ?>" placeholder="Lien de votre page"></p>
            <input type="submit" value="Valider">
            <?php echo form_close() ?>
        </div>
    </div>
</div>