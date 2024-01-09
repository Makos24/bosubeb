
<x-jet-button wire:click="edit({{ $data->id }})">
{{ __('Edit') }}
</x-jet-button>
<x-jet-danger-button wire:click="delete({{ $data->id }})">
{{ __('Delete') }}
</x-jet-danger-button>

