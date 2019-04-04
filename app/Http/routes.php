<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    //API mobile
    Route::group(['as' => 'api.', 'prefix' => 'api', 'namespace' => 'Site'], function () {
            //web service mobile service
            Route::group(['as' => 'mobileservice.', 'prefix' => 'mobileservice'], function () {
                Route::get('getdatabyparam', ['as' => 'getdatabyparam', 'uses' => 'MobileServiceController@getdatabyparam']);
                Route::get('getlastperaturan', ['as' => 'getlastperaturan', 'uses' => 'MobileServiceController@getlastperaturan']);
                Route::get('getmobilefaq', ['as' => 'getmobilefaq', 'uses' => 'MobileServiceController@getmobilefaq']);
                Route::get('getperaturanbyparam', ['as' => 'getperaturanbyparam', 'uses' => 'MobileServiceController@getperaturanbyparam']);
            });
    });
    //akhir API mobile

    Route::group(['as' => 'mobile.', 'prefix' => 'mobile', 'namespace' => 'Mobile'], function () {
            //web service mobile service
            Route::group(['as' => 'faq.', 'prefix' => 'faq'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'FaqController@index']);
            });
    });

    Route::get('service-to-jdihn', 'Site\JdihnController@getData')->middleware('jdihn.service');
    Route::get('sitemap', 'Site\SitemapController@index');
    Route::get('sitemap/berita', 'Site\SitemapController@berita');
    Route::get('denied', 'Site\HomeController@denied');
    Route::get('sitemap/{bentuk}', 'Site\SitemapController@perBentuk')->where('bentuk', '(permenbumn|semenbumn|kepmenbumn|inmenbumn|etc)');

    Route::group(['middleware' => ['cas.auth']], function(){
        Route::get('/admin', 'Administrasi\DashboardController@index');
        Route::post('/dashboard/getvisitor', 'Administrasi\DashboardController@getVisitor');
        Route::post('/dashboard/getperaturanchart', 'Administrasi\DashboardController@getPeraturanChart');
    });
    
    Route::group(['prefix' => 'adm', 'middleware' => ['cas.auth', 'role:sys_admin', ]], function(){
    
        Route::get('sitemenus', 'Adm\SiteMenuController@index');
        Route::post('sitemenu', 'Adm\SiteMenuController@store');
        Route::delete('sitemenu/{menu}', 'Adm\SiteMenuController@destroy');
        Route::put('sitemenu/{menu}', 'Adm\SiteMenuController@update');
        Route::post('sitemenu/reorder', 'Adm\SiteMenuController@reorder');
        Route::get('sitemenu/getmenutree', 'Adm\SiteMenuController@menutree');
    
        Route::get('menus', 'Adm\MenuController@index');
        Route::post('menu', 'Adm\MenuController@store');
        Route::delete('menu/{menu}', 'Adm\MenuController@destroy');
        Route::put('menu/{menu}', 'Adm\MenuController@update');
        Route::post('menu/reorder', 'Adm\MenuController@reorder');
        Route::get('menu/getmenutree', 'Adm\MenuController@menutree');
        
        Route::get('permissions', 'Adm\PermissionController@index');
        Route::get('permission/{permission}/edit', 'Adm\PermissionController@edit');
        Route::post('permission', 'Adm\PermissionController@store');
        Route::delete('permission/{permission}', 'Adm\PermissionController@destroy');
        Route::put('permission/{permission}', 'Adm\PermissionController@update');
        
        Route::get('roles', 'Adm\RoleController@index');
        Route::get('role/{role}/edit', 'Adm\RoleController@edit');
        Route::post('role', 'Adm\RoleController@store');
        Route::delete('role/{role}', 'Adm\RoleController@destroy');
        Route::put('role/{role}', 'Adm\RoleController@update');

    });

    Route::group(['prefix' => 'administrasi', 'middleware' => ['cas.auth']], function(){
        Route::get('/verifikasi', 'Administrasi\VerifikasiController@index');
        Route::post('/verifikasi/getdatatable', 'Administrasi\VerifikasiController@getDataTable');

        Route::get('/review', 'Administrasi\ReviewController@index');
        Route::get('/review/rekap', 'Administrasi\ReviewController@rekap');
        Route::post('/review/getdatatable', 'Administrasi\ReviewController@getDataTable');
        Route::post('/review/getdatareview', 'Administrasi\ReviewController@getDataReview');
        Route::post('/review/getdatareviewuser', 'Administrasi\ReviewController@getDataReviewUser');
        Route::get('/review/tambah', 'Administrasi\ReviewController@tambah');
        Route::post('/review/tambah', 'Administrasi\ReviewController@store');
        Route::get('/review/{perno?}/stop', 'Administrasi\ReviewController@stop')->where('perno', '([A-Za-z0-9\-\/\./\s/]+)');
        Route::get('/review/{perno?}/review-submit', 'Administrasi\ReviewController@reviewSubmit')->where('perno', '([A-Za-z0-9\-\/\./\s/]+)');
        Route::put('/review/review-submit/{perno?}', 'Administrasi\ReviewController@reviewSimpan')->where('perno', '([A-Za-z0-9\-\/\./\s/]+)');
        Route::get('/review/hide/{perno?}', 'Administrasi\ReviewController@hide')->where('perno', '([A-Za-z0-9\-\/\./\s/]+)');
        Route::get('/review/remove/{perno?}', 'Administrasi\ReviewController@remove')->where('perno', '([A-Za-z0-9\-\/\./\s/]+)');
        Route::get('/review/detail/{review?}', 'Administrasi\ReviewController@detail');
        Route::get('/review/download/{review?}', 'Administrasi\ReviewController@download');
        Route::get('/review/pdf/{file}', 'Administrasi\ReviewController@getPDF');

        Route::get('/kontak', 'Administrasi\KontakKamiController@index');
        Route::post('/kontak/getdatatable', 'Administrasi\KontakKamiController@dataTable');
        
        Route::get('/visi-misi', 'Administrasi\VisiMisiController@index');
        Route::put('/visi-misi', 'Administrasi\VisiMisiController@update');
        
        Route::get('/mukadimah-prepare', 'Administrasi\PrepareController@mukadimah');
        Route::put('/mukadimah-prepare', 'Administrasi\PrepareController@updateMukadimah');

        Route::get('/submit-review', 'Administrasi\PrepareController@index');
        Route::put('/submit-review', 'Administrasi\PrepareController@update');

        Route::get('/disclaimer', 'Administrasi\DisclaimerController@index');
        Route::put('/disclaimer', 'Administrasi\DisclaimerController@update');
        
        Route::get('/beranda', 'Administrasi\BerandaController@index');
        Route::put('/beranda', 'Administrasi\BerandaController@update');
    
        Route::get('sitemap', 'Administrasi\SiteMapController@index');
        Route::post('sitemap', 'Administrasi\SiteMapController@store');
        Route::delete('sitemap/{menu}', 'Administrasi\SiteMapController@destroy');
        Route::put('sitemap/{menu}', 'Administrasi\SiteMapController@update');
        Route::post('sitemap/reorder', 'Administrasi\SiteMapController@reorder');
        Route::get('sitemap/getmenutree', 'Administrasi\SiteMapController@menutree');


        Route::get('users', 'Administrasi\UserController@index');
        Route::get('user/{user}/edit', 'Administrasi\UserController@edit');
        Route::post('user', 'Administrasi\UserController@store');
        Route::delete('user/{user}', 'Administrasi\UserController@destroy');
//        Route::put('user/{user}', 'Adm\UserController@update');
        Route::get('user/cari', 'Administrasi\UserController@cari');
        Route::get('user/downloadPDF', 'Administrasi\UserController@downloadPDF');
        Route::get('user/downloadExcel', 'Administrasi\UserController@downloadExcel');
        Route::post('user/tambah', 'Administrasi\UserController@store');
        Route::post('user/cari', 'Administrasi\UserController@search');
        Route::put('user/update/{user}', 'Administrasi\UserController@updateRoles');
        Route::get('user/detail/{user}', 'Administrasi\UserController@detail');
            
        Route::group(['prefix' => 'peraturan'], function(){
            Route::get('/', 'Administrasi\PeraturanController@index');
            Route::post('/getdatatable', 'Administrasi\PeraturanController@getDataTable');
            Route::get('/tambah', 'Administrasi\PeraturanController@tambah');
            Route::post('/', 'Administrasi\PeraturanController@simpanPeraturan');
            Route::get('/pdf/{file}', 'Administrasi\PeraturanController@getPDF');
            Route::post('/subyek', 'Administrasi\PeraturanController@newSubyek');
            Route::post('/materi', 'Administrasi\PeraturanController@newMateri');
            Route::post('/publish', 'Administrasi\PeraturanController@publish');
            Route::get('/import', 'Administrasi\PeraturanController@importForm');
            Route::post('/import', 'Administrasi\PeraturanController@import');
            Route::post('/savedataimport', 'Administrasi\PeraturanController@saveDataImport');
            
            Route::get('{peraturan?}/verifikasi', 'Administrasi\VerifikasiController@verifikasi')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::put('{peraturan?}/verify', 'Administrasi\VerifikasiController@verify')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');

            Route::get('{peraturan?}/review', 'Administrasi\ReviewController@review')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::put('{peraturan?}/komen', 'Administrasi\ReviewController@editWaktu')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            
            Route::get('{peraturan?}/edit', 'Administrasi\PeraturanController@edit')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::get('{peraturan?}/unduh', 'Administrasi\PeraturanController@unduhPDF')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::put('{peraturan?}', 'Administrasi\PeraturanController@updatePeraturan')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::delete('{peraturan?}', 'Administrasi\PeraturanController@destroyPeraturan')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::get('{peraturan?}/upload', 'Administrasi\PeraturanController@uploadForm')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            Route::post('{peraturan?}/upload', 'Administrasi\PeraturanController@uploadPDF')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
            
            Route::get('autocomplete/{query}', 'Administrasi\PeraturanController@autocomplete');
        });
            
        Route::group(['prefix' => 'berita'], function(){
            Route::get('/', 'Administrasi\BeritaController@index');
            Route::post('/getdatatable', 'Administrasi\BeritaController@dataTable');
            Route::get('/tambah', 'Administrasi\BeritaController@tambah');
            Route::post('/', 'Administrasi\BeritaController@simpan');
            Route::post('/publish', 'Administrasi\BeritaController@publish');
            Route::get('{berita}/edit', 'Administrasi\BeritaController@edit');
            Route::put('{berita}', 'Administrasi\BeritaController@update');
            Route::delete('{berita}', 'Administrasi\BeritaController@destroy');
        });

        Route::group(['prefix' => 'headline'], function(){
            Route::get('/', 'Administrasi\HeadlineController@index');
            Route::post('/getdatatable', 'Administrasi\HeadlineController@dataTable');
            Route::get('/tambah', 'Administrasi\HeadlineController@tambah');
            Route::post('/', 'Administrasi\HeadlineController@simpan');
            Route::post('/publish', 'Administrasi\HeadlineController@publish');
            Route::get('{headline}/edit', 'Administrasi\HeadlineController@edit');
            Route::put('{headline}', 'Administrasi\HeadlineController@update');
            Route::delete('{headline}', 'Administrasi\HeadlineController@destroy');
        });
        Route::group(['prefix' => 'whitelist'], function(){
            Route::get('/', 'Administrasi\WhitelistController@index');
            Route::post('/getdatatable', 'Administrasi\WhitelistController@dataTable');
            Route::get('/tambah', 'Administrasi\WhitelistController@tambah');
            Route::post('/', 'Administrasi\WhitelistController@simpan');
            Route::post('/publish', 'Administrasi\WhitelistController@publish');
            Route::get('{whitelist}/edit', 'Administrasi\WhitelistController@edit');
            Route::put('{whitelist}', 'Administrasi\WhitelistController@update');
            Route::delete('{whitelist}', 'Administrasi\WhitelistController@destroy');
        });
            
        Route::group(['prefix' => 'tautan'], function(){
            Route::get('/', 'Administrasi\TautanController@index');
            Route::post('/getdatatable', 'Administrasi\TautanController@dataTable');
            Route::get('/tambah', 'Administrasi\TautanController@tambah');
            Route::get('{tautan}/edit', 'Administrasi\TautanController@edit');
            Route::post('', 'Administrasi\TautanController@store');
            Route::delete('{tautan}', 'Administrasi\TautanController@destroy');
            Route::put('{tautan}', 'Administrasi\TautanController@update');
        });
        
        Route::group(['prefix' => 'referensi'], function(){
            Route::get('/watermark', 'Administrasi\ReferensiWatermarkController@index');
            Route::post('/watermark', 'Administrasi\ReferensiWatermarkController@index');
            Route::get('/exwatermark', 'Administrasi\ReferensiWatermarkController@exwatermark');
                
            Route::group(['prefix' => 'negara'], function(){
                Route::get('/', 'Administrasi\ReferensiNegaraController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiNegaraController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiNegaraController@tambah');
                Route::get('{negara}/edit', 'Administrasi\ReferensiNegaraController@edit');
                Route::post('', 'Administrasi\ReferensiNegaraController@store');
                Route::delete('{negara}', 'Administrasi\ReferensiNegaraController@destroy');
                Route::put('{negara}', 'Administrasi\ReferensiNegaraController@update');
            });
            
            Route::group(['prefix' => 'instansi'], function(){
                Route::get('/', 'Administrasi\ReferensiInstansiController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiInstansiController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiInstansiController@tambah');
                Route::get('{instansi}/edit', 'Administrasi\ReferensiInstansiController@edit');
                Route::post('', 'Administrasi\ReferensiInstansiController@store');
                Route::delete('{instansi}', 'Administrasi\ReferensiInstansiController@destroy');
                Route::put('{instansi}', 'Administrasi\ReferensiInstansiController@update');
            });
            
            Route::group(['prefix' => 'bentuk'], function(){
                Route::get('/', 'Administrasi\ReferensiBentukController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiBentukController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiBentukController@tambah');
                Route::get('{bentuk}/edit', 'Administrasi\ReferensiBentukController@edit');
                Route::post('', 'Administrasi\ReferensiBentukController@store');
                Route::delete('{bentuk}', 'Administrasi\ReferensiBentukController@destroy');
                Route::put('{bentuk}', 'Administrasi\ReferensiBentukController@update');
            });

            Route::group(['prefix' => 'komentar'], function(){
                Route::get('/', 'Administrasi\ReferensiKomentarController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiKomentarController@dataTable');
                Route::delete('{komentar}', 'Administrasi\ReferensiKomentarController@destroy');
            });
            
            Route::group(['prefix' => 'sumber'], function(){
                Route::get('/', 'Administrasi\ReferensiSumberController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiSumberController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiSumberController@tambah');
                Route::get('{sumber}/edit', 'Administrasi\ReferensiSumberController@edit');
                Route::post('', 'Administrasi\ReferensiSumberController@store');
                Route::delete('{sumber}', 'Administrasi\ReferensiSumberController@destroy');
                Route::put('{sumber}', 'Administrasi\ReferensiSumberController@update');
            });
            
            Route::group(['prefix' => 'kota'], function(){
                Route::get('/', 'Administrasi\ReferensiKotaController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiKotaController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiKotaController@tambah');
                Route::get('{kota}/edit', 'Administrasi\ReferensiKotaController@edit');
                Route::post('', 'Administrasi\ReferensiKotaController@store');
                Route::delete('{kota}', 'Administrasi\ReferensiKotaController@destroy');
                Route::put('{kota}', 'Administrasi\ReferensiKotaController@update');
            });
            
            Route::group(['prefix' => 'status'], function(){
                Route::get('/', 'Administrasi\ReferensiStatusController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiStatusController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiStatusController@tambah');
                Route::get('{status}/edit', 'Administrasi\ReferensiStatusController@edit');
                Route::post('', 'Administrasi\ReferensiStatusController@store');
                Route::delete('{status}', 'Administrasi\ReferensiStatusController@destroy');
                Route::put('{status}', 'Administrasi\ReferensiStatusController@update');
            });
            
            Route::group(['prefix' => 'subyek'], function(){
                Route::get('/', 'Administrasi\ReferensiSubyekController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiSubyekController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiSubyekController@tambah');
                Route::get('{subyek}/edit', 'Administrasi\ReferensiSubyekController@edit');
                Route::post('', 'Administrasi\ReferensiSubyekController@store');
                Route::delete('{subyek}', 'Administrasi\ReferensiSubyekController@destroy');
                Route::put('{subyek}', 'Administrasi\ReferensiSubyekController@update');
            });
            
            Route::group(['prefix' => 'materi'], function(){
                Route::get('/', 'Administrasi\ReferensiMateriController@index');
                Route::post('/getdatatable', 'Administrasi\ReferensiMateriController@dataTable');
                Route::get('/tambah', 'Administrasi\ReferensiMateriController@tambah');
                Route::get('{materi}/edit', 'Administrasi\ReferensiMateriController@edit');
                Route::post('', 'Administrasi\ReferensiMateriController@store');
                Route::delete('{materi}', 'Administrasi\ReferensiMateriController@destroy');
                Route::put('{materi}', 'Administrasi\ReferensiMateriController@update');
            });
            
            Route::group(['prefix' => 'kategoriberita'], function(){
                Route::get('/', 'Administrasi\KategoriBeritaController@index');
                Route::post('/getdatatable', 'Administrasi\KategoriBeritaController@dataTable');
                Route::get('/tambah', 'Administrasi\KategoriBeritaController@tambah');
                Route::get('{kategoriberita}/edit', 'Administrasi\KategoriBeritaController@edit');
                Route::post('', 'Administrasi\KategoriBeritaController@store');
                Route::delete('{kategoriberita}', 'Administrasi\KategoriBeritaController@destroy');
                Route::put('{kategoriberita}', 'Administrasi\KategoriBeritaController@update');
            });
        });
    });
    //Route::get('auth/logout', 'Auth\AuthController@getLogout');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');
    
    Route::get('/', 'Site\HomeController@index');
    Route::get('/cse', 'Site\HomeController@cse');
    Route::get('/visi-misi', 'Site\HomeController@visimisi');
    Route::get('/kontak-kami', 'Site\HomeController@kontak');
    Route::get('/peta-situs', 'Site\HomeController@sitemap');
    Route::post('/kontak-kami', 'Administrasi\KontakKamiController@storeKontak')->middleware('public.menu');
    Route::get('lihat/{peraturan?}', 'Site\HomeController@lihatPeraturan')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
    Route::get('baca/{peraturan?}.pdf', 'Site\HomeController@bacaPDF')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
    Route::get('unduh/{peraturan?}.pdf', 'Site\HomeController@unduhPDF')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
    Route::get('unduh/{peraturan?}.pdf', 'Site\HomeController@unduhPDF')->where('peraturan', '([A-Za-z0-9\-\/\./\s/]+)');
    Route::get('/pencarian', 'Site\HomeController@pencarian');
    Route::get('/{bentuk}', 'Site\HomeController@perBentuk')->where('bentuk', '(permenbumn|semenbumn|kepmenbumn|inmenbumn|etc)');
    
    Route::get('/berita', 'Site\HomeController@bacaBerita');
    Route::get('/prepare', 'Site\HomeController@prepareBumn');
    Route::get('/berita/{berita}', 'Site\HomeController@bacaBerita');
    