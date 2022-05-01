<!DOCTYPE html>
<html lang="">
<head>
   <meta charset="utf-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
   <meta name="HandheldFriendly" content="true" />
   <title>Cowanted</title>

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/animations.css" type="text/css">
   <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


   <link href="<?php echo base_url();?>assets/css/owl-carousel/owl.carousel.css" rel="stylesheet">
   <link href="<?php echo base_url();?>assets/css/owl-carousel/owl.theme.css" rel="stylesheet">


   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->
</head>
<body>

   <!-- Fixed navbar -->

<?php $this->load->view('profil/talent/nav'); ?>
   <section class="hero_home bg_recherche bg_profil" style="background:url('<?php echo $this->s3file->getUrl($this->config->item('upload_covertures').$this->user_info->getCovertureUserById($info->id));?>') ">
        <?php  if ($droir_editer){?>
      <a href="#" class="btn_change_cover" data-toggle="modal" data-target="#modalEditCoverture">Changer la couverture</a>
       <?php } ?> 
      <div class="spec-profil">
         <div class="container">
            <div class="row">
               <div class="col-md-10 col-md-offset-2">
                  <div class="row">
                     <div class="col-md-6">
                        <span class="name-spec"><?php echo $info->prenom; ?></span>
                        <p class="location_profil"><i class="ion-ios-location"></i> <?php echo $info->adresse; ?></p>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>

      </div>

      <div class="ban_info_profil">
         <div class="container">
            <div class="row">
               <div class="col-md-2 photo_profil">
                 <?php if(strpos($info->avatar, "https://") !== false){ ?>
                    <img src="<?php echo $info->avatar; ?>" alt="" width="120" height="120">
                    <?php }else{ ?>   
                     <img src="<?php echo base_url();?>image.php/<?php echo $info->avatar;?>?height=120&width=120&cropratio=1:1&image=<?php echo $this->s3file->getUrl($this->config->item('upload_avatar').$info->avatar);?>" alt="">
                    
                   <?php } ?> 

               </div>
               <div class="col-md-8 text_head_profil_talent">
                  <p><?php echo $info->presentation; ?></p>
               </div>
               
            </div>
         </div>
      </div>
   </section><!-- end hero home -->

     <?php  if ($droir_editer){?>
  <!-- modal editer coverture -->
<div class="modal fade text-center modal_home modal_form" id="modalEditCoverture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      
 <div class="modal-body">
<form method="post"  id="changeCovertureProfile">
 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

    <div class="row" >
              <?php 
               $list_coverture=$this->user_info->getListCoverture();
               foreach ($list_coverture as $cover) { 
                $active="";
                $checked="";
               if($cover->image==$this->user_info->getCovertureUser()){
                $active="active";
                $checked="checked";
               }
                ?>
               <a href="#">
                        <div class="col-md-4 coverture_item <?php echo $active; ?>">  
                         <input type="radio" name="id_coverture" class="id_coverture" value="<?php echo $cover->image;?>" <?php echo $checked; ?> >                          
                         <img src="<?php echo base_url();?>image.php/<?php echo $cover->image; ?>?height=319&width=154&cropratio=2:1&image=<?php echo $this->s3file->getUrl($this->config->item('upload_covertures').$cover->image);?>" alt="">   
                        </div> 
              </a>   
              <?php } ?>
     </div>  

      <div class="row btn_inscription ">
            <div class="col-md-10 col-md-offset-1 button_su">
            <button class="sendButtonport" type="submit">Valider</button>
            </div>
         </div>
      
      </div>
</form>
      
    </div>
  </div>
</div>

<?php } ?>


   <section class="block_resultas bg_grey">
      
      <div class="container">
         <div class="row">
            <h2 class="text-center title_h2">
               Profils
            </h2>
         </div>
         <div class="row">
         <?php foreach ($talents as $talent) {?>
            <div class="col-md-3 img_talent">
               <div class="" style="background:url(<?php echo base_url($this->config->item('upload_talents').$talent->cover);?>) center center no-repeat">
                  <a href="<?php echo base_url().$alias.'/'.$talent->alias;?>/apropos">
                  <div class="overlay_block">
                     <div class="inf">
                        <p class="name"><span><?php echo $talent->titre; ?></span><span>Cooker</span></p>
                        <p><i class="fa fa-star "></i><i class="fa fa-star "></i><i class="fa fa-star "></i><i class="fa fa-star "></i><i class="fa fa-star "></i></p>
                     </div>
                  </div>
                  </a>
               </div>
            </div>
         <?php } ?>

         </div>
      </div>
   </section>
   <section class="block_resultas">
      <div class="container">
         <div class="row">
            <h2 class="text-center title_h2">
               Commentaires (<?php echo count($commentaires_recus); ?>)
            </h2>
         </div>
         <div class="row block_item_talents">
            <div class="col-md-12 ">
               <div class="row nav_comment">
                  <ul class="col-md-10 col-md-offset-1">
                     <li class="active"><a href="#">Sur vos talents</a></li>
                     <li><a href="#">Sur vos demandes </a></li>
                  </ul>
               </div>
               <div class="row  ">
                  <div class="col-md-8 col-md-offset-2 text-left content_comment">
                     <!-- comment -->
                  <?php foreach ($commentaires_recus as $commentaire): ?>
                 <div class="row">
                    <div class="col-md-3">
                      <div class="img_comment">
                        <span class="avatar">
                   <?php if(strpos($commentaire->avatar, "https://") !== false){ ?>
                    <img src="<?php echo $commentaire->avatar; ?>" alt="" width="120" height="120">
                    <?php }else{ ?>  
                        <img src="<?php echo $this->s3file->getUrl($this->config->item('upload_avatar').$commentaire->avatar); ?>" alt="">
                     <?php } ?>
                        </span>
                      </div>
                      <p class="name_comment"><?php echo $commentaire->nom; ?> <?php echo $commentaire->prenom; ?></p>
                    </div>
                    <div class="col-md-9">
                      <div class="row mgb_15">
                        <div class="col-md-6 etoiles text-left">
                       <?php for($i=0;$i<$commentaire->note;$i++){?>
                            <i class="fa fa-star "></i>
                         <?php   } ?>
                       
                        </div>
                        <div class="col-md-6 date_comment text-right">
                          <span><?php echo strftime("%d  %B %Y",strtotime($commentaire->date_creation)); ?>, <?php echo $commentaire->titre; ?></span>
                        </div>
                      </div>
                      <div class="row ">
                        <div class="col-md-12  text-left cnt_comment">
                          <span class="quote"><i class="fa fa-quote-right"></i></span>
                          <p><?php echo $commentaire->commentaire; ?></p>
                          <p class="name_talent">Talent:  <?php echo $commentaire->titre; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>  
                  <?php endforeach ?>
                    
                  </div>   
               </div>

               <div class="row plus_comment">
                  <a href="#">Voir plus de commentaire</a>
               </div>
            </div>
         </div>
      </div>
   </section>

