@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Welcome Card -->
        <div class="bg-gradient-to-br from-blue-800 to-purple-600 border border-gray-700 rounded-lg shadow-lg overflow-hidden mb-8 relative transition-transform transform hover:scale-105 duration-300">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-800 to-blue-600 opacity-80"></div>
            <div class="p-8 relative z-10">
                <h1 class="text-5xl font-bold mb-4 text-center text-white animate__animated animate__fadeIn">Welcome to Fundraising</h1>
                <p class="mb-6 text-white text-center text-lg animate__animated animate__fadeIn animate__delay-1s">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias hic voluptas harum, dicta laborum nam deleniti numquam odio deserunt ducimus nobis recusandae impedit asperiores laboriosam culpa, quae aperiam. Deleniti, doloribus.</p>

                <section class="mt-12 flex flex-col lg:flex-row gap-6">
                    <!-- Get Donation Card -->
                    <div class="flex-shrink-0 w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg shadow-lg overflow-hidden relative transition-transform transform hover:scale-105 duration-300 animate__animated animate__fadeIn animate__delay-2s">
                        <div class="p-8 flex items-center w-full">
                            <div class="flex-shrink-0 mr-6">
                                <svg class="w-16 h-16 text-white animate__animated animate__bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9m-9 0H3m-1 4h20M3 4a1 1 0 00-1 1v14a1 1 0 001 1h20a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-semibold mb-2">Get Donation</h3>
                                <p class="text-lg mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quo, iure corrupti dolores doloribus, quas porro similique deleniti hic iste debitis saepe illum accusantium rem laborum rerum blanditiis ipsam eius cum.</p>
                                <a href="{{ route('fundhere') }}" class="bg-white text-red-600 hover:bg-gray-200 px-6 py-3 rounded-lg font-semibold transition-colors duration-300">Get Donation</a>
                            </div>
                        </div>
                        <svg class="absolute top-0 right-0 w-24 h-24 text-red-300 opacity-50 transform -translate-x-1/2 translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7m-7 0H4m-1 4h20M4 4a1 1 0 00-1 1v14a1 1 0 001 1h20a1 1 0 001-1V5a1 1 0 00-1-1H4z" />
                        </svg>
                    </div>

                    <!-- Donate Card -->
                    <div class="flex-shrink-0 w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg shadow-lg overflow-hidden relative transition-transform transform hover:scale-105 duration-300 animate__animated animate__fadeIn animate__delay-3s">
                        <div class="p-8 flex items-center w-full">
                            <div class="flex-shrink-0 mr-6">
                                <svg class="w-16 h-16 text-white animate__animated animate__bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9m-9 0H3m-1 4h20M3 4a1 1 0 00-1 1v14a1 1 0 001 1h20a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-semibold mb-2">Donate</h3>
                                <p class="text-lg mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi impedit iure officia repellendus doloribus autem quo alias, molestiae praesentium! Et obcaecati atque ad necessitatibus reiciendis unde itaque fugiat dolores harum.</p>
                                <a href="{{ route('allfunds') }}" class="bg-white text-red-600 hover:bg-gray-200 px-6 py-3 rounded-lg font-semibold transition-colors duration-300">Donate</a>
                            </div>
                        </div>
                        <svg class="absolute top-0 right-0 w-24 h-24 text-red-300 opacity-50 transform -translate-x-1/2 translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7m-7 0H4m-1 4h20M4 4a1 1 0 00-1 1v14a1 1 0 001 1h20a1 1 0 001-1V5a1 1 0 00-1-1H4z" />
                        </svg>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <style>
        /* Animate.css for animations */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
    </style>
@endsection
