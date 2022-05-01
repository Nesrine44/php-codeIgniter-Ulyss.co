'use strict';


// Declare app level module which depends on filters, and services
var app = angular.module('app', [
    'ngAnimate',
    'ngCookies',
    'ngStorage',
    'ui.router',
    'ui.bootstrap',
    'ui.load',
    'ui.jq',
    'ui.validate',
    'oc.lazyLoad',
    'pascalprecht.translate',
    'app.filters',
    'app.services',
    'app.directives',
    'app.controllers'
  ])

.run(['$rootScope', '$state', '$stateParams','$location','$http',

    function ($rootScope,$state,$stateParams,$location,$http) {
        $rootScope.$state = $state;

        $rootScope.$stateParams = $stateParams;   

        $rootScope.$on('$stateChangeStart', 
        function(event, toState, toParams, fromState, fromParams){ 
              if(toState.name!="login"){
           var path2=API_PATH+"gestion/check_session/";
                  $http.get(path2).then(function (resp) {
                  if(!resp.data.status){
                  
                  $location.path("/login");
                  } 
       
           });
         
                }

        })        
    }
  ]
)
.config(
  [          '$stateProvider', '$urlRouterProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
    function ($stateProvider,   $urlRouterProvider,   $controllerProvider,   $compileProvider,   $filterProvider,   $provide) {
        
        // lazy controller, directive and service
        app.controller = $controllerProvider.register;
        app.directive  = $compileProvider.directive;
        app.filter     = $filterProvider.register;
        app.factory    = $provide.factory;
        app.service    = $provide.service;
        app.constant   = $provide.constant;
        app.value      = $provide.value;

        $urlRouterProvider
            .otherwise('/app/dashboard-v1');
        $stateProvider
            .state('app', {
                abstract: true,
                url: '/app',
                templateUrl: 'tpl/app.html'
            })
            .state('app.dashboard-v1', {
                cache:false ,
                url: '/dashboard-v1',
                templateUrl: 'tpl/app_dashboard_v1.html'
            })
            .state('app.dashboard-v2', {
                url: '/dashboard-v2',
                templateUrl: 'tpl/app_dashboard_v2.html'
            })

            .state('app.profile', {
                url: '/profile',
                templateUrl: 'tpl/table_admin.html'
            })

            .state('app.lang', {
                url: '/lang',
                templateUrl: 'tpl/table_language.html'
            })
            .state('app.bloc', {
                url: '/bloc',
                templateUrl: 'tpl/table_blocks.html'
            })

            .state('app.secteurs', {
                url: '/secteurs',
                templateUrl: 'tpl/table_secteur.html'
            })
            .state('app.competences', {
                url: '/competences',
                templateUrl: 'tpl/competences.html'
            })
            .state('app.fonctions', {
                url: '/fonctions',
                templateUrl: 'tpl/table_fonctions.html'
            })
            .state('app.tags', {
                url: '/tags',
                templateUrl: 'tpl/table_tags.html'
            })

            .state('app.covertures', {
                url: '/covertures',
                templateUrl: 'tpl/table_covertures.html'
            })
            .state('app.temoignages', {
                url: '/temoignages',
                templateUrl: 'tpl/table_temoignage.html'
            })
            .state('app.parlents', {
                url: '/parlents',
                templateUrl: 'tpl/table_parlents.html'
            })


            .state('app.cartetype', {
                url: '/cartetype',
                templateUrl: 'tpl/table_cartetype.html'
            })

             .state('app.ville', {
                url: '/ville',
                templateUrl: 'tpl/table_ville.html'
            })

             .state('app.categoriegroupe', {
                url: '/categoriegroupe',
                templateUrl: 'tpl/table_categoriegroupe.html'
            })

             .state('app.souscategorie', {

                url: '/souscategorie/:id',

                templateUrl: 'tpl/table_souscategorie_id.html'

            })
             .state('app.departement_fonction', {

                url: '/departement_fonction/:id',

                templateUrl: 'tpl/table_departement_fonction.html'

            })

            .state('app.entreprises', {

                url: '/entreprises',

                templateUrl: 'tpl/table_entreprise.html'

            })

             .state('app.talents', {

                url: '/talents/:id',

                templateUrl: 'tpl/table_talents_id.html'

            })

              .state('app.config', {

                url: '/config',

                templateUrl: 'tpl/table_config.html'

            })
              .state('app.all_transactions', {

                url: '/all_transactions',

                templateUrl: 'tpl/all_transactions.html'

            })
              .state('app.questionnaire', {

                url: '/questionnaire',

                templateUrl: 'tpl/questionnaire.html'

            })
              .state('app.questionnairementor', {

                url: '/questionnairementor',

                templateUrl: 'tpl/questionnairementor.html'

            })


              .state('app.pages_content', {

                url: '/pages_content',

                templateUrl: 'tpl/pages_content.html'

            })
              .state('app.pages_content_detail', {

                url: '/pages_content/:id',

                templateUrl: 'tpl/pages_content_detail.html'

            })

               .state('app.users', {

                url: '/users',

                templateUrl: 'tpl/table_users.html'

            })

               .state('app.annonces', {
                url: '/annonces',
                templateUrl: 'tpl/list_annonce.html'
            })
               .state('app.coup_de_coeur', {
                url: '/coup_de_coeur',
                templateUrl: 'tpl/list_coup_de_coueur.html'
            })
            .state('app.coup_de_coeur_detail', {

                url: '/coup_de_coeur/:id',

                templateUrl: 'tpl/detail_coup_de_coeur.html'

            })
            .state('app.annonces_add', {
                url: '/annonces_add',
                templateUrl: 'tpl/annonces_add.html'
            })

            .state('app.annonces_detail', {

                url: '/annonces/:id',

                templateUrl: 'tpl/detail_annonce.html'

            })
            .state('app.utilisateur_detail', {

                url: '/utilisateur/:id',

                templateUrl: 'tpl/detail_utilisateur.html'

            })
            .state('app.utilisateur_editer', {

                url: '/utilisateur_editer/:id',

                templateUrl: 'tpl/editer_utilisateur.html'

            })
               .state('app.users_avec_anonce', {

                url: '/users_avec_anonce',

                templateUrl: 'tpl/table_users_avec_anonce.html'

            })
               .state('app.users_sans_anonce', {

                url: '/users_sans_anonce',

                templateUrl: 'tpl/table_users_sans_anonce.html'

            })

            
            .state('app.ui', {
                url: '/ui',
                template: '<div ui-view class="fade-in-up"></div>'
            })

            .state('login', {

                url: '/login',

                templateUrl: 'tpl/page_signin.html'

            })

           .state('logout', {
                url: '/logout',
                
                controller:'controller_logout' 
            })
            
          
           

          

          
    }
  ]
)

