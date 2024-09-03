<x-layout>
    @push('styles')
    <style>
        th{
            vertical-align:middle
        }
    </style>
    @endpush
    
    <livewire:purchase-request-create-or-edit :purchase="$purchase" />
</x-layout>