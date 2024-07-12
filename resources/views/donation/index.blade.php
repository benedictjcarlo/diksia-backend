<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('donation.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create Donation
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">ID</th>
                            <th class="border px-6 py-4">Title</th>
                            <th class="border px-6 py-4">Donation Amount</th>
                            <th class="border px-6 py-4">Donation Needed</th>
                            <th class="border px-6 py-4">Deadline</th>
                            <th class="border px-6 py-4">Types</th>
                            <th class="border px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donation as $item)
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id }}</td>
                                <td class="border px-6 py-4">{{ $item->title }}</td>
                                <td class="border px-6 py-4">{{ number_format($item->donationAmount) }}</td>
                                <td class="border px-6 py-4">{{ number_format($item->donationNeed) }}</td>
                                <td class="border px-6 py-4">{{ $item->deadline }}</td>
                                <td class="border px-6 py-4">{{ $item->types }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('donation.edit', $item->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('donation.destroy', $item->id) }}" method="POST" class="inline-block">
                                        {!! method_field('delete') . csrf_field() !!}
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border text-center p-5">
                                    Data Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $donation->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
