<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function index()
    {
        // Replace 'YOUR_GITHUB_USERNAME' with your actual GitHub username
        $githubUsername = env('GITHUB_USERNAME', 'taylorotwell');

        $projects = Cache::remember('github_projects', 3600, function () use ($githubUsername) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Laravel-Portfolio-App'
                ])->timeout(10)->get("https://api.github.com/users/{$githubUsername}/repos?sort=updated&per_page=30");
                
                if ($response->successful()) {
                    $repos = $response->json();
                    
                    if (!is_array($repos)) {
                        return [];
                    }

                    return collect($repos)
                        ->filter(fn($repo) => is_array($repo) && !($repo['fork'] ?? false))
                        ->map(function($repo) use ($githubUsername) {
                            return [
                                'name' => (string)($repo['name'] ?? 'Untitled Project'),
                                'description' => (string)($repo['description'] ?? 'A professional software project.'),
                                'url' => (string)($repo['html_url'] ?? '#'),
                                'stars' => (int)($repo['stargazers_count'] ?? 0),
                                'language' => (string)($repo['language'] ?? 'Source'),
                                'image' => "https://opengraph.githubassets.com/1/{$githubUsername}/" . ($repo['name'] ?? ''),
                            ];
                        })
                        ->take(6)
                        ->toArray();
                }
            } catch (\Exception $e) {
                // Log error or handle as needed
            }

            return [
                [
                    'name' => 'simple-inventory-php',
                    'description' => 'A basic item inventory management system built with native PHP and MySQL. Built to learn CRUD operations and database relations.',
                    'url' => 'https://github.com/' . $githubUsername,
                    'stars' => 0,
                    'language' => 'PHP',
                    'image' => "https://opengraph.githubassets.com/1/{$githubUsername}/simple-inventory-php"
                ],
                [
                    'name' => 'cpp-calculator-cli',
                    'description' => 'A simple command-line calculator supporting basic arithmetic operations. Built as my first programming assignment in Grade 10.',
                    'url' => 'https://github.com/' . $githubUsername,
                    'stars' => 0,
                    'language' => 'C++',
                    'image' => "https://opengraph.githubassets.com/1/{$githubUsername}/cpp-calculator-cli"
                ],
                [
                    'name' => 'laravel-student-portal',
                    'description' => 'An ongoing experiment to build a student task tracking application. Learning Laravel controllers, migrations, and routes.',
                    'url' => 'https://github.com/' . $githubUsername,
                    'stars' => 0,
                    'language' => 'PHP',
                    'image' => "https://opengraph.githubassets.com/1/{$githubUsername}/laravel-student-portal"
                ]
            ];
        });

        $profile = Cache::remember('github_profile', 3600, function () use ($githubUsername) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Laravel-Portfolio-App'
                ])->timeout(10)->get("https://api.github.com/users/{$githubUsername}");
                
                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'name' => (string)($data['name'] ?? $githubUsername),
                        'avatar_url' => (string)($data['avatar_url'] ?? ''),
                        'bio' => (string)($data['bio'] ?? 'Software Engineering Student'),
                        'repos' => (int)($data['public_repos'] ?? 0),
                        'followers' => (int)($data['followers'] ?? 0),
                    ];
                }
            } catch (\Exception $e) {
                // Log error or handle as needed
            }
            return [
                'name' => 'Syahfalah Muchtar',
                'avatar_url' => '',
                'bio' => 'Grade XI Software Engineering Student',
                'repos' => 3,
                'followers' => 0,
            ];
        });

        return view('portfolio', compact('projects', 'profile'));
    }
}
