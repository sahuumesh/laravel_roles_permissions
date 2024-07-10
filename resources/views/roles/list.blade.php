<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('roles.create') }}"
                class="bg-slate-700 text-sm rounded-md text-white px-2 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>


            <div class="my-3">
                {{-- {{ $Roles->links() }} --}}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            function deletePermission(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: '{{ route('permissions.destroy') }}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        headers:{
                            'X-CSRF-TOKEN': '{{ csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            window.location.href = "{{route('roles.index')}}"
                        }
                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>
