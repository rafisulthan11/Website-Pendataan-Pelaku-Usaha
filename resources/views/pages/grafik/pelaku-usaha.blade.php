<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl sm:text-3xl text-slate-800 leading-tight">Grafik Statistik</h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Card (header + content) -->
            <div class="rounded-xl shadow-lg overflow-hidden">
                <!-- Tab Navigation (peta lokasi style) -->
                <div class="bg-blue-600 text-white">
                    <div class="px-6 py-4 lg:px-8">
                        <h1 class="font-extrabold text-xl sm:text-2xl">Statistik Pelaku Usaha</h1>
                    </div>
                </div>

                <!-- Content Area (peta lokasi style) -->
                <div class="bg-white p-4 sm:p-6">
                    <!-- Filter Tahun -->
                    <form method="GET" action="{{ route('grafik.pelaku.usaha') }}" class="mb-6">
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <label class="text-sm font-semibold text-gray-700">Filter Tahun:</label>
                                <select name="tahun" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full sm:w-48">
                                    <option value="">Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                                    </svg>
                                    Filter
                                </button>
                                @if(request('tahun'))
                                    <a href="{{ route('grafik.pelaku.usaha') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm font-medium">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                        </svg>
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- Ringkasan -->
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border-l-4 border-blue-600 p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Ringkasan {{ request('tahun') ? 'Tahun ' . request('tahun') : 'Keseluruhan' }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Pelaku Usaha</p>
                                <p class="text-3xl font-bold text-blue-700">{{ number_format($data['total'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pembudidaya</p>
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($data['pembudidaya'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pengolah</p>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($data['pengolah'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pemasar</p>
                                <p class="text-2xl font-bold text-orange-600">{{ number_format($data['pemasar'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart - Distribusi Pelaku Usaha -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Pelaku Usaha</h3>
                        <div class="w-full mx-auto" style="height: 350px; max-width: 500px;">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>

                    <!-- Bar Chart - Jumlah per Kecamatan -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Jumlah Pelaku Usaha per Kecamatan</h3>
                        <div class="w-full" style="height: 450px;">
                            <canvas id="kecamatanChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pie Chart - Distribusi Pelaku Usaha
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pembudidaya', 'Pengolah', 'Pemasar'],
                    datasets: [{
                        data: [{{ $data['pembudidaya'] }}, {{ $data['pengolah'] }}, {{ $data['pemasar'] }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',   // Blue for Pembudidaya
                            'rgba(16, 185, 129, 0.8)',   // Green for Pengolah
                            'rgba(249, 115, 22, 0.8)'    // Orange for Pemasar
                        ],
                        borderColor: '#fff',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return label + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });

            // Bar Chart - Jumlah per Kecamatan (Grouped)
            const kecamatanCtx = document.getElementById('kecamatanChart').getContext('2d');
            const kecamatanChart = new Chart(kecamatanCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kecamatanData->pluck('nama_kecamatan')) !!},
                    datasets: [
                        {
                            label: 'Pembudidaya',
                            data: {!! json_encode($kecamatanData->pluck('pembudidaya')) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            borderRadius: 4
                        },
                        {
                            label: 'Pengolah',
                            data: {!! json_encode($kecamatanData->pluck('pengolah')) !!},
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 2,
                            borderRadius: 4
                        },
                        {
                            label: 'Pemasar',
                            data: {!! json_encode($kecamatanData->pluck('pemasar')) !!},
                            backgroundColor: 'rgba(249, 115, 22, 0.8)',
                            borderColor: 'rgba(249, 115, 22, 1)',
                            borderWidth: 2,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                },
                                maxRotation: 45,
                                minRotation: 45
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                usePointStyle: true,
                                pointStyle: 'rectRounded'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' pelaku usaha';
                                },
                                afterLabel: function(context) {
                                    // Calculate percentage
                                    const dataIndex = context.dataIndex;
                                    const pembudidaya = context.chart.data.datasets[0].data[dataIndex];
                                    const pengolah = context.chart.data.datasets[1].data[dataIndex];
                                    const pemasar = context.chart.data.datasets[2].data[dataIndex];
                                    const total = pembudidaya + pengolah + pemasar;
                                    if (total > 0) {
                                        const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                                        return percentage + '% dari total kecamatan';
                                    }
                                    return '';
                                }
                            }
                        }
                    }
                }
            });

            // Debounced resize helper for Chart.js
            let resizeTimer = null;
            function scheduleChartResize() {
                if (resizeTimer) clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => { 
                    if (pieChart) pieChart.resize();
                    if (kecamatanChart) kecamatanChart.resize();
                }, 160);
            }

            window.addEventListener('resize', scheduleChartResize);
            window.addEventListener('orientationchange', scheduleChartResize);
            window.addEventListener('sincan.sidebarToggled', scheduleChartResize);
        });
    </script>
    @endpush
</x-app-layout>
