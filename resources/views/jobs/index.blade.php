<x-layout>
    <x-slot:heading>
        Jobs
    </x-slot>
     <div class="space-y-4">
    @foreach ($jobs as $job)
        <a href="/jobs/{{ $job['id'] }}" class="text-blue hover:underline block px-4 py-5 border border-gray-200 rounded-lg">
            <div class="font-bold text-blue-500 text-sm">
                {{ $job->employer->name }}
            </div>
            <div>
            <strong class="text-laracasts">{{ $job['title']}}</strong>: Pays {{ $job['salary']}} per year.
            </div>
        </a>
    @endforeach
    </div>
    <div class="my-8">
        {{ $jobs->links() }}
    </div>
</x-layout>