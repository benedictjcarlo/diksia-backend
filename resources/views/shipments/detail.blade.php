<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Shipment &raquo; {{ $item->donation->title }} by {{ $item->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full rounded overflow-hidden shadow-lg px-6 py-6 bg-white">
                <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
                    <div class="w-full md:w-1/6 px-4 mb-4 md:mb-0">
                        <img src="{{ $item->donation->picturePath }}" alt="" class="w-full rounded">
                    </div>
                    <div class="w-full md:w-5/6 px-4 mb-4 md:mb-0">
                        <div class="flex flex-wrap mb-3">
                            <div class="w-3/6">
                                <div class="text-sm">Donation Title</div>
                                <div class="text-xl font-bold">{{ $item->donation->title }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Deadline</div>
                                <div class="text-xl font-bold">{{ $item->donation->deadline }} hari</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Type</div>
                                <div class="text-xl font-bold">{{ $item->donation->types }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Status</div>
                                <div class="text-xl font-bold">{{ $item->status }}</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-3/6">
                                <div class="text-sm">User Name</div>
                                <div class="text-xl font-bold">{{ $item->user->name }}</div>
                            </div>
                            <div class="w-2/6">
                                <div class="text-sm">Email</div>
                                <div class="text-xl font-bold">{{ $item->user->email }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Phone Number</div>
                                <div class="text-xl font-bold">{{ $item->user->phoneNumber }}</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-3/6">
                                <div class="text-sm">Amount</div>
                                <div class="text-xl font-bold">{{ number_format($item->amount) }} Perangkat</div>
                            </div>
                            <div class="w-2/6">
                                <div class="text-sm">Birth Date</div>
                                <div class="text-xl font-bold">{{ $item->user->birthDate }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm mb-1">Change Status</div>
                                <a href="{{ route('shipment.changeStatus', ['id' => $item->id, 'status' => 'Pending']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                PENDING
                                </a>
                                <a href="{{ route('shipment.changeStatus', ['id' => $item->id, 'status' => 'Diterima']) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                DITERIMA
                                </a>
                                <a href="{{ route('shipment.changeStatus', ['id' => $item->id, 'status' => 'Gagal']) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 rounded block text-center w-full mb-1">
                                GAGAL
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-3/6">
                                <div class="text-sm">Kondisi</div>
                                <div class="text-xl font-bold">{{ $item->kondisi }}</div>
                            </div>
                            <div class="w-2/6">
                                <div class="text-sm">Jenis</div>
                                <div class="text-xl font-bold">{{ $item->jenis }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm mb-1">Merk</div>
                                <div class="text-xl font-bold">{{ $item->merk }}</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <div class="w-3/6">
                                <div class="text-sm">Kendala</div>
                                <div class="text-xl font-bold">{{ $item->kendala }}</div>
                            </div>
                            <div class="w-2/6">
                                <div class="text-sm">Kurir</div>
                                <div class="text-xl font-bold">{{ $item->kurir }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm mb-1">Resi</div>
                                <div class="text-xl font-bold">{{ $item->resi }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>