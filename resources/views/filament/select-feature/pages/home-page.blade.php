<x-filament-panels::page>
    <form
        action="/home-page"
        method="GET"
    >
        <x-filament::fieldset>
            <x-slot name="label">
                Enter your phone number
            </x-slot>
            <x-filament::input.wrapper>
                <x-filament::input
                    type="text"
                    wire:model="phone"
                    name="phone"
                    maxlength="10"
                />
            </x-filament::input.wrapper>
        </x-filament::fieldset>
        <x-filament::button
            type="submit"
            color="rose"
        >
            Submit
        </x-filament::button>

    </form>
    @forelse($projectList as $index => $project)
    <ol>
        <li>
            <x-filament::link :href="route('proposal', ['project' => $project])">
                <span style="min-width: 20px !important; display: inline-block;">
                    {{$index +1}}.
                </span>
                {{$project->name}}
            </x-filament::link>
        </li>
    </ol>
    @empty
    <x-filament::empty-state>
        <x-slot name="heading">
            @if(request()->phone)
            no project found
            @else
            Search your project by your phone number
            @endif
        </x-slot>
    </x-filament::empty-state>
    @endforelse
    <div
        class=""
        style="position: fixed; bottom: 0; right: 0;"
    >
        <a href="/admin">&copy</a> {{ now()->year }} Kawnek Enterprise
    </div>
</x-filament-panels::page>