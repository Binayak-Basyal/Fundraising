<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K-Means Clustering Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center">
    <header class="w-full bg-indigo-600 text-white flex justify-between items-center p-4">
        <div class="logo">
            <img src="{{ asset('icons/logo.png') }}" alt="Logo" class="h-10">
        </div>
        <nav class="navbar flex space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-200">Home</a>
            <a href="{{ route('admin.users') }}" class="hover:text-gray-200">Manage Users</a>
            <a href="{{ route('admin.fund.index') }}" class="hover:text-gray-200">Manage Funds</a>
            <a href="{{ route('admin.categories.index') }}" class="hover:text-gray-200">Manage Categories</a>
            <a href="{{ route('admin.kmeans') }}" class="hover:text-gray-200">K-Means Clustering</a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md relative overflow-hidden btn">
                Logout
            </button>
        </form>
    </header>

    <main class="text-center p-6 flex-grow w-full">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">K-Means Clustering Results</h1>

        <div class="mb-6">
            <form action="{{ route('admin.kmeans') }}" method="GET" class="flex justify-center items-center">
                <label for="type" class="mr-2">Select Donor Type:</label>
                <select name="type" id="type" class="p-2 border rounded" onchange="this.form.submit()">
                    <option value="one_time" {{ $type == 'one_time' ? 'selected' : '' }}>One Time Donor</option>
                    <option value="frequent" {{ $type == 'frequent' ? 'selected' : '' }}>Frequent Donor</option>
                    <option value="fund_creator" {{ $type == 'fund_creator' ? 'selected' : '' }}>Fund Creator</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-semibold mb-4">All {{ ucfirst(str_replace('_', ' ', $type)) }}s</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">User ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Fund Name</th>
                                @if($type == 'fund_creator')
                                    <th class="px-4 py-2">Fund Amount</th>
                                    <th class="px-4 py-2">Start Date</th>
                                    <th class="px-4 py-2">End Date</th>
                                    <th class="px-4 py-2">Status</th>
                                @else
                                    <th class="px-4 py-2">Donations Count</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allDonors as $donor)
                                <tr>
                                    <td class="border px-4 py-2">{{ $donor['user_id'] }}</td>
                                    <td class="border px-4 py-2">{{ $donor['name'] }}</td>
                                    <td class="border px-4 py-2">{{ $donor['email'] }}</td>
                                    <td class="border px-4 py-2">{{ $donor['fund_name'] ?? 'N/A' }}</td>
                                    @if($type == 'fund_creator')
                                        <td class="border px-4 py-2">{{ $donor['fund_amount'] }}</td>
                                        <td class="border px-4 py-2">{{ $donor['start_date'] }}</td>
                                        <td class="border px-4 py-2">{{ $donor['end_date'] }}</td>
                                        <td class="border px-4 py-2">{{ $donor['status'] }}</td>
                                    @else
                                        <td class="border px-4 py-2">{{ $donor['donations_count'] }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-semibold mb-4">Clusters Chart</h2>
                <canvas id="clustersChart"></canvas>
            </div>
        </div>

        @if($type != 'fund_creator')
            <div class="max-w-4xl mx-auto mt-6">
                @foreach ($clusters as $index => $cluster)
                    @if (count($cluster) > 0)
                        <h2 class="text-2xl font-semibold mb-4">
                            Cluster {{ $index + 1 }} ({{ ucfirst(str_replace('_', ' ', $type)) }}s)
                        </h2>
                        <ul class="list-disc list-inside text-gray-600 mb-6 text-left">
                            @foreach ($cluster as $user)
                                <li>
                                    User ID: {{ $user['user_id'] }} | 
                                    Name: {{ $user['name'] }} | 
                                    Email: {{ $user['email'] }} | 
                                    Donations Count: {{ $user['donations_count'] }} | 
                                    Total Donation Amount: {{ $user['donations'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
        @endif
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('clustersChart').getContext('2d');
        const datasets = [];
        const colors = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)'];

        @if($type == 'fund_creator')
            const fundData = @json($allDonors);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fundData.map(fund => fund.fund_name),
                    datasets: [{
                        label: 'Fund Amount',
                        data: fundData.map(fund => fund.fund_amount),
                        backgroundColor: colors[0],
                        borderColor: colors[0].replace('0.5', '1'),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Fund Amount'
                            }
                        }
                    }
                }
            });
        @else
            @foreach ($clusters as $index => $cluster)
                datasets.push({
                    label: 'Cluster {{ $index + 1 }}',
                    data: @json($cluster),
                    backgroundColor: colors[{{ $index }} % colors.length],
                    borderColor: colors[{{ $index }} % colors.length].replace('0.5', '1'),
                    borderWidth: 1
                });
            @endforeach

            new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            title: {
                                display: true,
                                text: 'User ID'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Donations Count'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `User ID: ${context.raw.user_id}, Donations: ${context.raw.donations_count}`;
                                }
                            }
                        }
                    }
                }
            });
        @endif
    });
    </script>
</body>
</html>