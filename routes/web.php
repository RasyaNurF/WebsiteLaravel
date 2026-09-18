<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\CareerApplicationController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PortfolioImageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SolutionCategoryController;
use App\Http\Controllers\Admin\SolutionController as AdminSolutionController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProjectInquiryController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\BlogController as PublicBlogController;
use App\Http\Controllers\Public\CareerController as PublicCareerController;
use App\Http\Controllers\Public\PortfolioController as PublicPortfolioController;
use App\Http\Controllers\Public\ResourceController as PublicResourceController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Public\SolutionController as PublicSolutionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SitemapController;
use App\Models\Resource;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('maintenance')->name('home');

Route::get('/tentang', AboutController::class)->middleware('maintenance')->name('tentang');
Route::get('/layanan', [PublicServiceController::class, 'index'])->middleware('maintenance')->name('layanan.index');
Route::get('/layanan/{service:slug}', [PublicServiceController::class, 'show'])->middleware('maintenance')->name('layanan.show');
Route::get('/solusi', [PublicSolutionController::class, 'index'])->middleware('maintenance')->name('solusi.index');
Route::get('/solusi/{category:slug}', [PublicSolutionController::class, 'category'])->middleware('maintenance')->name('solusi.category');
Route::get('/solusi/{category:slug}/{solution:slug}', [PublicSolutionController::class, 'show'])->middleware('maintenance')->name('solusi.show');
Route::get('/resources', [PublicResourceController::class, 'index'])->middleware('maintenance')->name('resources.index');
Route::get('/resources/{type}', [PublicResourceController::class, 'type'])->middleware('maintenance')->name('resources.type');
Route::get('/resources/{type}/{resource:slug}', [PublicResourceController::class, 'show'])->middleware('maintenance')->name('resources.show');

foreach (['events' => 'event', 'go-live' => 'go-live', 'whitepaper' => 'whitepaper', 'e-book' => 'ebook', 'news' => 'news'] as $uri => $type) {
    Route::get('/'.$uri, [PublicResourceController::class, 'type'])->defaults('type', $type)->middleware('maintenance')->name('resources.'.$uri);
    Route::get('/'.$uri.'/{resource:slug}', fn (Resource $resource) => app(PublicResourceController::class)->show($type, $resource))->middleware('maintenance')->name('resources.'.$uri.'.show');
}

Route::get('/portfolio', [PublicPortfolioController::class, 'index'])->middleware('maintenance')->name('portfolio.index');
Route::get('/portfolio/{portfolio:slug}', [PublicPortfolioController::class, 'show'])->middleware('maintenance')->name('portfolio.show');
Route::get('/blog', [PublicBlogController::class, 'index'])->middleware('maintenance')->name('blog.index');
Route::get('/blog/{article:slug}', [PublicBlogController::class, 'show'])->middleware('maintenance')->name('blog.show');
Route::get('/karier', [PublicCareerController::class, 'index'])->middleware('maintenance')->name('karier.index');
Route::get('/karier/{career:slug}', [PublicCareerController::class, 'show'])->middleware('maintenance')->name('karier.show');
Route::post('/karier/{career:slug}/lamar', [PublicCareerController::class, 'apply'])->middleware('throttle:5,1')->name('karier.apply');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/kontak', [ChatController::class, 'index'])->name('kontak')->middleware('maintenance');
Route::post('/kontak/chat', [ChatController::class, 'store'])
    ->name('kontak.chat')
    ->middleware('throttle:10,1');
