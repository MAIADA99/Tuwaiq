<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Team;
use App\Models\WhyUs;
use App\Models\Client;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\Service;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Models\ExternalFacades;
use App\Models\ManufacturingImage;
use App\Models\ManufacturingVedio;

class HomeController extends Controller
{

    public function home()
    {
        //slider
        $allsliders = Slider::all();
        foreach ($allsliders as $slider) {
            $slider->image = asset('storage/Slider/' . $slider->image);
        }

        //service
        $allservice = Service::latest()->limit(4)->get();

        foreach ($allservice as $service) {
            $service->image = asset('storage/Service/' . $service->image);
        }

        //manufactimage
        $Manufacturingimages = ManufacturingImage::latest()->limit(8)->get();

        foreach ($Manufacturingimages as $Manufacturingimage) {
            $Manufacturingimage->image = asset('storage/ManufacturingImage/' . $Manufacturingimage->image);
        }


        //manufactvedio

        $ManufacturingVediosandcovers = ManufacturingVedio::latest()->limit(4)->get();

        foreach ($ManufacturingVediosandcovers as $ManufacturingVedioandcover) {
            $ManufacturingVedioandcover->vedio = asset('storage/ManufacturingVedioandcover/' . $ManufacturingVedioandcover->id . '/' . $ManufacturingVedioandcover->vedio);
            $ManufacturingVedioandcover->cover = asset('storage/ManufacturingVedioandcover/' . $ManufacturingVedioandcover->id . '/' . $ManufacturingVedioandcover->cover);
        }

        //external facade
        $allfacades = ExternalFacades::latest()->limit(8)->get();
        foreach ($allfacades as $facade) {
            $facade->image = asset('storage/ExternalFacades/' . $facade->image);
        }


        //blog

        $latestBlogs = Blog::latest()->limit(4)->get();
        foreach ($latestBlogs as $blog) {
            $blog->image = asset('storage/Blog/' . $blog->image);
        }

        //client
        $allclients = Client::all();

        foreach ($allclients as $client) {
            $client->image = asset('storage/Clients/' . $client->image);
        }



        return response()->json([
            'allsliders' => $allsliders,
            'allservice' => $allservice,
            'Manufacturingimages' => $Manufacturingimages,
            'videosandcovers' => $ManufacturingVediosandcovers,
            'facades' => $allfacades,
            'latestBlogs' => $latestBlogs,
            'Clients' => $allclients,
        ], 200);
    }

    public function homeaboutus()
    {
        //part1
        $alldata = AboutUs::all();

        foreach ($alldata as $data) {
            $data->image = asset('storage/AboutUs/' . $data->image);
        }

        //part2 whyus
        $allwhyus = WhyUs::all();
        foreach ($allwhyus as $why) {
            $why->image = asset('storage/WhyUs/' . $why->image);
        }


        //part3 team

        $allteam = Team::all();

        foreach ($allteam as $person) {
            $person->image = asset('storage/Team/' . $person->image);
        }


        return response()->json([
            'alldata' => $alldata,
            'allwhy' => $allwhyus,
            'allteam' => $allteam,
        ], 200);
    }
}
