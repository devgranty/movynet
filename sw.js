// var CACHE_NAME = 'sitename-v1';
// var urlsToCache = [
// '/projects/moovy/',
// '/projects/moovy/index.php',
// '/projects/moovy/view.php',
// '/projects/moovy/search.php',
// '/projects/moovy/404.php',
// '/projects/moovy/assets/css/style.css',
// '/projects/moovy/assets/css/media.style.css',
// '/projects/moovy/assets/js/script.js',
// '/projects/moovy/assets/js/jQuery-2.2.4.min.js'
// ];

// self.addEventListener('install', function(event){
// 	console.log('[ServiceWorker] Install');
// 	event.waitUntil(
// 		caches.open(CACHE_NAME).then(function(cache){
// 			console.log('[ServiceWorker] Caching app shell');
// 			return cache.addAll(urlsToCache);
// 		})
// 	);
// });

// self.addEventListener('fetch', function(event){
// 	event.respondWith(
// 		caches.match(event.request).then(function(response){
// 			if(response){
// 				return response;
// 			}
// 			return fetch(event.request).then(
// 				function(response){
// 					if(!response || response.status != 200 || response.type !== 'basic'){
// 						return response;
// 					}
// 					var responseToCache = response.clone();
// 					caches.open(CACHE_NAME).then(function(cache){
// 						cache.put(event.request, responseToCache);
// 					});
// 					return response;
// 				}
// 			);
// 		})
// 	);
// });

// self.addEventListener('activate', function(event){
// 	var cacheWhitelist = [];
// 	event.waitUntil(
// 		caches.keys().then(function(cacheNames){
// 			return Promise.all(
// 				cacheNames.map(function(cacheName){
// 					if(cacheWhitelist.indexOf(cacheName) === -1){
// 						console.log('[ServiceWorker] Removing old cache', cacheName);
// 						return caches.delete(cacheName);
// 					}
// 				})
// 			);
// 		})
// 	);
// 	return self.clients.claim();
// });
