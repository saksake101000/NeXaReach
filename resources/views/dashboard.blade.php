@extends('layouts/navigation')
@section('content')

<section class="bg-cover bg-center h-screen bg-blend-darken" style="background-image: url('{{ asset('images/background.jpg') }}');">
    <div class="bg-transparent h-full flex justify-center items-center">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <!-- Main Title -->
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-green-500 md:text-5xl lg:text-6xl dark:text-green-500">
                <span class="text-green-600">Ne</span><span class="text-white">Xa</span> Reach.
            </h1>
            <!-- Sub Title -->
            <h1 class="mb-4 text-2xl font-extrabold tracking-tight leading-none text-white md:text-3xl lg:text-4xl dark:text-white">
                Empowering Your Digital Presence.
            </h1>
            <!-- Description -->
            <p class="mb-8 text-lg font-normal text-yellow-100 lg:text-xl sm:px-16 lg:px-48">
                NeXa Reach: Enhance your brand's digital exposure with strategies that deliver maximum results.
            </p>
            <!-- Button -->
            <div class="space-y-4  md:justify-center md:space-y-0 ">
                <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-green-600 hover:bg-green-600 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Start Now
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>
            <!-- Statistics Section -->
            <div class="mt-12 sm:mt-24 flex flex-col sm:flex-row justify-center gap-8 sm:gap-12">
                <div class="text-white text-lg">
                    <p class="font-semibold text-2xl sm:text-3xl md:text-4xl">&gt;4.5 BLN</p>
                    <p class="text-yellow-100 text-sm sm:text-lg md:text-xl">DAILY TRAFFIC</p>
                </div>
                <div class="text-white text-lg">
                    <p class="font-semibold text-2xl sm:text-3xl md:text-4xl">&gt;240</p>
                    <p class="text-yellow-100 text-sm sm:text-lg md:text-xl">GEO</p>
                </div>
                <div class="text-white text-lg">
                    <p class="font-semibold text-2xl sm:text-3xl md:text-4xl">&gt;16,500</p>
                    <p class="text-yellow-100 text-sm sm:text-lg md:text-xl">CLIENTS PER DAY</p>
                </div>
            </div>
        </div>
    </div>
</section>


    <section id="tentangkami" class="h-screen pt-16">
        <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
            <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">We didn’t reinvent the wheel, we perfected it for social media</h2>
                <p class="mb-4">At NeXa Reach, we are a team of strategists, designers, and developers who focus on elevating your social media presence. We blend creativity with expertise to build and execute impactful branding campaigns that resonate with your audience.</p>
                <p>We understand the fast-paced nature of digital marketing. Small enough to be agile and responsive, but equipped with the skills and tools to scale your brand presence effectively. Whether it’s Instagram posts, TikTok content, or fully integrated social media campaigns, we deliver tailored solutions at the speed you need.</p>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <img class="w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/office-long-2.png" alt="office content 1">
                <img class="mt-4 w-full lg:mt-10 rounded-lg" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/office-long-1.png" alt="office content 2">
            </div>
        </div>
    </section>


 <!-- Katalog Section -->
 <section id="katalog" class="h-screen mb-10">
    <div class="bg-transparent h-full flex justify-center items-center">
        <div class="py-8 px-6 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">Designed for Business Teams Like Yours</h1>
            <p class="text-lg text-gray-500 dark:text-gray-400 mt-4">
                At NeXa Reach, we specialize in helping businesses amplify their social media presence with tailored branding services. Whether you’re looking to create engaging content or build a unique online identity, our solutions are designed to drive long-term growth and economic impact.
            </p>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($katalog as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 flex flex-col justify-between h-full">
                        <div>
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" class="w-full h-64 object-cover mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item->nama }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $item->deskripsi }}</p>
                        </div>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-auto">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <form action="{{ route('katalog.detail', $item->id) }}" method="GET" class="mt-4">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex justify-center items-center w-full py-2 px-5 text-base font-medium text-center text-white rounded-lg bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-900">
                                Lihat Detail
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>





<footer class="bg-white shadow">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logoo.svg') }}" class="h-8" alt="" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap">NeXa Reach</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                <li><a href="#" class="hover:underline me-4 md:me-6">About</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6">Licensing</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center">© 2024 <a href="#" class="hover:underline">NeXa Reach</a>. All Rights Reserved.</span>
    </div>
</footer>


@endsection

