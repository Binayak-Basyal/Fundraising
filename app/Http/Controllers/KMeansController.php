<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Donation;

class KMeansController extends Controller
{

    public function index(Request $request)
    {
        $type = $request->input('type', 'one_time');
        
        // Fetch users and their donation data based on the selected type
        $data = $this->fetchUserData($type);

        // Number of clusters
        $k = 3;

        // Perform K-Means clustering
        $centroids = $this->initializeCentroids($data, $k);
        $clusters = $this->performKMeans($data, $centroids, $k);

        // Fetch user details and donations for each cluster
        foreach ($clusters as &$cluster) {
            foreach ($cluster as &$user) {
                $userDetails = User::find($user['user_id']);
                $user['name'] = $userDetails->name;
                $user['email'] = $userDetails->email;
                $user['donations'] = Donation::where('user_id', $user['user_id'])->sum('amount');
            }
        }

        $allDonors = $this->fetchAllDonors($type);

        return view('admin.kmeans', compact('clusters', 'allDonors', 'type'));
    }

    private function fetchUserData($type)
    {
        $query = DB::table('users')
            ->leftJoin('donations', 'users.id', '=', 'donations.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', DB::raw('COUNT(donations.id) as donations_count'))
            ->groupBy('users.id', 'users.first_name', 'users.last_name');

        switch ($type) {
            case 'frequent':
                $query->havingRaw('COUNT(donations.id) > 1');
                break;
            case 'fund_creator':
                $query->join('funds', 'users.id', '=', 'funds.id');
                break;
            default: // one_time
                $query->havingRaw('COUNT(donations.id) = 1');
        }

        return $query->get()->map(function($item) {
            return [
                'user_id' => $item->id,
                'donations_count' => $item->donations_count,
            ];
        })->toArray();
    }
    private function fetchAllDonors($type)
    {
        $query = DB::table('users');

        if ($type == 'fund_creator') {
            $query->join('funds', 'users.email', '=', 'funds.owner_email')
                  ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 
                           'funds.id as fund_id', 'funds.name as fund_name', 'funds.fund_amount', 
                           'funds.start_date', 'funds.end_date', 'funds.category_id', 
                           'funds.details', 'funds.image', 'funds.status')
                  ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email', 
                            'funds.id', 'funds.name', 'funds.fund_amount', 'funds.start_date', 
                            'funds.end_date', 'funds.category_id', 'funds.details', 
                            'funds.image', 'funds.status');
        } else {
            $query->leftJoin('donations', 'users.id', '=', 'donations.user_id')
                  ->leftJoin('funds', 'donations.fund_id', '=', 'funds.id')
                  ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'funds.name as fund_name', DB::raw('COUNT(donations.id) as donations_count'))
                  ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email', 'funds.name');

            if ($type == 'frequent') {
                $query->havingRaw('COUNT(donations.id) > 1');
            } elseif ($type == 'one_time') {
                $query->havingRaw('COUNT(donations.id) = 1');
            }
        }

        return $query->get()->map(function($item) use ($type) {
            $result = [
                'user_id' => $item->id,
                'name' => $item->first_name . ' ' . $item->last_name,
                'email' => $item->email,
                'fund_name' => $item->fund_name,
            ];

            if ($type == 'fund_creator') {
                $result['fund_amount'] = $item->fund_amount;
                $result['start_date'] = $item->start_date;
                $result['end_date'] = $item->end_date;
                $result['category_id'] = $item->category_id;
                $result['details'] = $item->details;
                $result['image'] = $item->image;
                $result['status'] = $item->status;
            } else {
                $result['donations_count'] = $item->donations_count;
            }

            return $result;
        })->toArray();
    }

    private function initializeCentroids($data, $k)
    {
        $centroids = [];
        $keys = array_keys($data);
        shuffle($keys);

        for ($i = 0; $i < $k; $i++) {
            if (isset($keys[$i])) {
                $index = $keys[$i];
                $centroids[] = $data[$index];
            }
        }
        return $centroids;
    }private function performKMeans($data, $centroids, $k)
{
    if (empty($data) || empty($centroids)) {
        return [];
    }

    $maxIterations = 100;
    $epsilon = 0.0001;
    $clusters = [];
    $previousCentroids = [];

    for ($iteration = 0; $iteration < $maxIterations; $iteration++) {
        // Assign clusters
        $clusters = $this->assignClusters($data, $centroids);

        // Update centroids
        $newCentroids = $this->updateCentroids($clusters, $k);

        // Check for convergence
        $converged = true;
        foreach ($centroids as $i => $centroid) {
            if (array_diff_assoc($centroid, $newCentroids[$i])) {
                $converged = false;
                break;
            }
        }

        if ($converged) {
            break;
        }

        $centroids = $newCentroids;
    }

    return $clusters;
    }
    private function assignClusters($data, $centroids)
    {
        $clusters = array_fill(0, count($centroids), []);

        foreach ($data as $point) {
            $distances = [];
            foreach ($centroids as $centroid) {
                $distances[] = $this->calculateDistance($point, $centroid);
            }
            $clusterIndex = array_search(min($distances), $distances);
            $clusters[$clusterIndex][] = $point;
        }

        return $clusters;
    }

    private function updateCentroids($clusters, $k)
    {
        $centroids = [];
        foreach ($clusters as $cluster) {
            if (count($cluster) > 0) {
                $centroid = [
                    'user_id' => null,
                    'donations_count' => 0
                ];
                $count = count($cluster);
                foreach ($cluster as $point) {
                    $centroid['donations_count'] += $point['donations_count'];
                }
                $centroid['donations_count'] /= $count;
                $centroids[] = $centroid;
            }
        }
        // Fill in any missing centroids if necessary
        while (count($centroids) < $k) {
            $centroids[] = ['user_id' => null, 'donations_count' => 0];
        }

        return $centroids;
    }
    private function calculateDistance($point1, $point2)
    {
        return abs($point1['donations_count'] - $point2['donations_count']);
    }

    public function showCluster()
{
    // Assuming $cluster is an array of user IDs and donation counts
    $cluster = [
        ['user_id' => 1, 'donations_count' => 5],
        ['user_id' => 2, 'donations_count' => 3],
        // Add more users as needed
    ];

    // Fetch user details and donations
    foreach ($cluster as &$user) {
        $userDetails = User::find($user['user_id']);
        $user['name'] = $userDetails->name;
        $user['email'] = $userDetails->email;
        $user['donations'] = Donation::where('user_id', $user['user_id'])->sum('amount');
    }

    return view('kmeans', compact('cluster'));
}
}

