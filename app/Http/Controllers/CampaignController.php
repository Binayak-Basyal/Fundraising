<?php

namespace App\Http\Controllers;

use App\Models\DecisionTree;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected $decisionTree;

    public function __construct()
    {
        $this->decisionTree = new DecisionTree();
    }

    public function showTrainingPage()
    {
        return view('admin.train_campaign_model');
    }

    public function trainModel(Request $request)
    {
        $request->validate([
            'samples' => 'required|array',
            'labels' => 'required|array',
        ]);

        $samples = json_decode($request->input('samples'), true);
        $labels = json_decode($request->input('labels'), true);

        $this->decisionTree->train($samples, $labels);

        return redirect()->route('campaign.train.show')
            ->with('success', 'Model trained successfully!');
    }

    public function showPredictionPage()
    {
        return view('admin.predict_campaign_success');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'sample' => 'required|array',
        ]);

        $sample = json_decode($request->input('sample'), true);
        $prediction = $this->decisionTree->predict($sample);

        return view('admin.prediction_results', ['prediction' => $prediction]);
    }
}
