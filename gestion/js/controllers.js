'use strict';

/* Controllers */

angular.module('app.controllers', ['pascalprecht.translate', 'ngCookies'])
	.controller('AppCtrl', ['$location', '$http', '$rootScope', '$scope', '$translate', '$localStorage', '$window',
		function ($location, $http, $rootScope, $scope, $translate, $localStorage, $window) {
			$http.get("https://ipinfo.io/").then(function (response) {
				$scope.ip = response.data.ip;

				if ($scope.ip !== undefined
					&& $scope.ip !== '195.220.8.2'
					&& $scope.ip !== '90.63.250.240'
					&& $scope.ip !== '172.16.193.209'
					&& $scope.ip !== '176.162.7.22'
					&& $scope.ip !== '77.158.70.34'
					&& $scope.ip !== '82.227.65.202'
					&& $scope.ip !== '10.208.0.110'
					&& $scope.ip !== '88.163.190.27'
					&& $scope.ip !== '84.14.157.66'
					&& $scope.ip !== '83.202.46.135'
					&& $scope.ip !== '80.215.217.51'
					&& $scope.ip !== '86.246.222.105'
				) {
				} else {
					// add 'ie' classes to html
					var isIE = !!navigator.userAgent.match(/MSIE/i);
					isIE && angular.element($window.document.body).addClass('ie');
					isSmartDevice($window) && angular.element($window.document.body).addClass('smart');

					$rootScope.nom = $localStorage.nom;

					//check session

					var path2 = API_PATH + "gestion/check_session/";
					$http.get(path2).then(function (resp) {
						if (!resp.data.status) {

							$location.path("/login");
						}

					});

					//end test session

					// config
					$scope.app = {
						name: 'Angulr',
						version: '1.3.0',
						linkapi: API_PATH,
						// for chart colors
						color: {
							primary: '#7266ba',
							info: '#23b7e5',
							success: '#27c24c',
							warning: '#fad733',
							danger: '#f05050',
							light: '#e8eff0',
							dark: '#3a3f51',
							black: '#1c2b36'
						},
						settings: {
							themeID: 1,
							navbarHeaderColor: 'bg-black',
							navbarCollapseColor: 'bg-white-only',
							asideColor: 'bg-black',
							headerFixed: true,
							asideFixed: false,
							asideFolded: false,
							asideDock: false,
							container: false
						}
					}

					// save settings to local storage
					if (angular.isDefined($localStorage.settings)) {
						$scope.app.settings = $localStorage.settings;
					} else {
						$localStorage.settings = $scope.app.settings;
					}
					$scope.$watch('app.settings', function () {
						if ($scope.app.settings.asideDock && $scope.app.settings.asideFixed) {
							// aside dock and fixed must set the header fixed.
							$scope.app.settings.headerFixed = true;
						}
						// save to local storage
						$localStorage.settings = $scope.app.settings;
					}, true);

					// angular translate
					$scope.lang       = {isopen: false};
					$scope.langs      = {en: 'English', de_DE: 'German', it_IT: 'Italian'};
					$scope.selectLang = $scope.langs[$translate.proposedLanguage()] || "English";
					$scope.setLang    = function (langKey, $event) {
						// set the current lang
						$scope.selectLang = $scope.langs[langKey];
						// You can change the language during runtime
						$translate.use(langKey);
						$scope.lang.isopen = !$scope.lang.isopen;
					};
				}
			});

			function isSmartDevice($window) {
				// Adapted from http://www.detectmobilebrowsers.com
				var ua = $window['navigator']['userAgent'] || $window['navigator']['vendor'] || $window['opera'];
				// Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
				return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
			}
		}])

	// bootstrap controller
	.controller('AccordionDemoCtrl', ['$scope', function ($scope) {
		$scope.oneAtATime = true;

		$scope.groups = [
			{
				title: 'Accordion group header - #1',
				content: 'Dynamic group body - #1'
			},
			{
				title: 'Accordion group header - #2',
				content: 'Dynamic group body - #2'
			}
		];

		$scope.items = ['Item 1', 'Item 2', 'Item 3'];

		$scope.addItem = function () {
			var newItemNo = $scope.items.length + 1;
			$scope.items.push('Item ' + newItemNo);
		};

		$scope.status = {
			isFirstOpen: true,
			isFirstDisabled: false
		};
	}])
	.controller('AlertDemoCtrl', ['$scope', function ($scope) {
		$scope.alerts = [
			{type: 'success', msg: 'Well done! You successfully read this important alert message.'},
			{type: 'info', msg: 'Heads up! This alert needs your attention, but it is not super important.'},
			{type: 'warning', msg: 'Warning! Best check yo self, you are not looking too good...'}
		];

		$scope.addAlert = function () {
			$scope.alerts.push({type: 'danger', msg: 'Oh snap! Change a few things up and try submitting again.'});
		};

		$scope.closeAlert = function (index) {
			$scope.alerts.splice(index, 1);
		};
	}])
	.controller('ButtonsDemoCtrl', ['$scope', function ($scope) {
		$scope.singleModel = 1;

		$scope.radioModel = 'Middle';

		$scope.checkModel = {
			left: false,
			middle: true,
			right: false
		};
	}])
	.controller('CarouselDemoCtrl', ['$scope', function ($scope) {
		$scope.myInterval = 5000;
		var slides        = $scope.slides = [];
		$scope.addSlide   = function () {
			slides.push({
				image: 'img/c' + slides.length + '.jpg',
				text: ['Carousel text #0', 'Carousel text #1', 'Carousel text #2', 'Carousel text #3'][slides.length % 4]
			});
		};
		for (var i = 0; i < 4; i++) {
			$scope.addSlide();
		}
	}])
	.controller('DropdownDemoCtrl', ['$scope', function ($scope) {
		$scope.items = [
			'The first choice!',
			'And another choice for you.',
			'but wait! A third!'
		];

		$scope.status = {
			isopen: false
		};

		$scope.toggled = function (open) {
			//console.log('Dropdown is now: ', open);
		};

		$scope.toggleDropdown = function ($event) {
			$event.preventDefault();
			$event.stopPropagation();
			$scope.status.isopen = !$scope.status.isopen;
		};
	}])
	.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', 'items', function ($scope, $modalInstance, items) {
		$scope.items    = items;
		$scope.selected = {
			item: $scope.items[0]
		};

		$scope.ok = function () {
			$modalInstance.close($scope.selected.item);
		};

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	}])
	.controller('ModalDemoCtrl', ['$scope', '$modal', '$log', function ($scope, $modal, $log) {
		$scope.items = ['item1', 'item2', 'item3'];
		$scope.open  = function (size) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalContent.html',
				controller: 'ModalInstanceCtrl',
				size: size,
				resolve: {
					items: function () {
						return $scope.items;
					}
				}
			});

			modalInstance.result.then(function (selectedItem) {
				$scope.selected = selectedItem;
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		};
	}])
	.controller('PaginationDemoCtrl', ['$scope', '$log', function ($scope, $log) {
		$scope.totalItems  = 64;
		$scope.currentPage = 4;

		$scope.setPage = function (pageNo) {
			$scope.currentPage = pageNo;
		};

		$scope.pageChanged = function () {
			$log.info('Page changed to: ' + $scope.currentPage);
		};

		$scope.maxSize        = 5;
		$scope.bigTotalItems  = 175;
		$scope.bigCurrentPage = 1;
	}])
	.controller('PopoverDemoCtrl', ['$scope', function ($scope) {
		$scope.dynamicPopover      = 'Hello, World!';
		$scope.dynamicPopoverTitle = 'Title';
	}])
	.controller('ProgressDemoCtrl', ['$scope', function ($scope) {
		$scope.max = 200;

		$scope.random = function () {
			var value = Math.floor((Math.random() * 100) + 1);
			var type;

			if (value < 25) {
				type = 'success';
			} else if (value < 50) {
				type = 'info';
			} else if (value < 75) {
				type = 'warning';
			} else {
				type = 'danger';
			}

			$scope.showWarning = (type === 'danger' || type === 'warning');

			$scope.dynamic = value;
			$scope.type    = type;
		};
		$scope.random();

		$scope.randomStacked = function () {
			$scope.stacked = [];
			var types      = ['success', 'info', 'warning', 'danger'];

			for (var i = 0, n = Math.floor((Math.random() * 4) + 1); i < n; i++) {
				var index = Math.floor((Math.random() * 4));
				$scope.stacked.push({
					value: Math.floor((Math.random() * 30) + 1),
					type: types[index]
				});
			}
		};
		$scope.randomStacked();
	}])
	.controller('TabsDemoCtrl', ['$scope', function ($scope) {
		$scope.tabs = [
			{title: 'Dynamic Title 1', content: 'Dynamic content 1'},
			{title: 'Dynamic Title 2', content: 'Dynamic content 2', disabled: true}
		];
	}])
	.controller('RatingDemoCtrl', ['$scope', function ($scope) {
		$scope.rate       = 7;
		$scope.max        = 10;
		$scope.isReadonly = false;

		$scope.hoveringOver = function (value) {
			$scope.overStar = value;
			$scope.percent  = 100 * (value / $scope.max);
		};
	}])
	.controller('TooltipDemoCtrl', ['$scope', function ($scope) {
		$scope.dynamicTooltip     = 'Hello, World!';
		$scope.dynamicTooltipText = 'dynamic';
		$scope.htmlTooltip        = 'I\'ve been made <b>bold</b>!';
	}])
	.controller('TypeaheadDemoCtrl', ['$scope', '$http', function ($scope, $http) {
		$scope.selected    = undefined;
		$scope.states      = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
		// Any function returning a promise object can be used to load values asynchronously
		$scope.getLocation = function (val) {
			return $http.get('http://maps.googleapis.com/maps/api/geocode/json', {
				params: {
					address: val,
					sensor: false
				}
			}).then(function (res) {
				var addresses = [];
				angular.forEach(res.data.results, function (item) {
					addresses.push(item.formatted_address);
				});
				return addresses;
			});
		};
	}])
	.controller('DatepickerDemoCtrl', ['$scope', function ($scope) {
		$scope.today = function () {
			$scope.dt = new Date();
		};
		$scope.today();

		$scope.clear = function () {
			$scope.dt = null;
		};

		// Disable weekend selection
		$scope.disabled = function (date, mode) {
			return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
		};

		$scope.toggleMin = function () {
			$scope.minDate = $scope.minDate ? null : new Date();
		};
		$scope.toggleMin();

		$scope.open = function ($event) {
			$event.preventDefault();
			$event.stopPropagation();

			$scope.opened = true;
		};

		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 1,
			class: 'datepicker'
		};

		$scope.initDate = new Date('2016-15-20');
		$scope.formats  = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
		$scope.format   = $scope.formats[2];
	}])
	.controller('TimepickerDemoCtrl', ['$scope', function ($scope) {
		$scope.mytime = new Date();

		$scope.hstep = 1;
		$scope.mstep = 15;

		$scope.options = {
			hstep: [1, 2, 3],
			mstep: [1, 5, 10, 15, 25, 30]
		};

		$scope.ismeridian = true;
		$scope.toggleMode = function () {
			$scope.ismeridian = !$scope.ismeridian;
		};

		$scope.update = function () {
			var d = new Date();
			d.setHours(14);
			d.setMinutes(0);
			$scope.mytime = d;
		};

		$scope.changed = function () {
			//console.log('Time changed to: ' + $scope.mytime);
		};

		$scope.clear = function () {
			$scope.mytime = null;
		};
	}])

	// Form controller
	.controller('FormDemoCtrl', ['$scope', function ($scope) {
		$scope.notBlackListed = function (value) {
			var blacklist = ['bad@domain.com', 'verybad@domain.com'];
			return blacklist.indexOf(value) === -1;
		}

		$scope.val      = 15;
		var updateModel = function (val) {
			$scope.$apply(function () {
				$scope.val = val;
			});
		};
		angular.element("#slider").on('slideStop', function (data) {
			updateModel(data.value);
		});

		$scope.select2Number = [
			{text: 'First', value: 'One'},
			{text: 'Second', value: 'Two'},
			{text: 'Third', value: 'Three'}
		];

		$scope.list_of_string = ['tag1', 'tag2']
		$scope.select2Options = {
			'multiple': true,
			'simple_tags': true,
			'tags': ['tag1', 'tag2', 'tag3', 'tag4']  // Can be empty list.
		};

	}])
	.filter("trust", ['$sce', function ($sce) {
		return function (htmlCode) {
			return $sce.trustAsHtml(htmlCode);
		}
	}])
	// Flot Chart controller
	.controller('FlotChartDemoCtrl', ['$scope', '$http', function ($scope, $http) {
		$http.get(API_PATH + 'gestion/visiteurs')
			.then(function (response) {
				if (response.data) {
					$scope.nbr_candidat        = response.data.candidats;
					$scope.nbr_talent          = response.data.talents;
					$scope.nbr_demandes        = response.data.demandes;
					$scope.nbr_demandes_valids = response.data.demandes_valids;

				}
			}, function (x) {
			});
		$scope.filtre     = {};
		$scope.gotofiltre = function () {
			$scope.filtre.date1 = $scope.dt;
			$scope.filtre.date2 = $scope.dt2;
			$http.post(API_PATH + 'gestion/visiteurs_periode', $scope.filtre)
				.then(function (response) {
					if (response.data) {
						$scope.nbr_candidat        = response.data.candidats;
						$scope.nbr_talent          = response.data.talents;
						$scope.nbr_demandes        = response.data.demandes;
						$scope.nbr_demandes_valids = response.data.demandes_valids;
					}
				}, function (x) {
				});
		};

		$scope.today = function () {
			$scope.dt = new Date();
		};
		$scope.today();

		$scope.clear = function () {
			$scope.dt = null;
		};

		// Disable weekend selection
		$scope.disabled = function (date, mode) {
			return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
		};

		$scope.toggleMin = function () {
			$scope.minDate = $scope.minDate ? null : new Date();
		};
		$scope.toggleMin();

		$scope.open        = function ($event) {
			$event.preventDefault();
			$event.stopPropagation();

			$scope.opened = true;
		};
		$scope.open1       = function ($event) {
			$event.preventDefault();
			$event.stopPropagation();

			$scope.opened1 = true;
		};
		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 1,
			class: 'datepicker'
		};

		$scope.initDate = new Date('2016-15-20');
		$scope.formats  = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
		$scope.format   = $scope.formats[2];


	}])

	// jVectorMap controller
	.controller('JVectorMapDemoCtrl', ['$scope', function ($scope) {
		$scope.world_markers = [
			{latLng: [41.90, 12.45], name: 'Vatican City'},
			{latLng: [43.73, 7.41], name: 'Monaco'},
			{latLng: [-0.52, 166.93], name: 'Nauru'},
			{latLng: [-8.51, 179.21], name: 'Tuvalu'},
			{latLng: [43.93, 12.46], name: 'San Marino'},
			{latLng: [47.14, 9.52], name: 'Liechtenstein'},
			{latLng: [7.11, 171.06], name: 'Marshall Islands'},
			{latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
			{latLng: [3.2, 73.22], name: 'Maldives'},
			{latLng: [35.88, 14.5], name: 'Malta'},
			{latLng: [12.05, -61.75], name: 'Grenada'},
			{latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
			{latLng: [13.16, -59.55], name: 'Barbados'},
			{latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
			{latLng: [-4.61, 55.45], name: 'Seychelles'},
			{latLng: [7.35, 134.46], name: 'Palau'},
			{latLng: [42.5, 1.51], name: 'Andorra'},
			{latLng: [14.01, -60.98], name: 'Saint Lucia'},
			{latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
			{latLng: [1.3, 103.8], name: 'Singapore'},
			{latLng: [1.46, 173.03], name: 'Kiribati'},
			{latLng: [-21.13, -175.2], name: 'Tonga'},
			{latLng: [15.3, -61.38], name: 'Dominica'},
			{latLng: [-20.2, 57.5], name: 'Mauritius'},
			{latLng: [26.02, 50.55], name: 'Bahrain'},
			{latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
		];

		$scope.usa_markers = [
			{latLng: [40.71, -74.00], name: 'New York'},
			{latLng: [34.05, -118.24], name: 'Los Angeles'},
			{latLng: [41.87, -87.62], name: 'Chicago'},
			{latLng: [29.76, -95.36], name: 'Houston'},
			{latLng: [39.95, -75.16], name: 'Philadelphia'},
			{latLng: [38.90, -77.03], name: 'Washington'},
			{latLng: [37.36, -122.03], name: 'Silicon Valley'}
		];
	}])



	//controller Questionnaire
	.controller('QuestionnaireController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {

	}])
	//controller Questionnaire Mentor
	.controller('QuestionnaireMentorController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {

	}])

	//controller Talent
	.controller('TalentController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {

		$scope.user_id = $stateParams.id;

		$scope.desactiver_talent = function (id) {

			$http.post(API_PATH + 'gestion/desactiver_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};
		$scope.ajouter_coup      = function (id) {
			$http.post(API_PATH + 'gestion/ajouter_coup', {id: id})
				.then(function (response) {
					if (response.data.status) {
						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
					}
				}, function (x) {
				});
		};
		$scope.delete_coup       = function (id) {
			$http.post(API_PATH + 'gestion/delete_coup', {id: id})
				.then(function (response) {
					if (response.data.status) {
						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
					}
				}, function (x) {
				});
		};
		$scope.activer_talent    = function (id) {

			$http.post(API_PATH + 'gestion/activer_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.users = {};

						$scope.users.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/users_delete', $scope.users)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


	}])


	/*utilisateur detail*/
	.controller('utilisateurController', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.cancel = function () {
			$state.go("app.users");
		};

		$scope.utilisateur = {};

		if ($stateParams.id != undefined) {
			var id_user = $stateParams.id;
			var path    = API_PATH + "gestion/GetInfoUsers/" + id_user;

			$http.get(path).then(function (resp) {
				$scope.utilisateur.nom            = resp.data.reponse.nom;
				$scope.utilisateur.sexe           = resp.data.reponse.sexe;
				$scope.utilisateur.prenom         = resp.data.reponse.prenom;
				$scope.utilisateur.email          = resp.data.reponse.email;
				$scope.utilisateur.tel            = resp.data.reponse.tel;
				$scope.utilisateur.date_naissance = resp.data.reponse.date_naissance;
				$scope.utilisateur.adresse        = resp.data.reponse.adresse;
				$scope.utilisateur.date_creation  = resp.data.reponse.date_creation;
				$scope.utilisateur.avatar         = resp.data.reponse.avatar;
				$scope.utilisateur.biographie     = resp.data.reponse.biographie;

				$scope.utilisateur.id      = resp.data.reponse.id;
				$scope.utilisateur.baseurl = base_url;
			});
		}

		$scope.enregistrer = function () {
			$http.post(API_PATH + 'gestion/editer_user', $scope.utilisateur)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifiés.";

					}
				}, function (x) {

				});

		};


	}])

	//end controller talent
	////ANNNONCES////////
	.controller('AnnoncesController', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {

		$scope.supprimerCoup     = function (id) {

			$http.post(API_PATH + 'gestion/coup_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};
		$scope.desactiver_talent = function (id) {

			$http.post(API_PATH + 'gestion/desactiver_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};
		$scope.changeStatut      = function () {
			$http.post(API_PATH + 'gestion/statut_admin', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifier";
					}

				}, function (x) {

				});
		};

		$scope.Accepter = function () {
			$http.post(API_PATH + 'gestion/statut_admin_accepter', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifier";
					}

				}, function (x) {

				});

			//$modalInstance.close();

		};
		$scope.cancel   = function () {
			$state.go("app.annonces");
		};
		$scope.cancel1  = function () {
			$state.go("app.coup_de_coeur");
		};

		$scope.Refuser = function () {
			$http.post(API_PATH + 'gestion/statut_admin_refuser', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifier";
					}

				}, function (x) {

				});

			//$modalInstance.close();

		};
		if ($stateParams.id != undefined) {
			var id_annonce = $stateParams.id;
			var path       = API_PATH + "gestion/annonces_one/" + id_annonce;

			$http.get(path).then(function (resp) {
				$scope.annonce     = resp.data.annonce;
				$scope.tags        = resp.data.tags;
				$scope.formations  = resp.data.formations;
				$scope.experiences = resp.data.experiences;
				$scope.langues     = resp.data.langues;
				$scope.portfolio   = resp.data.portfolio;
				$scope.documents   = resp.data.documents;
				$scope.disponibles = resp.data.disponibles;
			});
		}
		$scope.ajouter_coup   = function (id) {
			$http.post(API_PATH + 'gestion/ajouter_coup', {id: id})
				.then(function (response) {
					if (response.data.status) {
						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
					}
				}, function (x) {
				});
		};
		$scope.delete_coup    = function (id) {
			$http.post(API_PATH + 'gestion/delete_coup', {id: id})
				.then(function (response) {
					if (response.data.status) {
						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
					}
				}, function (x) {
				});
		};
		$scope.activer_talent = function (id) {

			$http.post(API_PATH + 'gestion/activer_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.users = {};

						$scope.users.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/talent_delete', $scope.users)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


//////////////change photos///
		$scope.changePhoto = function () {
			if ($scope.myFile != undefined) {
				var file      = $scope.myFile;
				var uploadUrl = API_PATH + "gestion/add_file_talent";
				fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {
					$scope.annonce.photo_coup_de_coeur = data.file;
					$http.post(API_PATH + 'gestion/photo_coeur_talent', $scope.annonce)
						.then(function (response) {
							if (response.data.status) {
								$scope.sucess = "La photo de coup de coeur a été modifiée.";

							}
						}, function (x) {

						});

				});


			}
		};


	}])

	.controller('AnnoncesControllerAdd', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {

		$scope.addAnnonce = function () {
			$scope.annonce.formations  = $scope.formationlist;
			$scope.annonce.experience  = $scope.experiencelist;
			$scope.annonce.competences = $scope.taglist;

			$http.post(API_PATH + 'gestion/add_annonce', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Le profil a été a ajouter";
					}

				}, function (x) {

				});
		};
		var users         = API_PATH + "gestion/users";
		$http.get(users).then(function (resp) {
			$scope.users = resp.data.data;
		});

		var tags = API_PATH + "gestion/tags";
		$http.get(tags).then(function (resp) {
			$scope.tags = resp.data.data;
		});
		var entreprise = API_PATH + "gestion/entreprises";
		$http.get(entreprise).then(function (resp) {
			$scope.entreprise = resp.data.data;
		});
		var secteurs = API_PATH + "gestion/secteurs";
		$http.get(secteurs).then(function (resp) {
			$scope.secteurs = resp.data.data;
		});
		var fonctions_url = API_PATH + "gestion/fonctions";
		$http.get(fonctions_url).then(function (resp) {
			$scope.fonctions = resp.data.aaData;
		});
		var departements_url = API_PATH + "gestion/groupecategorie1";
		$http.get(departements_url).then(function (resp) {
			$scope.departements = resp.data.data;
		});

		$scope.taglist        = [];
		$scope.formationlist  = [];
		$scope.experiencelist = [];
		$scope.updateComp     = function () {
			console.log($scope.selectedItem);
			$scope.taglist.push($scope.selectedItem);
			// use $scope.selectedItem.code and $scope.selectedItem.name here
			// for other stuff ...
		}
		$scope.formations     = {};
		$scope.experience     = {};

		$scope.today = function () {
			$scope.experience.date_debut = new Date();
		};
		$scope.today();

		$scope.clear = function () {
			$scope.formations.date_debut = null;
		};

		// Disable weekend selection
		$scope.disabled = function (date, mode) {
			return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
		};

		$scope.toggleMin = function () {
			$scope.minDate = $scope.minDate ? null : new Date();
		};
		$scope.toggleMin();

		$scope.open        = function ($event) {
			$event.preventDefault();
			$event.stopPropagation();

			$scope.opened = true;
		};
		$scope.open1       = function ($event) {
			$event.preventDefault();
			$event.stopPropagation();

			$scope.opened1 = true;
		};
		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 1,
			class: 'datepicker'
		};

		$scope.initDate = new Date('2016-15-20');
		$scope.formats  = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
		$scope.format   = $scope.formats[2];


		$scope.addformation      = function () {
			$scope.formationlist.push($scope.formations);
			$scope.formations = {};
		}
		$scope.addExperience     = function () {
			$scope.experiencelist.push($scope.experience);
			$scope.experience = {};
		}
		$scope.supprimerCoup     = function (id) {

			$http.post(API_PATH + 'gestion/coup_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};
		$scope.desactiver_talent = function (id) {

			$http.post(API_PATH + 'gestion/desactiver_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};
		$scope.changeStatut      = function () {
			$http.post(API_PATH + 'gestion/statut_admin', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifier";
					}

				}, function (x) {

				});
		};

		$scope.Accepter = function () {
			$http.post(API_PATH + 'gestion/statut_admin_accepter', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifier";
					}

				}, function (x) {

				});

			//$modalInstance.close();

		};
		$scope.cancel   = function () {
			$state.go("app.annonces");
		};
		$scope.cancel1  = function () {
			$state.go("app.coup_de_coeur");
		};

		$scope.Refuser = function () {
			$http.post(API_PATH + 'gestion/statut_admin_refuser', $scope.annonce)
				.then(function (response) {
					if (response.data.status) {
						$scope.sucess = "Les informations a été modifier";
					}

				}, function (x) {

				});

			//$modalInstance.close();

		};
		if ($stateParams.id != undefined) {
			var id_annonce = $stateParams.id;
			var path       = API_PATH + "gestion/annonces_one/" + id_annonce;

			$http.get(path).then(function (resp) {
				$scope.annonce     = resp.data.annonce;
				$scope.tags        = resp.data.tags;
				$scope.langues     = resp.data.langues;
				$scope.portfolio   = resp.data.portfolio;
				$scope.documents   = resp.data.documents;
				$scope.disponibles = resp.data.disponibles;
			});
		}
		$scope.ajouter_coup   = function (id) {
			$http.post(API_PATH + 'gestion/ajouter_coup', {id: id})
				.then(function (response) {
					if (response.data.status) {
						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
					}
				}, function (x) {
				});
		};
		$scope.delete_coup    = function (id) {
			$http.post(API_PATH + 'gestion/delete_coup', {id: id})
				.then(function (response) {
					if (response.data.status) {
						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
					}
				}, function (x) {
				});
		};
		$scope.activer_talent = function (id) {

			$http.post(API_PATH + 'gestion/activer_talent', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.users = {};

						$scope.users.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/talent_delete', $scope.users)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


//////////////change photos///
		$scope.changePhoto = function () {
			if ($scope.myFile != undefined) {
				var file      = $scope.myFile;
				var uploadUrl = API_PATH + "gestion/add_file_talent";
				fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {
					$scope.annonce.photo_coup_de_coeur = data.file;
					$http.post(API_PATH + 'gestion/photo_coeur_talent', $scope.annonce)
						.then(function (response) {
							if (response.data.status) {
								$scope.sucess = "La photo de coup de coeur a été modifiée.";

							}
						}, function (x) {

						});

				});


			}
		};


	}])



	//controller users
	.controller('UsersController', ['$scope', '$location', '$http', '$state', '$modal', '$stateParams', function ($scope, $location, $http, $state, $modal, $stateParams) {

		$scope.detail = function (id, alias) {
			window.open(base_url + alias + "/profil");
			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.users = {};

						var path1 = API_PATH + "gestion/GetInfoUsers/" + id;

						$http.get(path1).then(function (resp) {

							$scope.users.nom            = resp.data.reponse.nom;
							$scope.users.prenom         = resp.data.reponse.prenom;
							$scope.users.email          = resp.data.reponse.email;
							$scope.users.tel            = resp.data.reponse.tel;
							$scope.users.date_naissance = resp.data.reponse.date_naissance;
							$scope.users.adresse        = resp.data.reponse.adresse;
							$scope.users.date_creation  = resp.data.reponse.date_creation;
							$scope.users.avatar         = resp.data.reponse.avatar;

							$scope.users.id      = id;
							$scope.users.baseurl = base_url;

						});


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.desactiver = function (id) {

			$http.post(API_PATH + 'gestion/desactiver', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};

		$scope.activer = function (id) {

			$http.post(API_PATH + 'gestion/activer', {id: id})


				.then(function (response) {

					if (response.data.status) {


						$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

					}

				}, function (x) {


				});


		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.users = {};

						$scope.users.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/users_delete', $scope.users)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


	}])
	//end controller user


	.controller('ConfigController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {

		//editor
		$scope.ckEditors = [];
		$scope.addEditor = function () {
			var rand = "" + (Math.random() * 10000);
			$scope.ckEditors.push({value: rand});
		}
//
		$scope.editer    = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.conf = {};

						var path1 = API_PATH + "gestion/GetInfoConfig/" + id;

						$http.get(path1).then(function (resp) {

							$scope.conf.nom   = resp.data.reponse.name;
							$scope.conf.alias = resp.data.reponse.alias;
							$scope.conf.type  = resp.data.reponse.type;
							$scope.conf.value = resp.data.reponse.value;


							$scope.conf.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_config', $scope.conf)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};
		$scope.editer1   = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent1.html',

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.conf = {};

						var path1 = API_PATH + "gestion/GetInfoConfig/" + id;

						$http.get(path1).then(function (resp) {

							$scope.conf.nom   = resp.data.reponse.name;
							$scope.conf.alias = resp.data.reponse.alias;
							$scope.conf.type  = resp.data.reponse.type;
							$scope.conf.value = resp.data.reponse.value;


							$scope.conf.id = id;


						});


						$scope.ok = function () {
							$scope.conf.value = document.getElementById('content_html').innerHTML;

							$http.post(API_PATH + 'gestion/editer_config', $scope.conf)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//end controller config


	//controller souscategorie (table categorie)
	.controller('souscategorieController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {

		$scope.categorie_group_id = $stateParams.id;

		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.souscategorie = {};

						$scope.souscategorie.nom      = '';
						$scope.souscategorie.active   = '';
						$scope.souscategorie.fonction = $stateParams.id;

						var path1 = API_PATH + "gestion/fonctions/";
						$http.get(path1).then(function (resp) {
							$scope.fonctions = resp.data.aaData;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_departement_fonction', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.souscategorie = {};

						$scope.souscategorie.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/departement_fonction_delete', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.souscategorie = {};

						var path1 = API_PATH + "gestion/GetInfoSousCategorie/" + id;

						$http.get(path1).then(function (resp) {

							$scope.souscategorie.nom    = resp.data.reponse.nom;
							$scope.souscategorie.active = resp.data.reponse.active;


							$scope.souscategorie.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_souscategorie', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//end controller souscategorie

	//////groupecategorie
	/////////departement fonction
	.controller('departementFonctionCtrl', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {

		$scope.fonction_id = $stateParams.id;

		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.souscategorie = {};

						$scope.souscategorie.nom            = '';
						$scope.souscategorie.active         = '';
						$scope.souscategorie.fonction       = '';
						$scope.souscategorie.departement_id = $stateParams.id;
						var path1                           = API_PATH + "gestion/groupecategorie1/";
						$http.get(path1).then(function (resp) {
							$scope.fonctions = resp.data.data;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_departement_fonction', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.souscategorie = {};

						$scope.souscategorie.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/departement_fonction_delete', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.souscategorie = {};

						var path1 = API_PATH + "gestion/GetInfoSousCategorie/" + id;

						$http.get(path1).then(function (resp) {

							$scope.souscategorie.nom    = resp.data.reponse.nom;
							$scope.souscategorie.active = resp.data.reponse.active;


							$scope.souscategorie.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_souscategorie', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])

	.controller('GroupecategorieController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.groupecategorie = {};

						$scope.groupecategorie.nom    = '';
						$scope.groupecategorie.photo  = '';
						$scope.groupecategorie.desc   = '';
						$scope.groupecategorie.active = '';

						$scope.groupecategorie.id = 0;
						var path1                 = API_PATH + "gestion/fonctions/";
						$http.get(path1).then(function (resp) {
							$scope.fonctions = resp.data.aaData;
						});
						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.groupecategorie = {};

						$scope.groupecategorie.id = id;

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/groupecategorie_delete', $scope.groupecategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',
				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},
					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.groupecategorie = {};

						var path1 = API_PATH + "gestion/GetInfoGroupeCategorie/" + id;

						$http.get(path1).then(function (resp) {

							$scope.edit = 1;

							$scope.groupecategorie.nom          = resp.data.reponse.nom;
							$scope.groupecategorie.desc         = resp.data.reponse.desc;
							$scope.groupecategorie.active       = resp.data.reponse.active;
							$scope.groupecategorie.photo        = resp.data.reponse.image;
							$scope.groupecategorie.affiche_home = resp.data.reponse.affiche_home;
							$scope.groupecategorie.id           = id;


						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_groupecategorie', $scope.groupecategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])


	.controller('ControllerAddGalerie_groupecategorie', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.ok = function () {

			var file = $scope.myFile;

			if ($scope.myFile != undefined) {

				if ($scope.groupecategorie.id == 0) {


					var uploadUrl = API_PATH + "gestion/add_file";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.groupecategorie.photo = data.file;


						$http.post(API_PATH + 'gestion/ajouter_data_groupecategorie', $scope.groupecategorie)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				} else {


					var uploadUrl = API_PATH + "gestion/add_file";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.groupecategorie.photo = data.file;
						$http.post(API_PATH + 'gestion/editer_groupecategorie', $scope.groupecategorie)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								} else {

									$scope.$parent.cancel();

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				}

			} else {

				if ($scope.groupecategorie.id == 0) {


					$scope.groupecategorie.photo = "";

					$http.post(API_PATH + 'gestion/ajouter_data_groupecategorie', $scope.groupecategorie)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				} else {


					$http.post(API_PATH + 'gestion/editer_groupecategorie', $scope.groupecategorie)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							} else {

								$scope.$parent.cancel();

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				}

			}

		};

	}])



	/////////end groupecategorie

	.controller('ParlentsController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.temoin = {};


						$scope.temoin.photo = '';
						$scope.temoin.type  = 'reussir_mon_entretien';


						$scope.temoin.id = 0;

						console.log($scope.temoin.id);

						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.temoin = {};

						$scope.temoin.id = id;

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/parlent_delete', $scope.temoin)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',
				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},
					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.temoin = {};

						var path1 = API_PATH + "gestion/GetInfoParlent/" + id;

						$http.get(path1).then(function (resp) {

							$scope.edit         = 1;
							$scope.temoin.photo = resp.data.reponse.image;
							$scope.temoin.link  = resp.data.reponse.link;
							$scope.temoin.type  = resp.data.reponse.type;
							$scope.temoin.titre = resp.data.reponse.titre;
							$scope.temoin.id    = id;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_couvertures', $scope.covertures)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])

	/*temoignages */
	.controller('EntrepriseController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					}

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.entreprise = {};


						$scope.entreprise.photo = '';
						$scope.entreprise.nom   = '';


						$scope.entreprise.id = 0;

						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.entreprise = {};

						$scope.entreprise.id = id;

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/entreprise_delete', $scope.entreprise)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',
				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},
					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.entreprise = {};

						var path1 = API_PATH + "gestion/GetInfoEntreprise/" + id;

						$http.get(path1).then(function (resp) {

							$scope.edit             = 1;
							$scope.entreprise.photo = resp.data.reponse.logo;
							$scope.entreprise.nom   = resp.data.reponse.nom;
							$scope.entreprise.id    = id;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_entreprise', $scope.entreprise)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])

	//////CoverturesController
	.controller('TemoignagesController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.temoin = {};


						$scope.temoin.photo = '';
						$scope.temoin.type  = 'reussir_mon_entretien';


						$scope.temoin.id = 0;

						console.log($scope.temoin.id);

						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.temoin = {};

						$scope.temoin.id = id;

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/temoin_delete', $scope.temoin)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',
				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},
					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.temoin = {};

						var path1 = API_PATH + "gestion/GetInfoTemoin/" + id;

						$http.get(path1).then(function (resp) {

							$scope.edit               = 1;
							$scope.temoin.photo       = resp.data.reponse.image;
							$scope.temoin.user        = resp.data.reponse.user;
							$scope.temoin.type        = resp.data.reponse.type;
							$scope.temoin.titre       = resp.data.reponse.titre;
							$scope.temoin.description = resp.data.reponse.description;
							$scope.temoin.id          = id;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_couvertures', $scope.covertures)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	.controller('BlocksController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.temoin = {};


						$scope.temoin.photo = '';


						$scope.temoin.id = 0;

						console.log($scope.temoin.id);

						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.temoin = {};

						$scope.temoin.id = id;

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/bloc_delete', $scope.temoin)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',
				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},
					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.temoin = {};

						var path1 = API_PATH + "gestion/GetInfoBloc/" + id;

						$http.get(path1).then(function (resp) {

							$scope.edit         = 1;
							$scope.temoin.photo = resp.data.reponse.image;


							$scope.temoin.titre       = resp.data.reponse.titre;
							$scope.temoin.description = resp.data.reponse.description;
							$scope.temoin.id          = id;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_couvertures', $scope.covertures)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])

	.controller('CoverturesController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.covertures = {};


						$scope.covertures.photo = '';


						$scope.covertures.id = 0;

						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.covertures = {};

						$scope.covertures.id = id;

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/couvertures_delete', $scope.covertures)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',
				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},
					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.covertures = {};

						var path1 = API_PATH + "gestion/GetInfoCouvertures/" + id;

						$http.get(path1).then(function (resp) {

							$scope.edit = 1;


							$scope.covertures.photo = resp.data.reponse.image;
							$scope.covertures.id    = id;


						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_couvertures', $scope.covertures)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	/*add edit temoignages*/
	.controller('CtrlAddEditTemoin', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.ok = function () {

			var file = $scope.myFile;

			if ($scope.myFile != undefined) {

				if ($scope.temoin.id == 0) {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;
					var uploadUrl             = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.temoin.photo = data.file;


						$http.post(API_PATH + 'gestion/ajouter_data_temoin', $scope.temoin)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				} else {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;
					var uploadUrl             = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.temoin.photo = data.file;
						$http.post(API_PATH + 'gestion/editer_temoin', $scope.temoin)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								} else {

									$scope.$parent.cancel();

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				}

			} else {

				if ($scope.temoin.id == 0) {


					$scope.temoin.photo       = "";
					$scope.temoin.description = document.getElementById('content_html').innerHTML;

					$http.post(API_PATH + 'gestion/ajouter_data_temoin', $scope.temoin)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				} else {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;


					$http.post(API_PATH + 'gestion/editer_temoin', $scope.temoin)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							} else {

								$scope.$parent.cancel();

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				}

			}

		};

	}])

	.controller('CtrlAddEditBloc', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.ok = function () {

			var file = $scope.myFile;

			if ($scope.myFile != undefined) {

				if ($scope.temoin.id == 0) {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;
					var uploadUrl             = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.temoin.photo = data.file;


						$http.post(API_PATH + 'gestion/ajouter_data_bloc', $scope.temoin)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				} else {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;
					var uploadUrl             = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.temoin.photo = data.file;
						$http.post(API_PATH + 'gestion/editer_temoin', $scope.temoin)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								} else {

									$scope.$parent.cancel();

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				}

			} else {

				if ($scope.temoin.id == 0) {


					$scope.temoin.photo       = "";
					$scope.temoin.description = document.getElementById('content_html').innerHTML;

					$http.post(API_PATH + 'gestion/ajouter_data_bloc', $scope.temoin)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				} else {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;


					$http.post(API_PATH + 'gestion/editer_bloc', $scope.temoin)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							} else {

								$scope.$parent.cancel();

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				}

			}

		};

	}])

	.controller('CtrlAddEditEntreprise', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.ok = function () {

			var file = $scope.myFile;

			if ($scope.myFile != undefined) {

				if ($scope.entreprise.id == 0) {


					var uploadUrl = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.entreprise.photo = data.file;


						$http.post(API_PATH + 'gestion/ajouter_data_entreprise', $scope.entreprise)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});
				} else {
					var uploadUrl = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.entreprise.photo = data.file;
						$http.post(API_PATH + 'gestion/editer_entreprise', $scope.entreprise)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								} else {

									$scope.$parent.cancel();

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				}

			} else {

				if ($scope.entreprise.id == 0) {


					$scope.entreprise.photo = "";


					$http.post(API_PATH + 'gestion/ajouter_data_entreprise', $scope.entreprise)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				} else {
					$http.post(API_PATH + 'gestion/editer_entreprise', $scope.entreprise)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							} else {

								$scope.$parent.cancel();

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				}

			}

		};

	}])
	.controller('CtrlAddEditParlent', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.ok = function () {

			var file = $scope.myFile;

			if ($scope.myFile != undefined) {

				if ($scope.temoin.id == 0) {


					var uploadUrl = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.temoin.photo = data.file;


						$http.post(API_PATH + 'gestion/ajouter_data_parlent', $scope.temoin)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				} else {


					var uploadUrl = API_PATH + "gestion/add_file_temoin";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.temoin.photo = data.file;
						$http.post(API_PATH + 'gestion/editer_parlent', $scope.temoin)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								} else {

									$scope.$parent.cancel();

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				}

			} else {

				if ($scope.temoin.id == 0) {


					$scope.temoin.photo       = "";
					$scope.temoin.description = document.getElementById('content_html').innerHTML;

					$http.post(API_PATH + 'gestion/ajouter_data_parlent', $scope.temoin)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				} else {

					$scope.temoin.description = document.getElementById('content_html').innerHTML;


					$http.post(API_PATH + 'gestion/editer_parlent', $scope.temoin)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							} else {

								$scope.$parent.cancel();

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				}

			}

		};

	}])

	.controller('ControllerAddGalerie_covertures', ['$scope', '$http', '$state', '$modal', '$stateParams', 'fileUpload', function ($scope, $http, $state, $modal, $stateParams, fileUpload) {


		$scope.ok = function () {

			var file = $scope.myFile;

			if ($scope.myFile != undefined) {

				if ($scope.covertures.id == 0) {


					var uploadUrl = API_PATH + "gestion/add_file_covertures";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.covertures.photo = data.file;


						$http.post(API_PATH + 'gestion/ajouter_data_covertures', $scope.covertures)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				} else {


					var uploadUrl = API_PATH + "gestion/add_file_covertures";

					fileUpload.uploadFileToUrl(file, uploadUrl).success(function (data) {

						$scope.covertures.photo = data.file;
						$http.post(API_PATH + 'gestion/editer_couvertures', $scope.covertures)

							.then(function (response) {

								if (response.data.status) {

									$scope.$parent.cancel();

									$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

								} else {

									$scope.$parent.cancel();

								}

							}, function (x) {

								$scope.$parent.cancel();

							});

					});

				}

			} else {

				if ($scope.covertures.id == 0) {


					$scope.covertures.photo = "";

					$http.post(API_PATH + 'gestion/ajouter_data_covertures', $scope.covertures)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				} else {


					$http.post(API_PATH + 'gestion/editer_couvertures', $scope.covertures)

						.then(function (response) {

							if (response.data.status) {

								$scope.$parent.cancel();

								$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

							} else {

								$scope.$parent.cancel();

							}

						}, function (x) {

							$scope.$parent.cancel();

						});

				}

			}

		};

	}])











	//controller cartetype
	.controller('CartetypeController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.cartetype = {};

						$scope.cartetype.nom = '';


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_cartetype', $scope.cartetype)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.cartetype = {};

						$scope.cartetype.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/cartetype_delete', $scope.cartetype)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.cartetype = {};

						var path1 = API_PATH + "gestion/GetInfoCarteType/" + id;

						$http.get(path1).then(function (resp) {

							$scope.cartetype.nom = resp.data.reponse.nom;


							$scope.cartetype.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_cartetype', $scope.cartetype)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//end controller cartetype


	//controller ville
	.controller('VilleController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {


						$scope.ville = {};

						$scope.ville.nom    = '';
						$scope.ville.code_p = '';


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_ville', $scope.ville)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.ville = {};

						$scope.ville.id = id;
						$scope.ok       = function () {

							$http.post(API_PATH + 'gestion/ville_delete', $scope.ville)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						$scope.ville = {};

						var path1 = API_PATH + "gestion/GetInfoVille/" + id;

						$http.get(path1).then(function (resp) {

							$scope.ville.nom = resp.data.reponse.nom;


							$scope.ville.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_ville', $scope.ville)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//end controller ville


	//tags controller
	.controller('TagsController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.langs = {};

						$scope.langs.nom = '';


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_tag', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.langs = {};

						$scope.langs.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/tag_delete', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.langs = {};

						var path1 = API_PATH + "gestion/GetInfotag/" + id;

						$http.get(path1).then(function (resp) {

							$scope.langs.nom = resp.data.reponse.nom;


							$scope.langs.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_tag', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//ctrl fonctions
	.controller('CtrlFonctions', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.souscategorie = {};

						$scope.souscategorie.nom                = '';
						$scope.souscategorie.active             = true;
						$scope.souscategorie.categorie_group_id = 0;
						$scope.souscategorie.fonction           = [];
						var path1                               = API_PATH + "gestion/groupecategorie1/";
						$http.get(path1).then(function (resp) {
							$scope.fonctions = resp.data.data;
						});

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_souscategorie1', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {

						$scope.souscategorie = {};

						$scope.souscategorie.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/souscategorie_delete', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.souscategorie          = {};
						$scope.souscategorie.fonction = [];
						var path1                     = API_PATH + "gestion/groupecategorie1/";
						$http.get(path1).then(function (resp) {
							$scope.fonctions = resp.data.data;


						});
						var path1 = API_PATH + "gestion/GetInfoSousCategorie/" + id;

						$http.get(path1).then(function (resp) {

							$scope.souscategorie.nom    = resp.data.reponse.nom;
							$scope.souscategorie.active = resp.data.reponse.active;
							//$scope.souscategorie.fonction=[resp.data.items];
							$scope.souscategorie.id     = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/editer_souscategorie', $scope.souscategorie)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};

	}])
	//ctrl commpetence
	.controller('CtrlCompetence', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.langs = {};

						$scope.langs.nom = '';


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_competence', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {

						$scope.langs    = {};
						$scope.langs.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/competence_delete', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.langs = {};

						var path1 = API_PATH + "gestion/GetInfoCompetence/" + id;

						$http.get(path1).then(function (resp) {

							$scope.langs.nom = resp.data.reponse.nom;


							$scope.langs.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_competence', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};

	}])
	//ctrl secteur
	.controller('CtrlSecteurActivite', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.langs = {};

						$scope.langs.nom = '';


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_secteur', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {

						$scope.langs    = {};
						$scope.langs.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/secteur_delete', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.langs = {};

						var path1 = API_PATH + "gestion/GetInfoSecteur/" + id;

						$http.get(path1).then(function (resp) {

							$scope.langs.nom = resp.data.reponse.nom;


							$scope.langs.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_secteur', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {
											reload: true,
											inherit: false,
											notify: true
										});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}
				]

			});

		};

	}])
	//controller language
	.controller('LanguageController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.langs = {};

						$scope.langs.nom = '';


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_lang', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.langs = {};

						$scope.langs.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/lang_delete', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.langs = {};

						var path1 = API_PATH + "gestion/GetInfoLang/" + id;

						$http.get(path1).then(function (resp) {

							$scope.langs.nom = resp.data.reponse.nom;


							$scope.langs.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_lang', $scope.langs)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//end controller language
	.controller('CtrlPagesContentDetail', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {
		$scope.parent_id = $stateParams.id;

		$scope.open = function (size) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalContent.html',
				resolve: {
					parent_id: function () {
						return $scope.parent_id;
					},
				},
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {
						//envoyer une message au client
						$scope.page             = {};
						$scope.page.title       = '';
						$scope.page.description = '';
						$scope.page.parent_id   = parent_id;

						$scope.ok     = function () {
							$scope.page.description = document.getElementById('content_html').innerHTML;
							$http.post(API_PATH + 'gestion/ajouter_page_content', $scope.page)
								.then(function (response) {
									if (response.data.status) {
										$modalInstance.close();
										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
									} else {
										$modalInstance.close();
									}
								}, function (x) {
									$modalInstance.close();
								});
							//$modalInstance.close();
						};
						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};

		$scope.detail    = function (id) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalDetail.html',
				resolve: {
					parent_id: function () {
						return id;
					},
				},
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {
						//envoyer une message au client

						var path = API_PATH + "gestion/detail_page_content/" + parent_id;
						$http.get(path).then(function (resp) {
							$scope.page             = {};
							$scope.page.title       = resp.data.reponse.title;
							$scope.page.description = resp.data.reponse.description;
						});

						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};
		$scope.supprimer = function (id) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalContentConfirmation.html',

				size: id,
				resolve: {
					id: function () {
						return id;
					},
				},
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {
						//envoyer une message au client
						$scope.admin    = {};
						$scope.admin.id = id;
						$scope.ok       = function () {
							$http.post(API_PATH + 'gestion/admin_delete_content_page', $scope.admin)
								.then(function (response) {
									if (response.data.status) {
										$modalInstance.close();
										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
									} else {
										$modalInstance.close();
									}
								}, function (x) {
									$modalInstance.close();
								});
							//$modalInstance.close();
						};

						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};

		$scope.editer = function (id) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalContent.html',
				resolve: {
					parent_id: function () {
						return id;
					},
				},
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {
						//envoyer une message au client

						var path = API_PATH + "gestion/detail_page_content/" + parent_id;
						$http.get(path).then(function (resp) {
							$scope.page             = {};
							$scope.page.title       = resp.data.reponse.title;
							$scope.page.description = resp.data.reponse.description;
							$scope.page.id          = parent_id;
						});
						$scope.ok = function () {
							$scope.page.description = document.getElementById('content_html').innerHTML;
							console.log($scope.page);
							$http.post(API_PATH + 'gestion/editer_page_content', $scope.page)
								.then(function (response) {
									if (response.data.status) {
										$modalInstance.close();
										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
									} else {
										$modalInstance.close();
									}
								}, function (x) {
									$modalInstance.close();
								});
							//$modalInstance.close();
						};

						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};
	}])
	.controller('CtrlPagesContent', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {
		$scope.open = function (size) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalContent.html',
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state) {
						//envoyer une message au client
						$scope.page             = {};
						$scope.page.title       = '';
						$scope.page.description = '';
						$scope.page.parent_id   = 0;

						$scope.ok     = function () {
							//$scope.page.description= document.getElementById('content_html').innerHTML;
							$http.post(API_PATH + 'gestion/ajouter_page_content', $scope.page)
								.then(function (response) {
									if (response.data.status) {
										$modalInstance.close();
										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
									} else {
										$modalInstance.close();
									}
								}, function (x) {
									$modalInstance.close();
								});
							//$modalInstance.close();
						};
						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};

		$scope.detail = function (id) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalDetail.html',
				resolve: {
					parent_id: function () {
						return id;
					},
				},
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {
						//envoyer une message au client

						var path = API_PATH + "gestion/detail_page_content/" + parent_id;
						$http.get(path).then(function (resp) {
							$scope.page             = {};
							$scope.page.title       = resp.data.reponse.title;
							$scope.page.description = resp.data.reponse.description;
						});

						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};


		$scope.editer = function (id) {
			var modalInstance = $modal.open({
				templateUrl: 'myModalContent.html',
				resolve: {
					parent_id: function () {
						return id;
					},
				},
				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',
					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {
						//envoyer une message au client

						var path = API_PATH + "gestion/detail_page_content/" + parent_id;
						$http.get(path).then(function (resp) {
							$scope.page             = {};
							$scope.page.title       = resp.data.reponse.title;
							$scope.page.description = resp.data.reponse.description;
							$scope.page.id          = parent_id;
						});
						$scope.ok = function () {
							//  $scope.page.description= document.getElementById('content_html').innerHTML;
							console.log($scope.page);
							$http.post(API_PATH + 'gestion/editer_page_content', $scope.page)
								.then(function (response) {
									if (response.data.status) {
										$modalInstance.close();
										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});
									} else {
										$modalInstance.close();
									}
								}, function (x) {
									$modalInstance.close();
								});
							//$modalInstance.close();
						};

						$scope.cancel = function () {
							$modalInstance.dismiss('cancel');
						};
					}]
			});
		};
	}])
	//controller admin
	.controller('AdminController', ['$scope', '$http', '$state', '$modal', '$stateParams', function ($scope, $http, $state, $modal, $stateParams) {


		$scope.open = function (size) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				size: size,

				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'parent_id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, parent_id) {

						//envoyer une message au client

						$scope.admin = {};

						$scope.admin.nom      = '';
						$scope.admin.prenom   = '';
						$scope.admin.email    = '';
						$scope.admin.password = '';

						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/ajouter_data_admin', $scope.admin)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.supprimer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContentConfirmation.html',


				size: id,

				resolve: {

					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.admin = {};

						$scope.admin.id = id;


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/admin_delete', $scope.admin)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									} else {

										$modalInstance.close();

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};


		$scope.editer = function (id) {

			var modalInstance = $modal.open({

				templateUrl: 'myModalContent.html',


				resolve: {

					parent_id: function () {

						return $scope.parent_id;

					},


					id: function () {

						return id;

					},

				},

				controller: ['$scope', '$stateParams', '$timeout', '$modalInstance', '$rootScope', '$sce', '$state', 'id',

					function ($scope, $stateParams, $timeout, $modalInstance, $rootScope, $sce, $state, id) {


						$scope.admin = {};

						var path1 = API_PATH + "gestion/GetInfoAdmin/" + id;

						$http.get(path1).then(function (resp) {

							$scope.admin.nom = resp.data.reponse.nom;

							$scope.admin.prenom   = resp.data.reponse.prenom;
							$scope.admin.email    = resp.data.reponse.email;
							$scope.admin.password = resp.data.reponse.password;

							$scope.admin.id = id;


						});


						$scope.ok = function () {

							$http.post(API_PATH + 'gestion/edit_admin', $scope.admin)

								.then(function (response) {

									if (response.data.status) {

										$modalInstance.close();

										$state.transitionTo($state.current, $stateParams, {reload: true, inherit: false, notify: true});

									}

								}, function (x) {

									$modalInstance.close();

								});

							//$modalInstance.close();

						};


						$scope.cancel = function () {

							$modalInstance.dismiss('cancel');

						};

					}]

			});

		};

	}])
	//end controller admin


	.controller('SigninFormControllers', ['$scope', '$rootScope', '$http', '$state', '$localStorage', function ($scope, $rootScope, $http, $state, $localStorage) {

		$scope.user = {};

		$scope.authError = null;

		$scope.login = function () {

			$scope.authError = null;

			// Try to login

			$http.post(API_PATH + 'gestion/connexion', {login: $scope.user.login, password: $scope.user.password})

				.then(function (response) {

					if (response.data.status) {

						$rootScope.nom    = response.data.reponse_request.nom + ' ' + response.data.reponse_request.prenom;
						$localStorage.nom = response.data.reponse_request.nom + ' ' + response.data.reponse_request.prenom;
						$state.go('app.dashboard-v1');
					} else {
						if (response.data.error_message)
							$scope.authError = response.data.error_message;
						else
							$scope.authError = 'Email or Password not right';


					}

				}, function (x) {

					$scope.authError = 'Server Error';

				});

		};

	}])

	.controller('controller_logout', ['$scope', '$http', '$state', '$localStorage', function ($scope, $http, $state, $localStorage) {

		var path = API_PATH + "gestion/lougout/";
		$http.get(path).then(function (resp) {
			if (resp.data.status) {
				$state.go('login');
			}
		});
	}])


;