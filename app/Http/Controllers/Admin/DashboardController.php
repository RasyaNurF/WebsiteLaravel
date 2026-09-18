<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Career;
use App\Models\CareerApplication;
use App\Models\ChatParticipant;
use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\ProjectInquiry;
use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'leads' => ProjectInquiry::query()->count(),
            'active_projects' => Project::query()
                ->whereNotIn('status', ['completed'])
                ->count(),
            'portfolios' => Portfolio::query()->count(),
            'services' => Service::query()->count(),
            'articles' => Article::query()->count(),
            'careers' => Career::query()->where('status', PublishStatus::Published->value)->count(),
            'applications' => CareerApplication::query()->where('status', 'new')->count(),
            'unread_messages' => ChatParticipant::query()
                ->where('status', MessageStatus::Unread->value)
                ->count(),
        ];

        $leads = ProjectInquiry::query()
            ->latest()
            ->limit(6)
            ->get();

        $activities = collect()
            ->merge($this->portfolioActivities())
            ->merge($this->leadActivities())
            ->merge($this->articleActivities())
            ->merge($this->projectActivities())
            ->merge($this->careerApplicationActivities())
            ->sortByDesc('at')
            ->take(8)
            ->values();

        $leadStatusSummary = ProjectInquiry::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'stats' => $stats,
            'leads' => $leads,
            'activities' => $activities,
            'leadStatusSummary' => $leadStatusSummary,
            'clientCount' => Client::query()->count(),
        ]);
    }

    private function portfolioActivities(): Collection
    {
        return Portfolio::query()
            ->latest('updated_at')
            ->limit(4)
            ->get()
            ->map(fn (Portfolio $portfolio) => [
                'type' => 'portfolio',
                'title' => 'Portfolio diperbarui',
                'description' => $portfolio->title,
                'url' => route('admin.portfolios.edit', $portfolio),
                'at' => $portfolio->updated_at,
            ]);
    }

    private function leadActivities(): Collection
    {
        return ProjectInquiry::query()
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn (ProjectInquiry $lead) => [
                'type' => 'lead',
                'title' => 'Lead baru masuk',
                'description' => $lead->name.($lead->company ? ' — '.$lead->company : ''),
                'url' => route('admin.leads.show', $lead),
                'at' => $lead->created_at,
            ]);
    }

    private function articleActivities(): Collection
    {
        return Article::query()
            ->latest('updated_at')
            ->limit(3)
            ->get()
            ->map(fn (Article $article) => [
                'type' => 'article',
                'title' => $article->status === PublishStatus::Published
                    ? 'Artikel dipublikasikan'
                    : 'Artikel diperbarui',
                'description' => $article->title,
                'url' => route('admin.articles.edit', $article),
                'at' => $article->published_at ?? $article->updated_at,
            ]);
    }

    private function projectActivities(): Collection
    {
        return Project::query()
            ->latest('updated_at')
            ->limit(3)
            ->get()
            ->map(fn (Project $project) => [
                'type' => 'project',
                'title' => 'Status proyek diperbarui',
                'description' => $project->name.' — '.$project->status->label(),
                'url' => route('admin.projects.edit', $project),
                'at' => $project->updated_at,
            ]);
    }

    private function careerApplicationActivities(): Collection
    {
        return CareerApplication::query()
            ->with('career')
            ->latest()
            ->limit(3)
            ->get()
            ->map(fn (CareerApplication $application) => [
                'type' => 'lead',
                'title' => 'Lamaran baru masuk',
                'description' => $application->name.($application->career ? ' — '.$application->career->title : ''),
                'url' => route('admin.career-applications.show', $application),
                'at' => $application->created_at,
            ]);
    }
}