// translate config
.config(['$translateProvider', function($translateProvider){

  // Register a loader for the static files
  // So, the module will search missing translation tables under the specified urls.
  // Those urls are [prefix][langKey][suffix].
  $translateProvider.useStaticFilesLoader({
    prefix: 'l10n/',
    suffix: '.json'
  });

  // Tell the module what language to use by default
  $translateProvider.preferredLanguage('en');

  // Tell the module to store the language in the local storage
  $translateProvider.useLocalStorage();

}])

/**
 * jQuery plugin config use ui-jq directive , config the js and css files that required
 * key: function name of the jQuery plugin
 * value: array of the css js file located
 */
.constant('JQ_CONFIG', {
    easyPieChart:   ['js/jquery/charts/easypiechart/jquery.easy-pie-chart.js'],
    sparkline:      ['js/jquery/charts/sparkline/jquery.sparkline.min.js'],
    plot:           ['js/jquery/charts/flot/jquery.flot.min.js', 
                        'js/jquery/charts/flot/jquery.flot.resize.js',
                        'js/jquery/charts/flot/jquery.flot.tooltip.min.js',
                        'js/jquery/charts/flot/jquery.flot.spline.js',
                        'js/jquery/charts/flot/jquery.flot.orderBars.js',
                        'js/jquery/charts/flot/jquery.flot.pie.min.js'],
    slimScroll:     ['js/jquery/slimscroll/jquery.slimscroll.min.js'],
    sortable:       ['js/jquery/sortable/jquery.sortable.js'],
    nestable:       ['js/jquery/nestable/jquery.nestable.js',
                        'js/jquery/nestable/nestable.css'],
    filestyle:      ['js/jquery/file/bootstrap-filestyle.min.js'],
    slider:         ['js/jquery/slider/bootstrap-slider.js',
                        'js/jquery/slider/slider.css'],
    chosen:         ['js/jquery/chosen/chosen.jquery.min.js',
                        'js/jquery/chosen/chosen.css'],
    TouchSpin:      ['js/jquery/spinner/jquery.bootstrap-touchspin.min.js',
                        'js/jquery/spinner/jquery.bootstrap-touchspin.css'],
    wysiwyg:        ['js/jquery/wysiwyg/bootstrap-wysiwyg.js',
                        'js/jquery/wysiwyg/jquery.hotkeys.js'],
    dataTable:      ['js/jquery/datatables/jquery.dataTables.min.js',
                        'js/jquery/datatables/dataTables.bootstrap.js',
                        'js/jquery/datatables/dataTables.bootstrap.css'],
    vectorMap:      ['js/jquery/jvectormap/jquery-jvectormap.min.js', 
                        'js/jquery/jvectormap/jquery-jvectormap-world-mill-en.js',
                        'js/jquery/jvectormap/jquery-jvectormap-us-aea-en.js',
                        'js/jquery/jvectormap/jquery-jvectormap.css'],
    footable:       ['js/jquery/footable/footable.all.min.js',
                        'js/jquery/footable/footable.core.css']
    }
)

// modules config
.constant('MODULE_CONFIG', {
    select2:        ['js/jquery/select2/select2.css',
                        'js/jquery/select2/select2-bootstrap.css',
                        'js/jquery/select2/select2.min.js',
                        'js/modules/ui-select2.js']
    }
)

// oclazyload config
.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
    // We configure ocLazyLoad to use the lib script.js as the async loader
    $ocLazyLoadProvider.config({
        debug: false,
        events: true,
        modules: [
            {
                name: 'ngGrid',
                files: [
                    'js/modules/ng-grid/ng-grid.min.js',
                    'js/modules/ng-grid/ng-grid.css',
                    'js/modules/ng-grid/theme.css'
                ]
            },
            {
                name: 'toaster',
                files: [                    
                    'js/modules/toaster/toaster.js',
                    'js/modules/toaster/toaster.css'
                ]
            }
        ]
    });
}])
;