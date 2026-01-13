<x-filament::page>
    <h2 class="text-xl font-bold mb-4">
        Workspace Renja – {{ $record->opd->nama_opd }} ({{ $record->tahun }})
    </h2>

    @foreach ($renja->sections as $section)
        <div class="mb-6 border rounded-lg p-4">
            <h3 class="font-semibold text-lg mb-2">
                Bab {{ $section->kode_bab }} – {{ $section->judul }}
            </h3>
            @foreach ($section->subsections as $sub)
                @php
                    $block = $sub->contentBlock;
                    $isFinal = $sub->status === 'final';
                    $isLocked = $isFinal || ($block && $block->manual_locked);
                @endphp

                <div class="pl-4 py-3 border-l mb-3 {{ $isFinal ? 'bg-green-50' : '' }}">
                    {{-- HEADER --}}
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <strong>{{ $sub->kode_subbab }}</strong>
                            {{ $sub->judul }}

                            @if ($isFinal)
                                <span class="ml-2 text-xs font-semibold text-green-700">FINAL</span>
                            @else
                                <span class="ml-2 text-xs text-gray-500">DRAFT</span>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            @if (!$isFinal)
                                <x-filament::button size="xs"
                                    wire:click="updateStatus({{ $sub->id }}, 'final')">
                                    Final
                                </x-filament::button>
                            @else
                                <x-filament::button size="xs" color="gray" disabled>
                                    Final
                                </x-filament::button>
                            @endif
                        </div>
                    </div>

                    {{-- EDITOR --}}
                    @if ($isLocked)
                        <textarea class="w-full border rounded p-2 text-sm bg-gray-100" rows="4" disabled>{{ $this->contents[$sub->id] ?? '' }}</textarea>
                    @else
                        <textarea class="w-full border rounded p-2 text-sm" rows="4" wire:model.defer="contents.{{ $sub->id }}"></textarea>
                    @endif

                    {{-- ACTION --}}
                    <div class="flex gap-2 mt-2">
                        @if (!$isFinal)
                            <x-filament::button size="xs" wire:click="saveContent({{ $sub->id }})">
                                Simpan
                            </x-filament::button>

                            <x-filament::button size="xs"
                                color="{{ $block && $block->manual_locked ? 'warning' : 'gray' }}"
                                wire:click="toggleLock({{ $sub->id }})">
                                {{ $block && $block->manual_locked ? 'Unlock Manual' : 'Lock Manual' }}
                            </x-filament::button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="flex gap-3 mt-6">
        <x-filament::button wire:click="generateDraft">
            Generate Draft
        </x-filament::button>
        <x-filament::button color="success" wire:click="finalizeRenja" :disabled="!$this->canFinalize()">
            Finalisasi Renja
        </x-filament::button>
        <x-filament::button color="success" wire:click="exportDocx">
            Export DOCX
        </x-filament::button>


    </div>
</x-filament::page>
