<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller']                      = "home";
$route['404_override']                            = '';
$route['(:any)/(:any)/apropos']                   = 'profil/apropos/$1/$2';
$route['(:any)/(:any)/autres_disciplines']        = 'profil/autres_talents/$1/$2';
$route['(:any)/profil']                           = 'profil/index/$1';
$route['employeur']                               = 'home/employeur';
$route['contact']                                 = 'home/contact';
$route['connexion/(:any)']                        = 'Auth/autologinByHash/$1';
$route['paiement/card']                           = 'paiement/card';
$route['paiement/validation']                     = 'paiement/validation';
$route['paiement/(:any)']                         = 'paiement/index/$1';
$route['compte/bienvenue']                        = 'compte/index/bienvenue';
$route['compte/confirmation']                     = 'compte/index/confirmation';
$route['recherche/get_sous_categorie']            = 'recherche/get_sous_categorie';
$route['recherche/get_list_ville']                = 'recherche/get_list_ville';
$route['recherche/comp']                          = 'recherche/comp';
$route['recherche/nomentor']                      = 'Recherche/nomentor';
$route['recherche']                               = 'recherche/searchPage';
$route['recherche/(:any)']                        = 'recherche/index/$1';
$route['translate_uri_dashes']                    = false;
$route['profil_avis/(:any)/(:any)']               = 'profil_avis/index/$1/$2';
$route['conditions-generales-d-utilisation']      = 'Mentions/cgu';
$route['politique-des-cookies']                   = 'Mentions/politique_cookies';
$route['charte-ethique']                          = 'Mentions/charte_ethique';
$route['politique-de-confidentialite']            = 'Mentions/politique_confidentialite';
$route['error/(:any)']                            = 'error/index/$1';
$route['entreprise/(:any)']                       = 'entreprise/Entreprises/apropos/$1';
$route['entreprise/(:any)/offresdemploi']         = 'entreprise/Jobs/offres/$1';
$route['create_offre']                            = 'entreprise/Jobs/createOffre';
$route['scrap_update_profil']                     = 'Update/scrap_update';
$route['scrap_update_doublon']                    = 'Update/update_doublon';
$route['update_url_to_image']                     = 'Update/url_to_image';
$route['edit']                                    = 'entreprise/jobs/edit';
$route['entreprise/(:any)/offresdemploi/(:any)']  = 'entreprise/Jobs/showOffre/$1/$2';
$route['edit_public']                             = 'entreprise/jobs/edit/edit_public';
$route['update_images']                           = 'entreprise/Upload/UploadImg';
$route['update_video']                            = 'entreprise/Upload/UploadVideo';
$route['update_background']                       = 'entreprise/Upload/addBackground';
$route['update_logo']                             = 'entreprise/Upload/addLogo';
$route['register_employeur']                      = 'entreprise/Inscription_ent/Register_ent';
$route['scrap_update_localisation_and_infos_ent'] = 'Update/scrap_localisationAndAllCompanyInfo';
$route['tw_fb_link']                              = 'entreprise/Entreprises/addTwitter_link';
$route['welcome_employeur']                       = 'entreprise/Login_ent';
$route['postuler']                                = 'entreprise/Jobs/postOffre';
$route['entreprise/(:any)/widget-company']        = 'entreprise/Entreprises/widgetGeneral/$1';
$route['entreprise/(:any)/widget-job/(:any)']     = 'entreprise/Entreprises/widgetOffre/$1/$2';
$route['UpdateMyMentorProfile']                   = 'Mentor/ProfilUpdate';
$route['inscription/etape1']                      = 'inscription/InscriptionEtape1';
$route['inscription/etape2']                      = 'Inscription/firstTime';
$route['register_done']                           = 'Inscription/firstTimeStep2';

$route['admin_entreprise'] = 'entreprise/Backoffice';

$route['inscription/insider']            = 'Inscription/inscriptionEtape1Mentor';
$route['inscription/insider-etape2']     = 'Mentor/step2MentorInscription';
$route['inscription/insider-etape3']     = 'Mentor/step3MentorInscription';
$route['inscription/insider-etape4']     = 'Mentor/step4MentorInscription';
$route['inscription/insider-validation'] = 'Mentor/addMentorInscription';