Route::post('/kontak/permintaan', [ProjectInquiryController::class, 'store'])
    ->name('kontak.permintaan')
    ->middleware('throttle:5,1');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/lupa-kata-sandi', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/lupa-kata-sandi', [PasswordResetController::class, 'store'])->name('password.email')->middleware('throttle:5,1');
    Route::get('/atur-ulang-kata-sandi/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/atur-ulang-kata-sandi', [PasswordResetController::class, 'update'])->name('password.update')->middleware('throttle:5,1');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::get('/dashboard', function () {
    return auth()->user()->hasAbility('dashboard.view')
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->name('dashboard')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.ability:dashboard.view'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profil/kata-sandi', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::middleware('admin.ability:lead.view')->group(function () {
        Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
        Route::get('leads/export', [LeadController::class, 'export'])->name('leads.export');
        Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
        Route::put('leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
        Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    });

    Route::middleware('admin.ability:message.view')->group(function () {
        Route::get('pesan', [MessageController::class, 'index'])->name('messages.index');
        Route::get('pesan/{participant}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('pesan/{participant}/balas', [MessageController::class, 'reply'])->name('messages.reply');
        Route::put('pesan/{participant}', [MessageController::class, 'update'])->name('messages.update');
        Route::delete('pesan/{participant}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    Route::middleware('admin.ability:client.view')->group(function () {
        Route::get('klien', [ClientController::class, 'index'])->name('clients.index');
        Route::get('klien/tambah', [ClientController::class, 'create'])->name('clients.create');
        Route::post('klien', [ClientController::class, 'store'])->name('clients.store');
        Route::get('klien/{client}/ubah', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('klien/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('klien/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    });

    Route::middleware('admin.ability:project.view')->group(function () {
        Route::get('proyek', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('proyek/tambah', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('proyek', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('proyek/{project}/ubah', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('proyek/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('proyek/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

    Route::middleware('admin.ability:portfolio.view')->group(function () {
        Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolios.index');
        Route::get('portfolio/tambah', [PortfolioController::class, 'create'])->name('portfolios.create');
        Route::post('portfolio', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::get('portfolio/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');
        Route::get('portfolio/{portfolio}/ubah', [PortfolioController::class, 'edit'])->name('portfolios.edit');
        Route::put('portfolio/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
        Route::delete('portfolio/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
    });

    Route::middleware('admin.ability:service.view')->group(function () {
        Route::get('layanan', [ServiceController::class, 'index'])->name('services.index');
        Route::get('layanan/tambah', [ServiceController::class, 'create'])->name('services.create');
        Route::post('layanan', [ServiceController::class, 'store'])->name('services.store');
        Route::get('layanan/{service}/ubah', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('layanan/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('layanan/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    Route::middleware('admin.ability:solution-category.view')->group(function () {
        Route::get('kategori-solusi', [SolutionCategoryController::class, 'index'])->name('solution-categories.index');
        Route::get('kategori-solusi/tambah', [SolutionCategoryController::class, 'create'])->name('solution-categories.create');
        Route::post('kategori-solusi', [SolutionCategoryController::class, 'store'])->name('solution-categories.store');
        Route::get('kategori-solusi/{solutionCategory}/ubah', [SolutionCategoryController::class, 'edit'])->name('solution-categories.edit');
        Route::put('kategori-solusi/{solutionCategory}', [SolutionCategoryController::class, 'update'])->name('solution-categories.update');
        Route::delete('kategori-solusi/{solutionCategory}', [SolutionCategoryController::class, 'destroy'])->name('solution-categories.destroy');
    });

    Route::middleware('admin.ability:solution.view')->group(function () {
        Route::get('solusi', [AdminSolutionController::class, 'index'])->name('solutions.index');
        Route::get('solusi/tambah', [AdminSolutionController::class, 'create'])->name('solutions.create');
        Route::post('solusi', [AdminSolutionController::class, 'store'])->name('solutions.store');
        Route::get('solusi/{solution}/ubah', [AdminSolutionController::class, 'edit'])->name('solutions.edit');
        Route::put('solusi/{solution}', [AdminSolutionController::class, 'update'])->name('solutions.update');
        Route::delete('solusi/{solution}', [AdminSolutionController::class, 'destroy'])->name('solutions.destroy');
    });

    Route::middleware('admin.ability:resource.view')->group(function () {
        Route::get('resources', [AdminResourceController::class, 'index'])->name('resources.index');
        Route::get('resources/tambah', [AdminResourceController::class, 'create'])->name('resources.create');
        Route::post('resources', [AdminResourceController::class, 'store'])->name('resources.store');
        Route::get('resources/{resource}/ubah', [AdminResourceController::class, 'edit'])->name('resources.edit');
        Route::put('resources/{resource}', [AdminResourceController::class, 'update'])->name('resources.update');
        Route::delete('resources/{resource}', [AdminResourceController::class, 'destroy'])->name('resources.destroy');
    });

    Route::middleware('admin.ability:industry.view')->group(function () {
        Route::get('industri', [IndustryController::class, 'index'])->name('industries.index');
        Route::get('industri/tambah', [IndustryController::class, 'create'])->name('industries.create');
        Route::post('industri', [IndustryController::class, 'store'])->name('industries.store');
        Route::get('industri/{industry}/ubah', [IndustryController::class, 'edit'])->name('industries.edit');
        Route::put('industri/{industry}', [IndustryController::class, 'update'])->name('industries.update');
        Route::delete('industri/{industry}', [IndustryController::class, 'destroy'])->name('industries.destroy');
    });

    Route::middleware('admin.ability:article.view')->group(function () {
        Route::get('artikel', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('artikel/tambah', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('artikel', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('artikel/{article}/ubah', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('artikel/{article}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('artikel/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });

    Route::middleware('admin.ability:testimonial.view')->group(function () {
        Route::get('testimonial', [TestimonialController::class, 'index'])->name('testimonials.index');
        Route::get('testimonial/tambah', [TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('testimonial', [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::get('testimonial/{testimonial}/ubah', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('testimonial/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('testimonial/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    });

    Route::middleware('admin.ability:media.view')->group(function () {
        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::put('media/{medium}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');
    });

    Route::middleware('admin.ability:seo.view')->group(function () {
        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::get('seo/tambah', [SeoController::class, 'create'])->name('seo.create');
        Route::post('seo', [SeoController::class, 'store'])->name('seo.store');
        Route::get('seo/{seo}/ubah', [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo/{seo}', [SeoController::class, 'update'])->name('seo.update');
        Route::delete('seo/{seo}', [SeoController::class, 'destroy'])->name('seo.destroy');
    });

    Route::middleware('admin.ability:settings.view')->group(function () {
        Route::get('pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('pengaturan', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::middleware('admin.ability:company.view')->group(function () {
        Route::get('profil-perusahaan', [CompanyProfileController::class, 'edit'])->name('company.edit');
        Route::put('profil-perusahaan', [CompanyProfileController::class, 'update'])->name('company.update');
    });

    Route::middleware('admin.ability:hero.view')->group(function () {
        Route::get('hero', [HeroController::class, 'index'])->name('heroes.index');
        Route::get('hero/tambah', [HeroController::class, 'create'])->name('heroes.create');
        Route::post('hero', [HeroController::class, 'store'])->name('heroes.store');
        Route::get('hero/{hero}/ubah', [HeroController::class, 'edit'])->name('heroes.edit');
        Route::put('hero/{hero}', [HeroController::class, 'update'])->name('heroes.update');
        Route::delete('hero/{hero}', [HeroController::class, 'destroy'])->name('heroes.destroy');
    });

    Route::middleware('admin.ability:team.view')->group(function () {
        Route::get('tim', [TeamController::class, 'index'])->name('teams.index');
        Route::get('tim/tambah', [TeamController::class, 'create'])->name('teams.create');
        Route::post('tim', [TeamController::class, 'store'])->name('teams.store');
        Route::get('tim/{team}/ubah', [TeamController::class, 'edit'])->name('teams.edit');
        Route::put('tim/{team}', [TeamController::class, 'update'])->name('teams.update');
        Route::delete('tim/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    });

    Route::middleware('admin.ability:blog-category.view')->group(function () {
        Route::get('kategori-blog', [BlogCategoryController::class, 'index'])->name('blog-categories.index');
        Route::get('kategori-blog/tambah', [BlogCategoryController::class, 'create'])->name('blog-categories.create');
        Route::post('kategori-blog', [BlogCategoryController::class, 'store'])->name('blog-categories.store');
        Route::get('kategori-blog/{blogCategory}/ubah', [BlogCategoryController::class, 'edit'])->name('blog-categories.edit');
        Route::put('kategori-blog/{blogCategory}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
        Route::delete('kategori-blog/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
    });

    Route::middleware('admin.ability:career.view')->group(function () {
        Route::get('karier', [CareerController::class, 'index'])->name('careers.index');
        Route::get('karier/tambah', [CareerController::class, 'create'])->name('careers.create');
        Route::post('karier', [CareerController::class, 'store'])->name('careers.store');
        Route::get('karier/{career}/ubah', [CareerController::class, 'edit'])->name('careers.edit');
        Route::put('karier/{career}', [CareerController::class, 'update'])->name('careers.update');
        Route::delete('karier/{career}', [CareerController::class, 'destroy'])->name('careers.destroy');

        Route::get('lamaran', [CareerApplicationController::class, 'index'])->name('career-applications.index');
        Route::get('lamaran/{careerApplication}', [CareerApplicationController::class, 'show'])->name('career-applications.show');
        Route::put('lamaran/{careerApplication}', [CareerApplicationController::class, 'update'])->name('career-applications.update');
        Route::delete('lamaran/{careerApplication}', [CareerApplicationController::class, 'destroy'])->name('career-applications.destroy');
    });

    Route::middleware('admin.ability:portfolio.view')->group(function () {
        Route::post('portfolio/{portfolio}/galeri', [PortfolioImageController::class, 'store'])->name('portfolio-images.store');
        Route::delete('portfolio/{portfolio}/galeri/{image}', [PortfolioImageController::class, 'destroy'])->name('portfolio-images.destroy');
    });

    Route::middleware('admin.ability:user.view')->group(function () {
        Route::get('pengguna', [UserController::class, 'index'])->name('users.index');
        Route::get('pengguna/tambah', [UserController::class, 'create'])->name('users.create');
        Route::post('pengguna', [UserController::class, 'store'])->name('users.store');
        Route::get('pengguna/{user}/ubah', [UserController::class, 'edit'])->name('users.edit');
        Route::put('pengguna/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('pengguna/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
