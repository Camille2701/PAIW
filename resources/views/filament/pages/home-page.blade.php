<x-filament-panels::page>
    <div>
        <form wire:submit="save">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </form>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>