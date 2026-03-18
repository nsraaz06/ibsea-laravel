<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use App\Models\Event;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\MemberResource;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = MembershipPlan::orderBy('fee_numeric', 'asc')->get();
        $featured_events = Event::where('is_featured', 1)
            ->where('status', 'Upcoming')
            ->orderBy('event_date', 'asc')
            ->get();
        
        $slider_posts = Post::where('status', 'Published')
            ->where('show_on_slider', true)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        $ticker_posts = Post::whereIn('category', ['News', 'Press Release'])
            ->where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        // Fetch All Upcoming Events
        $events = Event::where('status', 'Upcoming')
            ->orderBy('event_date', 'asc')
            ->limit(8)
            ->get();

        $nationalPartners = Gallery::where('category', 'Strategic Partner - National')
            ->orderBy('order', 'asc')
            ->get();

        $internationalPartners = Gallery::where('category', 'Strategic Partner - International')
            ->orderBy('order', 'asc')
            ->get();
        
        // Include MOU in national for now or handle as needed
        $mouPartners = Gallery::where('category', 'Strategic Partner - MOU')
            ->orderBy('order', 'asc')
            ->get();

        $homeResources = MemberResource::where('show_on_home', true)
            ->where('is_active', true)
            ->latest()
            ->get();

        $title = 'IBSEA | Home of International Business and Startups';

        return view('home', compact(
            'title',
            'plans',
            'featured_events',
            'slider_posts',
            'ticker_posts',
            'events',
            'nationalPartners',
            'internationalPartners',
            'mouPartners',
            'homeResources'
        ));
    }
}
